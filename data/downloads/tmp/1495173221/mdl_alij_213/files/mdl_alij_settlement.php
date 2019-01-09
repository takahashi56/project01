<?php

/*
 * card.phpに呼び出される
 */

require_once(DATA_REALDIR . 'module/Request.php');
require_once(CLASS_REALDIR . 'SC_Session.php');
require_once (MODULE_REALDIR . 'mdl_alij_213/inc/include.php');
require_once (CLASS_EX_REALDIR . 'helper_extends/SC_Helper_DB_Ex.php');

class AlijSettlement extends LC_Page_Ex {

    var $isMobile;
    var $isPc;
    var $isSPhone;
    var $objQuery;
    var $objPurchase;

    function AlijSettlement() {
        $this->httpCacheControl('nocache');
        $this->objQuery = new SC_Query();
        $this->objPurchase = new SC_Helper_Purchase_Ex();
    }

    function init() {

        //transactionidはALIJシステムで予約されているので別の名前で送ったものを入れなおす
        if (isset($_POST['eccube_TransactionId'])) {
            $_POST[TRANSACTION_ID_NAME] = $_POST['eccube_TransactionId'];
        }

        ///data/class/pages/LC_Page.phpが実行されるが
        //トークンチェックにより「不正なページ移動」とみなされるため、実行しない
        //parent::init();
        
        $this->isMobile = SC_MobileUserAgent::isMobile();
        $this->isSPhone = SC_SmartphoneUserAgent::isSmartphone();
        $this->isPc = (!$this->isMobile && !$this->isSPhone );

        //テンプレートの切り分け
        if ($this->isMobile) {
            $this->tpl_mainpage = MDL_ALIJ_TEMPLATE_PATH . 'card_mobile.tpl';
        } elseif ($this->isSPhone) {
            $this->tpl_mainpage = MDL_ALIJ_TEMPLATE_PATH . 'card_sphone.tpl';
        } else {
            $this->tpl_mainpage = MDL_ALIJ_TEMPLATE_PATH . 'card_pc.tpl';
        }

        $this->allowClientCache();
    }

    function process() {

        $objView = SC_MobileUserAgent :: isMobile() ? new SC_MobileView : new SC_SiteView;
        $objSiteSess = new SC_SiteSession();
        $objCartSess = new SC_CartSession();
        $objCustomer = new SC_Customer();
        $objPurchase = new SC_Helper_Purchase_Ex();

        //受注情報を取得する
        $orderData = $objPurchase->getOrder($_SESSION['order_id']);

        // モジュールに関する情報を取得
        $paymentDbData = $this->getPaymentDB($orderData['order_id']);

        switch (isset($_REQUEST['Result']) ? $_REQUEST['Result'] : "") {
            //決済成功で戻ってきた
            case 'OK':
                //order_idの確認
                $lastOrderData = $this->getLastOrderData($orderData['customer_id']);

                if ($lastOrderData['order_id'] !== $orderData['order_id']) {
                    SC_Utils_Ex::sfDispSiteError(PAGE_ERROR);
                    exit;
                }

                //購入完了ページに遷移する
                if ($this->isMobile) {
                    SC_Response_Ex::sendRedirect(MOBILE_SHOPPING_COMPLETE_URLPATH);
                } else {
                    SC_Response_Ex::sendRedirect(SHOPPING_COMPLETE_URLPATH);
                }
                exit;

                break;

            //決済失敗またはキャンセルで戻ってきた場合の処理------------------------------------------
            case 'NG':
                // 受注削除してカートに戻す処理
                $objPurchase->rollbackOrder($orderData['order_id'], ORDER_CANCEL, true);

                //中断を画面に表示する場合はこちらを使用
                //$page->tpl_mainpage = $this->tpl_mainpage;
                //$page->initDisp = true;
                //$page->cancel = true;
                //$page->cancel_msg = "カード決済が中断されました";
                //$objView->assignobj($page);
                //$objView->display(SITE_FRAME);
                //カート画面にリダイレクトする場合はこちらを使用
                SC_Response_Ex::sendRedirect(CART_URLPATH);
                exit;

                break;

            //決済画面遷移前に中断した場合------------------------------------------
            case 'CANCEL':
                // 受注削除してカートに戻す処理
                $objPurchase->rollbackOrder($orderData['order_id'], ORDER_CANCEL, true);

                //中断を画面に表示する場合はこちらを使用
                //$page->tpl_mainpage = $this->tpl_mainpage;
                //$page->initDisp = true;
                //$page->cancel = true;
                //$page->cancel_msg = "カード決済が中断されました";
                //$objView->assignobj($page);
                //$objView->display(SITE_FRAME);
                //カート画面にリダイレクトする場合はこちらを使用
                SC_Response_Ex::sendRedirect(CART_URLPATH);
                exit;

                break;

            //決済前画面から来て、決済画面に進む場合の処理------------------------------------------
            default;
                //html取得
                if (SC_MobileUserAgent :: isMobile()) {
                    $params = $this->lfSendMobileCredit($orderData, $paymentDbData);
                } else {
                    $params = $this->lfSendPcCredit($orderData, $paymentDbData);
                }
                $page->tpl_mainpage = $this->tpl_mainpage;
                $page->initDisp = true;
                $page->cancel = false;
                $page->params = $params;
                $page->order_url = SEND_PARAM_PC_URL;

                $objView->assignobj($page);

                //テンプレートの切り分け
                if ($this->isMobile) {
                    $objView->assignTemplatePath(DEVICE_TYPE_MOBILE);
                } elseif ($this->isSPhone) {
                    $objView->assignTemplatePath(DEVICE_TYPE_SMARTPHONE);
                } else {
                    $objView->assignTemplatePath(DEVICE_TYPE_PC);
                }

                //表示実行
                $objView->display(SITE_FRAME);
                break;
        }
    }

