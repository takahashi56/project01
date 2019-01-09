<?php
/*
 * この商品を買った人はこんな商品も買っていますプラグイン
 * Copyright (C) 2014 Nobuhiko Kimoto
 * info@nob-log.info
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/

// {{{ requires
require_once CLASS_EX_REALDIR . 'page_extends/admin/LC_Page_Admin_Ex.php';

class LC_Page_Plugin_Recommendify_Config extends LC_Page_Admin_Ex {

    var $arrForm = array();

    /**
     * 初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();
        $this->tpl_mainpage = PLUGIN_UPLOAD_REALDIR ."Recommendify/config.tpl";
        $this->tpl_subtitle = "この商品を買った人はこんな商品も買っていますプラグイン 設定";
    }

    /**
     * プロセス.
     *
     * @return void
     */
    function process() {
        $this->action();
        $this->sendResponse();
    }

    /**
     * Page のアクション.
     *
     * @return void
     */
    function action() {
        //かならずPOST値のチェックを行う
        $objFormParam = new SC_FormParam_Ex();
        $this->lfInitParam($objFormParam);
        $objFormParam->setParam($_POST);
        $objFormParam->convParam();

        $arrForm = array();
        switch ($this->getMode()) {
        case 'register':
            $arrForm = $objFormParam->getHashArray();
            $this->arrErr = $objFormParam->checkError();
            // エラーなしの場合にはデータを送信
            if (count($this->arrErr) == 0) {
                $this->arrErr = $this->registData($arrForm);
                if (count($this->arrErr) == 0) {
                    SC_Utils_Ex::clearCompliedTemplate();
                    $this->tpl_onload = "alert('設定が完了しました。');";
                }
                // DB登録後の値再表示のため
                $arrForm = $this->loadData();
            } else {
                // エラー時の値の再表示のため
                $arrForm = $objFormParam->getFormParamList();
                $this->arrTitle = $this->lfSetHtmlDispNameArray($objFormParam);
            }
            break;
        default:
            $arrForm = $this->loadData();
            $this->tpl_is_init = true;
            break;
        }
        $this->arrForm = $arrForm;
        // ポップアップ用の画面は管理画面のナビゲーションを使わない
        $this->setTemplate($this->tpl_mainpage);
    }

    /**
     * パラメーター情報の初期化
     *
     * @param object $objFormParam SC_FormParamインスタンス
     *
     * コンバートオプション	意味
     *   r	 「全角」英字を「半角」に変換します。
     *   R	 「半角」英字を「全角」に変換します。
     *   n	 「全角」数字を「半角」に変換します。
     *   N	 「半角」数字を「全角」に変換します。
     *   a	 「全角」英数字を「半角」に変換します。
     *   A	 「半角」英数字を「全角」に変換します （"a", "A" オプションに含まれる文字は、U+0022, U+0027, U+005C, U+007Eを除く U+0021 - U+007E の範囲です）。
     *   s	 「全角」スペースを「半角」に変換します（U+3000 -> U+0020）。
     *   S	 「半角」スペースを「全角」に変換します（U+0020 -> U+3000）。
     *   k	 「全角カタカナ」を「半角カタカナ」に変換します。
     *   K	 「半角カタカナ」を「全角カタカナ」に変換します。
     *   h	 「全角ひらがな」を「半角カタカナ」に変換します。
     *   H	 「半角カタカナ」を「全角ひらがな」に変換します。
     *   c	 「全角カタカナ」を「全角ひらがな」に変換します。
     *   C	 「全角ひらがな」を「全角カタカナ」に変換します。
     *   V	 濁点付きの文字を一文字に変換します。"K", "H" と共に使用します。
     *
     *   //チェックオプション
     *   See class => data/class/SC_CheckError.php
     *
     * @return void
     */
    function lfInitParam(&$objFormParam) {
        // 以下サンプルで設定を入れています。目的に合わせて、修正しお使いください。
        $objFormParam->addParam('表示件数', 'free_field1', INT_LEN, 'n', array('EXIST_CHECK', 'SPTAB_CHECK', 'MAX_LENGTH_CHECK'));
        //$objFormParam->addParam('サンプル２', 'sample2', INT_LEN, 'n', array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
    }

    /**
     * プラグイン設定値をDBから取得.
     *
     * @return void
     */
    function loadData() {
        $arrRet = array();
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $where = "plugin_code = 'Recommendify'";
        $arrData = $objQuery->getRow('*', 'dtb_plugin', $where);
        if (!SC_Utils_Ex::isBlank($arrData['free_field1'])) {
            $arrRet = $arrData;
        }
        $objFormParam = new SC_FormParam_Ex();
        //プラグインの設定画面用のlfInitParam
        $this->lfInitParam($objFormParam);
        //DBに登録された値を登録します
        $objFormParam->setParam($arrRet);
        //addParamされた情報でコンバートします。
        $objFormParam->convParam();
        //変換された値をフォームの設定値で取得
        $arrForm = $objFormParam->getFormParamList();

        // 入力項目のタイトル部分を取得（EXIST_CHECKが設定されている場合、'※必須'までタイトルを作る）
        $this->arrTitle = $this->lfSetHtmlDispNameArray($objFormParam);

        return $arrForm;

    }

    // 画面表示用タイトル生成
    function lfSetHtmlDispNameArray(&$objFormParam) {
        $arrTitle = array();

        foreach ($objFormParam->keyname as $index => $key) {
            $find = false;
            foreach ($objFormParam->arrCheck[$index] as $val) {
                if ($val == 'EXIST_CHECK') {
                    $find = true;
                }
            }
            if ($find) {
                $arrTitle[$key] = $objFormParam->disp_name[$index] . '<span class="attention">*</span>';
            } else {
                $arrTitle[$key] = $objFormParam->disp_name[$index];
            }
        }
        return $arrTitle;
    }

    /**
     * プラグイン設定値をDBに書き込み.
     *
     * @return void
     */
    function registData($arrData) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objQuery->begin();
        // UPDATEする値を作成する。
        $sqlval = array();
        $sqlval['free_field1'] = $arrData['free_field1'];
        $sqlval['free_field2'] = '';
        $sqlval['update_date'] = 'CURRENT_TIMESTAMP';
        $where = "plugin_code = 'Recommendify'";
        // UPDATEの実行
        $objQuery->update('dtb_plugin', $sqlval, $where);
        $objQuery->commit();
    }

}
