<?php
/*
 * AddSearchItem
 * Copyright (C) 2012 Bratech CO.,LTD. All Rights Reserved.
 * http://www.bratech.co.jp/
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

require_once PLUGIN_UPLOAD_REALDIR . "AddSearchItem/plg_AddSearchItem_Util.php";

/**
 * プラグインのメインクラス
 *
 * @package AddSearchItem
 * @author Bratech CO.,LTD.
 * @version $Id: $
 */
class AddSearchItem extends SC_Plugin_Base {

    /**
     * コンストラクタ
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
        // ロゴファイルをhtmlディレクトリにコピーします.
        copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . "/logo.png", PLUGIN_HTML_REALDIR . $arrPlugin['plugin_code'] . "/logo.png");
		
		mkdir(PLUGIN_HTML_REALDIR . $arrPlugin['plugin_code']."/media");
        SC_Utils_Ex::sfCopyDir(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code']."/media/", PLUGIN_HTML_REALDIR . $arrPlugin['plugin_code']."/media/");
		
		copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code']. "/html/frontparts/bloc/plg_AddSearchItem_listsearch.php", HTML_REALDIR . "frontparts/bloc/plg_AddSearchItem_listsearch.php");
		copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code']."/templates/default/frontparts/bloc/plg_AddSearchItem_listsearch.tpl", TEMPLATE_REALDIR . "frontparts/bloc/plg_AddSearchItem_listsearch.tpl");
		
        $objQuery =& SC_Query_Ex::getSingletonInstance();
		$objQuery->query("CREATE TABLE plg_addsearchitem_config (name text, value text)");
		
		$objQuery->insert("plg_addsearchitem_config",array("name" => "sort_price_asc", "value" => 1));
		$objQuery->insert("plg_addsearchitem_config",array("name" => "sort_date", "value" => 1));
		$objQuery->insert("plg_addsearchitem_config",array("name" => "text_price_asc", "value" => "価格順"));
		
        // dtb_blocにブロックを追加する.
        $sqlval_bloc = array();
        $sqlval_bloc['device_type_id'] = DEVICE_TYPE_PC;
        $sqlval_bloc['bloc_id'] = $objQuery->max('bloc_id', "dtb_bloc", "device_type_id = " . DEVICE_TYPE_PC) + 1;
        $sqlval_bloc['bloc_name'] = '詳細検索ブロック';
        $sqlval_bloc['tpl_path'] = "plg_AddSearchItem_listsearch.tpl";
        $sqlval_bloc['filename'] = "plg_AddSearchItem_listsearch";
        $sqlval_bloc['create_date'] = "CURRENT_TIMESTAMP";
        $sqlval_bloc['update_date'] = "CURRENT_TIMESTAMP";
        $sqlval_bloc['php_path'] = "frontparts/bloc/plg_AddSearchItem_listsearch.php";
        $sqlval_bloc['deletable_flg'] = 0;
        $sqlval_bloc['plugin_id'] = $arrPlugin['plugin_id'];
        $objQuery->insert("dtb_bloc", $sqlval_bloc);		
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
		SC_Helper_FileManager_Ex::deleteFile(PLUGIN_HTML_REALDIR . $arrPlugin['plugin_code']. "/media");
		
		SC_Helper_FileManager_Ex::deleteFile(TEMPLATE_REALDIR . "frontparts/bloc/plg_AddSearchItem_listsearch.tpl");
        SC_Helper_FileManager_Ex::deleteFile(HTML_REALDIR  . "frontparts/bloc/plg_AddSearchItem_listsearch.php");
		
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$objQuery->query("DROP TABLE plg_addsearchitem_config");
		
        $bloc_id = $objQuery->get('bloc_id', "dtb_bloc", "device_type_id = ? AND filename = ? AND plugin_id = ?", array(DEVICE_TYPE_PC , "plg_AddSearchItem_listsearch", $arrPlugin['plugin_id']));
        // ブロックを削除する.
        $where = "bloc_id = ? AND device_type_id = ?";
        $objQuery->delete("dtb_bloc", $where, array($bloc_id,DEVICE_TYPE_PC));
        $objQuery->delete("dtb_blocposition", $where, array($bloc_id,DEVICE_TYPE_PC));		
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

    /**
     * 処理の介入箇所とコールバック関数を設定
     * registerはプラグインインスタンス生成時に実行されます
     * 
     * @param SC_Helper_Plugin $objHelperPlugin 
     */
    function register(SC_Helper_Plugin $objHelperPlugin) {
		if(plg_AddSearchItem_Util::getECCUBEVer() >= 2130){
			$version = '213';
		}else{
			$version = '212';
		}
		require_once PLUGIN_UPLOAD_REALDIR . 'AddSearchItem/class/'.$version.'/plg_AddSearchItem_LC_Template_Ex.php';
		require_once PLUGIN_UPLOAD_REALDIR . 'AddSearchItem/class/'.$version.'/plg_AddSearchItem_LC_Page_Products_List_Ex.php';
		require_once PLUGIN_UPLOAD_REALDIR . 'AddSearchItem/class/'.$version.'/plg_AddSearchItem_LC_Page_Products_Search_Ex.php';
		require_once PLUGIN_UPLOAD_REALDIR . 'AddSearchItem/class/'.$version.'/plg_AddSearchItem_LC_Page_FrontParts_Bloc_SearchProducts_Ex.php';
		
		$objHelperPlugin->addAction("prefilterTransform",array("plg_AddSearchItem_LC_Template_Ex","prefilterTransform"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("SC_FormParam_construct",array(&$this,"addParam"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Products_List_action_before",array("plg_AddSearchItem_LC_Page_Products_List_Ex","before"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Products_List_action_after",array("plg_AddSearchItem_LC_Page_Products_List_Ex","after"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Products_Search_action_after",array("plg_AddSearchItem_LC_Page_Products_Search_Ex","after"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_FrontParts_Bloc_SearchProducts_action_before",array("plg_AddSearchItem_LC_Page_FrontParts_Bloc_SearchProducts_Ex","before"),$this->arrSelfInfo['priority']);
    }
	
	function addParam($class_name,$param){
		if(strpos($class_name,'LC_Page_Products_List') !== false){
			$param->addParam('sf', 'sf', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
			$param->addParam('rf', 'rf', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
			$param->addParam('fs', 'fs', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
			$param->addParam('price_min', 'price_min', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
			$param->addParam('price_max', 'price_max', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
			$param->addParam('product_status_id', 'product_status_id', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
		}
	}	
}
?>
