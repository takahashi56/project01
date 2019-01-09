<?php
/*
 * 会員一括登録プラグイン
 *
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

class CustomerShelfRegistration extends SC_Plugin_Base
{
    /**
     * コンストラクタ
     */
    public function __construct(array $arrSelfInfo)
    {
        parent::__construct($arrSelfInfo);
    }

    /**
     * インストール
     * installはプラグインのインストール時に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param  array $arrPlugin plugin_infoを元にDBに登録されたプラグイン情報(dtb_plugin)
     * @return void
     */
    public function install($arrPlugin)
    {
        // プラグインのロゴ画像をアップ
        if (file_exists(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . "/logo.png")) {
            if(copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . "/logo.png", PLUGIN_HTML_REALDIR . $arrPlugin['plugin_code'] . "/logo.png") === false);
        }
    }

    /**
     * アンインストール
     * uninstallはアンインストール時に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param  array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    public function uninstall($arrPlugin)
    {
        // ロゴ画像削除
        if (file_exists(PLUGIN_HTML_REALDIR .$arrPlugin['plugin_code'] . "/logo.png")) {
            if(SC_Helper_FileManager_Ex::deleteFile(PLUGIN_HTML_REALDIR . $arrPlugin['plugin_code'] . "/logo.png") === false);
        }
    }

    /**
     * 稼働
     * enableはプラグインを有効にした際に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param  array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    public function enable($arrPlugin)
    {
        $code = $arrPlugin['plugin_code'] . '/';
        $filename = 'admin/customer/upload_csv_customer.php';
        if (!@copy(PLUGIN_UPLOAD_REALDIR . $code . $filename, HTML_REALDIR . ADMIN_DIR . 'customer/upload_csv_customer.php')) {
            SC_Utils_Ex::sfDispSiteError(FREE_ERROR_MSG, '', false, 'FILE COPY ERROR: ' . dirname(HTML_REALDIR . ADMIN_DIR . 'customer/upload_csv_customer.php'));
        }
    }

    /**
     * 停止
     * disableはプラグインを無効にした際に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param  array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    public function disable($arrPlugin)
    {
        if(SC_Helper_FileManager_Ex::deleteFile(HTML_REALDIR . ADMIN_DIR . "customer/upload_csv_customer.php") === false);
        //$objQuery =& SC_Query_Ex::getSingletonInstance();
        //$objQuery->delete('dtb_csv', 'csv_id = 9999');
    }

    /**
     * 処理の介入箇所とコールバック関数を設定
     * registerはプラグインインスタンス生成時に実行されます
     *
     * @param SC_Helper_Plugin $objHelperPlugin
     */
    public function register(SC_Helper_Plugin $objHelperPlugin)
    {
        $objHelperPlugin->addAction('prefilterTransform', array(&$this, 'prefilterTransform'), $this->arrSelfInfo['priority']);
        //return parent::register($objHelperPlugin, $priority);
    }

    /**
     * プレフィルタコールバック関数
     *
     * @param string &$source テンプレートのHTMLソース
     * @param  LC_Page_Ex $objPage  ページオブジェクト
     * @param  string     $filename テンプレートのファイル名
     * @return void
     */
    public function prefilterTransform(&$source, LC_Page_Ex $objPage, $filename)
    {
        $objTransform = new SC_Helper_Transform($source);
        $template_dir = PLUGIN_UPLOAD_REALDIR . $this->arrSelfInfo['plugin_code'] .'/templates/admin/';
        switch ($objPage->arrPageLayout['device_type_id']) {
            case DEVICE_TYPE_MOBILE:
            case DEVICE_TYPE_SMARTPHONE:
            case DEVICE_TYPE_PC:
                break;
            case DEVICE_TYPE_ADMIN:
            default:
                //管理画面商品編集画面のテンプレートをフックするサンプル
                /*
                if (strpos($filename, 'products/product.tpl') !== false) {
                    $objTransform->select('table.form tr',1)->insertBefore(file_get_contents($template_dir . 'MakerShelfRegistration.tpl'));
                }
                */
                if (strpos($filename, 'customer/subnavi.tpl') !== false) {
                    $objTransform->select('ul.level1 li', 1)->insertAfter(file_get_contents($template_dir . 'subnavi.tpl'));
                }
                break;
        }
        //トランスフォームされた値で書き換え
        $source = $objTransform->getHTML();
    }
}
