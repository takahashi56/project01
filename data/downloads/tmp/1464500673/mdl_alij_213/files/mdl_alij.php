<?php

/**
 *
 * @copyright    2000-2007 LOCKON CO.,LTD. All Rights Reserved.
 * @version CVS: $Id: 1.0 2006-06-04 06:38:01Z kakinaka $
 * @link        http://www.lockon.co.jp/
 *
 */
require_once(MODULE_REALDIR . "mdl_alij_213/mdl_alij.inc");

//ページ管理クラス
class LC_Page {

    //コンストラクタ
    function LC_Page() {
        //メインテンプレートの指定
        $this->tpl_mainpage = MODULE_REALDIR . 'mdl_alij_213/mdl_alij.tpl';
        //$this->tpl_subtitle = 'アナザーレーン決済';
    }

}

$objPage = new LC_Page();
$objView = new SC_AdminView();
$objQuery = new SC_Query();

// クレジットチェック
lfAlijCheck();

// 認証確認
//$objSess = new SC_Session();
//sfIsSuccess($objSess);
// パラメータ管理クラス
$objFormParam = new SC_FormParam();
$objFormParam = lfInitParam($objFormParam);
// POST値の取得
$objFormParam->setParam($_POST);

// 汎用項目を追加(必須！！)
//sfAlterMemo();

switch ($_POST['mode']) {
    case 'edit':
        // 入力エラー判定
        $objPage->arrErr = lfCheckError();

        // エラーなしの場合にはデータを更新
        if (count($objPage->arrErr) == 0) {
            // データ更新
            //lfUpdPaymentDB();
            // javascript実行
            $objPage->tpl_onload = 'alert("登録完了しました。\n基本情報＞支払方法設定より詳細設定をしてください。"); window.close();';
            // 決済結果受付ファイルのコピー
            copy(MODULE_REALDIR . "mdl_alij_213/alij_recv.php", HTML_PATH . "user_data/alij_recv.php");
        }
        break;
    case 'module_del':
        // 汎用項目の存在チェック
        if (sfColumnExists("dtb_payment", "memo01")) {
            // データの削除フラグをたてる
            $objQuery->query("UPDATE dtb_payment SET del_flg = 1 WHERE module_id = ?", array(MDL_ALIJ_ID));
        }
        break;
    default:
        // データのロード
        lfLoadData();
        break;
}

$objPage->arrForm = $objFormParam->getFormParamList();

$objView->assignobj($objPage);                    //変数をテンプレートにアサインする
$objView->display($objPage->tpl_mainpage);        //テンプレートの出力

function lfAlijCheck() {
    if (!empty($_GET["sitepass"])) {
        global $objPage;
        global $objView;
        global $objQuery;
        require_once(MODULE_REALDIR . "mdl_alij_213/recv.php");
        exit();
    }
}

?>