<?php
/*
 * SEO管理プラグイン
 * Copyright (C) 2013 BLUE STYLE
 * http://bluestyle.jp/
 */


/**
 * プラグインのメインクラス
 *
 * @package Seo
 * @author BLUE STYLE
 */
class Seo extends SC_Plugin_Base {

    private $arrConfig;

    /**
     * コンストラクタ
     */
    public function __construct(array $arrSelfInfo) {
        parent::__construct($arrSelfInfo);

        $this->class_name = get_class($this);

        // プラグイン情報を取得.
        $plugin = SC_Plugin_Util_Ex::getPluginByPluginCode($this->class_name);
        $this->arrConfig = unserialize($plugin['free_field1']);

        $this->this_plugin_upload_realdir = PLUGIN_UPLOAD_REALDIR . $this->class_name . '/';
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
        $objQuery = SC_Query_Ex::getSingletonInstance();
        $objQuery->begin();

        // プラグイン独自の設定データを追加
        $sqlval = array();
        $sqlval['free_field1'] = '';
        $sqlval['update_date'] = 'CURRENT_TIMESTAMP';
        $where = "plugin_code = 'Seo'";
        // UPDATEの実行
        $objQuery->update('dtb_plugin', $sqlval, $where);
        
        $objQuery->commit();

        // 必要なファイルをコピーします.
        if (copy(PLUGIN_UPLOAD_REALDIR . "Seo/copy/logo.png", PLUGIN_HTML_REALDIR . "Seo/logo.png") === false) print_r("失敗");
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
        // メディアディレクトリ削除.
        SC_Helper_FileManager_Ex::deleteFile(PLUGIN_HTML_REALDIR . "Seo"); // TODO エラー処理
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
        // nop
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
        // nop
    }

    /**
     * 処理の介入箇所とコールバック関数を設定
     * registerはプラグインインスタンス生成時に実行されます
     * 
     * @param SC_Helper_Plugin $objHelperPlugin 
     */
    function register(SC_Helper_Plugin $objHelperPlugin) {
        // ヘッダへの追加
        $objHelperPlugin->addAction('LC_Page_Admin_Design_MainEdit_action_before', array($this, 'LC_Page_Admin_Design_MainEdit_action_before'));
        $objHelperPlugin->addAction('prefilterTransform', array(&$this, 'prefilterTransform'));
        $objHelperPlugin->addAction('outputfilterTransform', array(&$this, 'outputfilterTransform'));
    }

    function LC_Page_Admin_Design_MainEdit_action_before($objPage) {
        if (!$_REQUEST['seo']) {
            return;
        }

        require_once $this->this_plugin_upload_realdir . 'class/LC_Page_Admin_Design_Seo.php';

        $objPage = new LC_Page_Admin_Design_Seo();
        register_shutdown_function(array($objPage, 'destroy'));
        $objPage->init();
        $objPage->process();

        exit;
    }

    function prefilterTransform(&$source, LC_Page_Ex $objPage, $filename) {
        if ($filename == 'design/main_edit.tpl') {
            $tpl = file_get_contents($this->this_plugin_upload_realdir . 'templates/admin/design/seo.tpl');
            $source = '<!--{if $tpl_seo}-->' . $tpl . '<!--{else}-->' . $source . '<!--{/if}-->';
        }
    }

    function outputfilterTransform(&$source, LC_Page_Ex $objPage, $filename) {
        if (preg_match('/^LC_Page_Admin_/', get_class($objPage))) {
            $objTransform = new SC_Helper_Transform($source);
            $html = '<li id="navi-basis-seo"><a href="javascript:;" onclick="alert(\'「デザイン管理＞○○＞SEO管理」をご利用ください。\')"><span>SEO管理</span></a></li>';
            $objTransform->select('li#navi-basis-mail', null, false)->insertAfter($html);
            $arrDeviceType = array(DEVICE_TYPE_PC, DEVICE_TYPE_MOBILE, DEVICE_TYPE_SMARTPHONE);
            foreach ($arrDeviceType as $device_type) {
                $html = '<li id="navi-design-seo-' . $device_type . '">'
                    . '<a href="' . ROOT_URLPATH . ADMIN_DIR . 'design/main_edit.php?seo=1&amp;device_type_id=' . $device_type . '">'
                    . '<span>SEO管理</span></a></li>';
                $objTransform->select('li#navi-design-main-' . $device_type, null, false)->insertAfter($html);
            }
            $source = $objTransform->getHTML();
        }
    }
}
