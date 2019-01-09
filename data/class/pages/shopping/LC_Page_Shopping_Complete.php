<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2014 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

require_once CLASS_EX_REALDIR . 'page_extends/LC_Page_Ex.php';
// {{{ requires

require_once(DATA_REALDIR . 'module/Request.php');
require_once (MODULE_REALDIR . 'mdl_alij_213/inc/include.php');

/**
 * ご注文完了 のページクラス.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id:LC_Page_Shopping_Complete.php 15532 2007-08-31 14:39:46Z nanasess $
 */
class LC_Page_Shopping_Complete extends LC_Page_Ex
{
  var $kickobj = false;
    /**
     * Page を初期化する.
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        $this->kickobj = new KickRecv();
    }

    /**
     * Page のプロセス.
     *
     * @return void
     */
    public function process()
    {
        parent::process();
        $this->action();
        $this->sendResponse();
        // プラグインなどで order_id を取得する場合があるため,  ここで unset する
        unset($_SESSION['order_id']);
    }

    /**
     * Page のアクション.
     *
     * @return void
     */
    public function action()
    {
      $this->kickobj->start();
    }

    /**
     * 決済モジュールから遷移する場合があるため, トークンチェックしない.
     */
    public function doValidToken()
    {
        // nothing.
    }
}


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
        
        // 支払いモードチェック
        if( !isset($_SESSION) || !isset($_SESSION['use_module']) ) {
          //セッションに支払いモードなければNG
        }
        if( !$_SESSION['use_module'] ) {
          //支払いモードが クレカじゃなかったら何もしないで画面遷移
          return;
        }
        
        $objQuery = & SC_Query_Ex::getSingletonInstance();
        
        GC_Utils::gfPrintLog("********************************** Alij recv start **********************************", ALIJ_LOG_PATH);

        //_GETの中身を$arrResultに移す
        $arrResult = $_POST;

        //_GETの内容を全てログ保存
        foreach ($arrResult as $key => $val) {
            GC_Utils::gfPrintLog("\t" . $key . " => " . $val, ALIJ_LOG_PATH);
        }

        //UA確認
        $res = $this->checkUserAgent();

        if($res != 0) {
          SC_Utils_Ex::sfDispSiteError(PAGE_ERROR, $objSiteSess);
        }

        //GET内容確認
        $res = $this->checkGet($objQuery, $arrResult);
        if($res != 0){
          SC_Utils_Ex::sfDispSiteError(PAGE_ERROR, $objSiteSess);
        }

        //内容の妥当性
        $res = $this->checkOrderdata($objQuery, $arrResult);

        if($res != 0){
          SC_Utils_Ex::sfDispSiteError(PAGE_ERROR, $objSiteSess);
        }

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
                //exit;
                return -1;
            }
        }
        return 0;
    }

    function checkGet($objQuery, $arrResult) {

        //GETの中身が空ならエラーにする
        if (!(count($arrResult) > 0)) {
            GC_Utils::gfPrintLog("!!!!!!!!!!!!!!!!!! 決済サーバからデータを正しく受け取れませんでした !!!!!!!!!!!!!!!!!!", ALIJ_LOG_PATH);
            GC_Utils::gfPrintLog("********************************** Alij recv end **********************************", ALIJ_LOG_PATH);
            //exit;
            return -1;
        }

        //SiteIdが空ならエラーにする
        if (empty($arrResult["SiteId"])) {
            GC_Utils::gfPrintLog("!!!!!!!!!!!!!!!!!! サイトIDがありません !!!!!!!!!!!!!!!!!!", ALIJ_LOG_PATH);
            GC_Utils::gfPrintLog("********************************** Alij recv end **********************************", ALIJ_LOG_PATH);
            //exit;
            return -2;
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
            //exit;
            return -3;
        }
        return 0;
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
            //exit;
            return -1;
        }

        //お支払い合計と、ALIJから返ってきた金額とが違う場合はエラー
        if ($arrOrder["payment_total"] != $this->amount) {
            GC_Utils::gfPrintLog("!!!!!!!!!!!!!!!!!! お支払い金額が一致しません。 !!!!!!!!!!!!!!!!!!", ALIJ_LOG_PATH);
            GC_Utils::gfPrintLog("********************************** Alij recv end **********************************", ALIJ_LOG_PATH);
            //exit;
            return -2;
        }
        return 0;
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
