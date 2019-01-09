<?php
/**
 * ---------------------------------------------------------------------------------
 * Alij Kick_file 通常決済対応モジュール
 * ---------------------------------------------------------------------------------
 */
class KickRecv {

    var $debug = false;
    var $arrMdlInfo;
    var $uniqid;
    var $payid;
    var $amount;

    function start() {

        $objQuery = & SC_Query_Ex::getSingletonInstance();

        GC_Utils::gfPrintLog("********************************** Alij recv start **********************************", ALIJ_LOG_PATH);

        //_GETの中身を$arrResultに移す
        $arrResult = $_GET;

        //_GETの内容を全てログ保存
        foreach ($arrResult as $key => $val) {
            GC_Utils::gfPrintLog("\t" . $key . " => " . $val, ALIJ_LOG_PATH);
        }

        //UA確認
        $this->checkUserAgent();

        //GET内容確認
        $this->checkGet($objQuery, $arrResult);

        //内容の妥当性
        $this->checkOrderdata($objQuery, $arrResult);

        //保存処理
        $this->ifDoComplete($objQuery, $arrResult);

        GC_Utils::gfPrintLog("********************************** Alij recv end **********************************", ALIJ_LOG_PATH);
    }

    /**
     * ユーザーエージェントチェック
     * ユーザーエージェントが予期しないものの場合処理を中断する
     * デバッグモードのときは実行しない
     */
    function checkUserAgent() {
        if ($this->debug_flag === false) {
            if (!stristr($_SERVER['HTTP_USER_AGENT'], "KickProcess")) {
                GC_Utils::gfPrintLog("!!!!!!!!!!!!!!!!!! Alij CONT useragenterror start !!!!!!!!!!!!!!!!!!", ALIJ_LOG_PATH);
                $tmpArry = $_SERVER;
                foreach ($tmpArry as $key => $val) {
                    GC_Utils::gfPrintLog("\t" . $key . " => " . $val, ALIJ_LOG_PATH);
                }
                GC_Utils::gfPrintLog($_SERVER["REQUEST_METHOD"], ALIJ_LOG_PATH);
                GC_Utils::gfPrintLog("!!!!!!!!!!!!!!!!!! Alijj CONT useragenterror end !!!!!!!!!!!!!!!!!!", ALIJ_LOG_PATH);
                GC_Utils::gfPrintLog("********************************** Alij recv end **********************************", ALIJ_LOG_PATH);
                header("HTTP/1.1 400 Bad Request");
                exit;
            }
        }
    }

    function checkGet($objQuery, $arrResult) {

        //GETの中身が空ならエラーにする
        if (!(count($arrResult) > 0)) {
            GC_Utils::gfPrintLog("!!!!!!!!!!!!!!!!!! 決済サーバからデータを正しく受け取れませんでした !!!!!!!!!!!!!!!!!!", ALIJ_LOG_PATH);
            GC_Utils::gfPrintLog("********************************** Alij recv end **********************************", ALIJ_LOG_PATH);
            exit;
        }

        //SiteIdが空ならエラーにする
        if (empty($arrResult["SiteId"])) {
            GC_Utils::gfPrintLog("!!!!!!!!!!!!!!!!!! サイトIDがありません !!!!!!!!!!!!!!!!!!", ALIJ_LOG_PATH);
            GC_Utils::gfPrintLog("********************************** Alij recv end **********************************", ALIJ_LOG_PATH);
            exit;
        }

        $this->uniqid = $arrResult["order_id"]; // order_temp_id
        $this->payid = $arrResult["payid"];
        $this->amount = $arrResult["Amount"]; // payment_total
        //決済モジュール情報を取得
        $this->arrMdlInfo = $objQuery->select("memo01, memo05", "dtb_payment", "payment_id = ?", array($this->payid));

        //返ってきたSiteIdが登録されているIDと違う場合にはエラー
        if (!in_array($arrResult["SiteId"], $this->arrMdlInfo[0])) {
            GC_Utils::gfPrintLog("!!!!!!!!!!!!!!!!!! サイトIDが違います !!!!!!!!!!!!!!!!!!", ALIJ_LOG_PATH);
            GC_Utils::gfPrintLog("********************************** Alij recv end **********************************", ALIJ_LOG_PATH);
            exit;
        }
    }

    /**
     * 内容の妥当性チェック
     *
     * @param unknown_type $objQuery
     * @param unknown_type $arrResult
     */
    function checkOrderdata($objQuery, $arrResult) {
        //受注情報の取得（初回注文データ）
        $arrOrder = $objQuery->getRow("*", "dtb_order", 'order_id = ?', array($this->uniqid));

        //受注テーブルからデータが取得できなければ、エラー
        if (count($arrOrder) <= 0) {
            GC_Utils::gfPrintLog("!!!!!!!!!!!!!!!!!! 受注テーブルに指定したIDのデータがありません !!!!!!!!!!!!!!!!!!", ALIJ_LOG_PATH);
            GC_Utils::gfPrintLog("********************************** Alij recv end **********************************", ALIJ_LOG_PATH);
            exit;
        }

        //お支払い合計と、ALIJから返ってきた金額とが違う場合はエラー
        if ($arrOrder["payment_total"] != $this->amount) {
            GC_Utils::gfPrintLog("!!!!!!!!!!!!!!!!!! お支払い金額が一致しません。 !!!!!!!!!!!!!!!!!!", ALIJ_LOG_PATH);
            GC_Utils::gfPrintLog("********************************** Alij recv end **********************************", ALIJ_LOG_PATH);
            exit;
        }
    }

    /**
     * 保存処理
     */
    function ifDoComplete($objQuery, $arrResult) {
        $objQuery->begin();
        $result = $this->updateAlijOder($arrResult);
        $objQuery->commit();
        return;
    }

    /**
     * 受注データのアップデートを行う
     */
    function updateAlijOder($arrRequest) {

        switch ($arrRequest['Result']) {
            case "NG":
                $arrVal['status'] = ORDER_CANCEL;
                break;
            case "OK":
                $arrVal['status'] = ORDER_PRE_END;
                $arrVal['del_flg'] = 0;
                break;
            default:
                $arrVal['status'] = ORDER_PAY_WAIT;
        }


        $arrVal['memo02'] = $arrRequest['TransactionId'];
        $objQuery = & SC_Query_Ex::getSingletonInstance();
        
        $objQuery->update("dtb_order", $arrVal, "order_id = ?", array($arrRequest['order_id']));

        $objPurchase = new SC_Helper_Purchase_Ex();
        switch ($arrVal['status']) {
            case ORDER_CANCEL:
                $objPurchase->cancelOrder($arrRequest['order_id']);
                break;

            case ORDER_PRE_END:
                $objPurchase->sendOrderMail($arrRequest['order_id']);
                break;
            default:
        }
        return true;
    }


}
