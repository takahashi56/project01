<?php
/*
 * AutoMetaKeyword
 * Copyright(c) C-Rowl Co., Ltd. All Rights Reserved.
 * http://www.c-rowl.com/
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

/**
 * プラグインのメインクラス
 *
 * @package AutoMetaKeyword
 * @author  C-Rowl Co., Ltd.
 * @version $Id: $
 */
class AutoMetaKeyword extends SC_Plugin_Base {

    /**
     * コンストラクタ
     *
     */
    public function __construct(array $arrSelfInfo) {
        parent::__construct($arrSelfInfo);
    }

    /**
     * インストール
     * installはプラグインのインストール時に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin plugin_infoを元にDBに登録されたプラグイン情報(dtb_plugin)
     * @return void
     */
    function install($arrPlugin) {
        AutoMetaKeyword::insertFreeField();
        // ファイルコピー
        copy(PLUGIN_UPLOAD_REALDIR . "AutoMetaKeyword/logo.png", PLUGIN_HTML_REALDIR . "AutoMetaKeyword/logo.png");
    }

    /**
     * アンインストール
     * uninstallはアンインストール時に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    function uninstall($arrPlugin) {
        // ファイル削除
        SC_Helper_FileManager_Ex::deleteFile(PLUGIN_HTML_REALDIR . "AutoMetaKeyword");
    }


    /**
     * 稼働
     * enableはプラグインを有効にした際に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    function enable($arrPlugin) {
    }

    /**
     * 停止
     * disableはプラグインを無効にした際に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    function disable($arrPlugin) {
    }


    // プラグイン独自の設定データを追加
    function insertFreeField() {
        $objQuery = SC_Query_Ex::getSingletonInstance();
        $sqlval = array();
        $sqlval['free_field1'] = '1';
        $sqlval['free_field2'] = '1';
        $sqlval['update_date'] = 'CURRENT_TIMESTAMP';
        $where = 'plugin_code = ?';
        // UPDATEの実行
        $objQuery->update('dtb_plugin', $sqlval, $where, array('AutoMetaKeyword'));
    }

    /**
     * 商品一覧のメタタグ（Keyword）にカテゴリ名を追加します。
     *
     * @param LC_Page_Products_List $objPage 商品一覧のページオブジェクト
     * @return void
     */
    function setKeywordForList($objPage) {
        $plugin = SC_Plugin_Util_Ex::getPluginByPluginCode('AutoMetaKeyword');
        if ($plugin['free_field1'] != 1) {
            return;
        }

        // カテゴリ名を取得「子カテゴリ名,親カテゴリ名,...」
        $category_id = $objPage->arrSearchData['category_id'];
        $category_keyword = $this->getCatList($category_id);

        // SEO管理で設定されているKeywordを取得
        $seo_keyword = '';
        if (strlen($objPage->arrPageLayout['keyword']) > 0) {
            $seo_keyword = ',' . $objPage->arrPageLayout['keyword'];
        }
        $objPage->arrPageLayout['keyword'] = $category_keyword . $seo_keyword;
    }

    /**
     * 商品詳細のメタタグ（Keyword）に商品名を追加します。
     *
     * @param LC_Page_Products_Detail $objPage 商品一覧のページオブジェクト
     * @return void
     */
    function setKeywordForDetail($objPage) {
        $plugin = SC_Plugin_Util_Ex::getPluginByPluginCode('AutoMetaKeyword');
        if ($plugin['free_field2'] != 1) {
            return;
        }

        // SEO管理で設定されているKeywordを取得
        $seo_keyword = '';
        if (strlen($objPage->arrPageLayout['keyword']) > 0) {
            $seo_keyword = ',' . $objPage->arrPageLayout['keyword'];
        }
        $objPage->arrPageLayout['keyword'] = $objPage->arrProduct['name'] . $seo_keyword;
    }

    /**
     * 親カテゴリーを連結した文字列を取得する.
     *
     * @param integer $category_id カテゴリID
     * @return string 親カテゴリーを連結した文字列
     */
    function getCatList($category_id){
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objDb = new SC_Helper_DB_Ex();
        $arrCatID = $objDb->sfGetParents('dtb_category', 'parent_category_id', 'category_id', $category_id);
        // 逆順にする
        $arrCatID = array_reverse($arrCatID, true);

        $category_list = '';
        $addstr = ',';
        // カテゴリー名称を取得する
        foreach ($arrCatID as $val) {
            $where = 'category_id = ?';
            $category_name = $objQuery->get('category_name', 'dtb_category', $where, array($val));
            $category_list .= $category_name . $addstr;
        }
        // 最後の区切り記号をカットする
        $category_list = substr($category_list, 0, (strlen($category_list)-strlen($addstr)));

        return $category_list;
    }
}
