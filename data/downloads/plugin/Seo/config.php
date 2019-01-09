<?php
/*
 * SEO管理プラグイン
 * Copyright (C) 2013 BLUE STYLE
 * http://bluestyle.jp/
 */

require_once CLASS_EX_REALDIR . 'page_extends/admin/LC_Page_Admin_Ex.php';

/**
 * 設定クラス
 *
 * @package Seo
 * @author BLUE STYLE
 */
class plg_Seo_LC_Page_Config extends LC_Page_Admin_Ex {

    var $arrForm = array();

    const plugin_code = 'Seo';

    /**
     * 初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();
        $this->setTemplate(PLUGIN_UPLOAD_REALDIR . 'Seo/templates/config.tpl');
        $this->tpl_subtitle = $this::plugin_code;
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
   }

    /**
     * デストラクタ.
     *
     * @return void
     */
    function destroy() {
        parent::destroy();
    }
}

$objPage = new plg_Seo_LC_Page_Config();
register_shutdown_function(array($objPage, 'destroy'));
$objPage->init();
$objPage->process();
