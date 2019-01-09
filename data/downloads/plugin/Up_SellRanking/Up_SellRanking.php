<?php
/*
 * Up_SellRanking
 * Copyright(c) 2014 Designup All Rights Reserved.
 *
 * http://designup.jp/
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
 * @package Designup
 * @author Designup.jp
 * @version $Id: $
 */
class Up_SellRanking extends SC_Plugin_Base {

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

        // プラグイン
        copy(PLUGIN_UPLOAD_REALDIR . "Up_SellRanking/logo.png", PLUGIN_HTML_REALDIR . "Up_SellRanking/logo.png");
        copy(PLUGIN_UPLOAD_REALDIR . "Up_SellRanking/Up_SellRanking.php", PLUGIN_HTML_REALDIR . "Up_SellRanking/Up_SellRanking.php");

        // ブロック
        copy(PLUGIN_UPLOAD_REALDIR . "Up_SellRanking/templates/plg_Up_SellRanking.tpl", TEMPLATE_REALDIR . "frontparts/bloc/plg_Up_SellRanking.tpl");
        copy(PLUGIN_UPLOAD_REALDIR . "Up_SellRanking/bloc/plg_Up_SellRanking.php", HTML_REALDIR . "frontparts/bloc/plg_Up_SellRanking.php");

        // 初期設定値を挿入
        Up_SellRanking::insertFreeField();

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

        if(SC_Helper_FileManager_Ex::deleteFile(PLUGIN_HTML_REALDIR . "Up_SellRanking/media") === false);
        if(SC_Helper_FileManager_Ex::deleteFile(HTML_REALDIR  . "frontparts/bloc/plg_Up_SellRanking.php") === false);
        if(SC_Helper_FileManager_Ex::deleteFile(TEMPLATE_REALDIR . "frontparts/bloc/plg_Up_SellRanking.tpl") === false);
        if(SC_Helper_FileManager_Ex::deleteFile(PLUGIN_HTML_REALDIR . "Up_SellRanking") === false);

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

        // ブロック登録
        Up_SellRanking::insertBloc($arrPlugin);

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

        // ブロック削除
        Up_SellRanking::deleteBloc($arrPlugin);

    }

    // プラグイン独自の設定データを追加
    function insertFreeField() {
        $objQuery               = SC_Query_Ex::getSingletonInstance();
        $sqlval                 = array();
        $sqlval['free_field1']  = "5";	// free_field1の設定
        $sqlval['free_field2']  = "売上ランキング";  // free_field2の設定
        $sqlval['update_date']  = 'CURRENT_TIMESTAMP';
        $where                  = "plugin_code = ?";

        // UPDATEの実行、array()の中身はプラグイン名
        $objQuery->update('dtb_plugin', $sqlval, $where, array('Up_SellRanking'));
    }

    function insertBloc($arrPlugin) {
        $objQuery = SC_Query_Ex::getSingletonInstance();

        // ブロック情報のセット
        $sqlval_bloc                    = array();
        $sqlval_bloc['device_type_id']  = DEVICE_TYPE_PC;
        $sqlval_bloc['bloc_id']         = $objQuery->max('bloc_id', "dtb_bloc", "device_type_id = " . DEVICE_TYPE_PC) + 1;
        $sqlval_bloc['bloc_name']       = $arrPlugin['plugin_name'];
        $sqlval_bloc['tpl_path']        = "plg_Up_SellRanking.tpl";
        $sqlval_bloc['filename']        = "plg_Up_SellRanking";
        $sqlval_bloc['create_date']     = "CURRENT_TIMESTAMP";
        $sqlval_bloc['update_date']     = "CURRENT_TIMESTAMP";
        $sqlval_bloc['php_path']        = "frontparts/bloc/plg_Up_SellRanking.php";
        $sqlval_bloc['deletable_flg']   = 0;
        $sqlval_bloc['plugin_id']       = $arrPlugin['plugin_id'];

        // ブロック追加
        $objQuery->insert("dtb_bloc", $sqlval_bloc);
    }

    function deleteBloc($arrPlugin) {
        $objQuery   = SC_Query_Ex::getSingletonInstance();

        // ブロック情報のセット
        $arrBlocId  = $objQuery->getCol('bloc_id', "dtb_bloc", "device_type_id = ? AND filename = ?", array(DEVICE_TYPE_PC , "plg_Up_SellRanking"));
        $bloc_id    = (int) $arrBlocId[0];
        $where      = "bloc_id = ? AND device_type_id = ?";

        // DELETE実行
        $objQuery->delete("dtb_bloc", $where, array($bloc_id, DEVICE_TYPE_PC));
        $objQuery->delete("dtb_blocposition", $where, array($bloc_id, DEVICE_TYPE_PC));
    }

}
?>