    //データ送信処理(PC)
    function lfSendPcCredit($arrData, $arrPayment) {
        global $objCartSess;
        global $objSiteSess;

        $this->doValidToken();
        $this->setTokenTo();

        //クイックチャージ使用
        if (isset($arrPayment["memo04"]) && $arrPayment["memo04"] == "true"
          && $arrData["customer_id"] !="0" && $arrData["customer_id"]!= "") {


            $tel = $arrData["order_tel01"] . $arrData["order_tel02"] . $arrData["order_tel03"];

            // 送信データ生成
            $arrSendData = array(
                'siteId' => $arrPayment["memo01"],
                'sitePass' => $arrPayment["memo02"],
                'Amount' => $arrData["payment_total"], // 金額
                'mail' => $arrData["order_email"], // メールアドレス
                'order_id' => $arrData["order_id"], // オーダーID
                'TransactionId' => $arrData["order_id"], // オーダーID（決済システムにオーダーを紐づけるため）
                'payid' => $arrData["payment_id"],
                'eccube_TransactionId' => $this->transactionid, //EC-CUBE画面遷移用,
                'CustomerId' => $arrData["customer_id"], //EC-CUBE顧客ID
                'CustomerPass' => $tel//EC-CUBE顧客電話番号
            );
            //クイックチャージ使用なし
        } else {
            // 送信データ生成
            $arrSendData = array(
                'siteId' => $arrPayment["memo01"],
                'sitePass' => $arrPayment["memo02"],
                'Amount' => $arrData["payment_total"], // 金額
                'mail' => $arrData["order_email"], // メールアドレス
                'order_id' => $arrData["order_id"], // オーダーID
                'TransactionId' => $arrData["order_id"], // オーダーID（決済システムにオーダーを紐づけるため）
                'payid' => $arrData["payment_id"],
                'eccube_TransactionId' => $this->transactionid //EC-CUBE画面遷移用
            );
        }


        //送信データのログを取得する
        $this->printLog($arrSendData);

        return $arrSendData;
    }

    // データ送信処理(MOBILE)
    function lfSendMobileCredit($arrData, $arrPayment) {
        global $objCartSess;
        global $objSiteSess;

        $this->doValidToken();
        $this->setTokenTo();

        //クイックチャージ使用
        if (isset($arrPayment["memo04"]) && $arrPayment["memo04"] == "true"
            && $arrData["customer_id"] !="0" && $arrData["customer_id"]!= "") {

            $tel = $arrData["order_tel01"] . $arrData["order_tel02"] . $arrData["order_tel03"];

            // 送信データ生成
            $arrSendData = array(
                'siteId' => $arrPayment["memo01"],
                'sitePass' => $arrPayment["memo02"],
                'Amount' => $arrData["payment_total"], // 金額
                'mail' => $arrData["order_email"], // メールアドレス
                'order_id' => $arrData["order_id"], // オーダーID
                'TransactionId' => $arrData["order_id"], // オーダーID（決済システムにオーダーを紐づけるため）
                'payid' => $arrData["payment_id"],
                'eccube_TransactionId' => $this->transactionid, //EC-CUBE画面遷移用,
                'CustomerId' => $arrData["customer_id"], //EC-CUBE顧客ID
                'CustomerPass' => $tel//EC-CUBE顧客電話番号
            );
            //クイックチャージ使用なし
        } else {
            // 送信データ生成
            $arrSendData = array(
                'siteId' => $arrPayment["memo01"],
                'sitePass' => $arrPayment["memo02"],
                'Amount' => $arrData["payment_total"], // 金額
                'mail' => $arrData["order_email"], // メールアドレス
                'order_id' => $arrData["order_id"], // オーダーID
                'TransactionId' => $arrData["order_id"], // オーダーID（決済システムにオーダーを紐づけるため）
                'payid' => $arrData["payment_id"],
                'eccube_TransactionId' => $this->transactionid //EC-CUBE画面遷移用
            );
        }

        //送信データのログを取得する
        $this->printLog($arrSendData);

        return $arrSendData;
    }

    function printLog($arrSendData) {
        GC_Utils::gfPrintLog("********************************** Alij send start **********************************", ALIJ_LOG_PATH);
        foreach ($arrSendData as $key => $val) {
            GC_Utils::gfPrintLog("\t" . $key . " => " . $val, ALIJ_LOG_PATH);
        }
        GC_Utils::gfPrintLog("********************************** Alij send end **********************************", ALIJ_LOG_PATH);
    }

    //オーダー内容のpayment_idからモジュール情報を取得
    function getPaymentDB($orderId) {
        $arrRet = array();
        $sql = "SELECT " .
                "   dtb_payment.memo01, " .
                "   dtb_payment.memo02, " .
                "   dtb_payment.memo04, " .
                "   dtb_order.order_email, " .
                "   dtb_order.payment_total" .
                " FROM dtb_order " .
                "     LEFT JOIN dtb_payment " .
                "          ON dtb_order.payment_id = dtb_payment.payment_id " .
                " WHERE dtb_order.order_id = ? ";

        $arrRet = $this->objQuery->getall($sql, array($orderId));

        return $arrRet[0];
    }

    //顧客の最終オーダーを取得
    function getLastOrderData($customerId) {
        $arrRet = array();
        $sql = "SELECT " .
                "   order_id,    " .
                "   order_tel01, " .
                "   order_tel02, " .
                "   order_tel03, " .
                "   order_email" .
                " FROM dtb_order " .
                " WHERE" .
                "  customer_id = ? ORDER BY create_date DESC LIMIT 1 ";
        $arrRet = $this->objQuery->getall($sql, array($customerId));

        return $arrRet[0];
    }

}

?>
