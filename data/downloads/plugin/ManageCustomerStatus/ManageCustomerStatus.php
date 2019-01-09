<?php
/*
 * ManageCustomerStatus
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
  
require_once PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/plg_ManageCustomerStatus_Utils.php";

/**
 * プラグインのメインクラス
 *
 * @package ManageCustomerStatus
 * @author Bratech CO.,LTD.
 * @version $Id: $
 */
class ManageCustomerStatus extends SC_Plugin_Base {

    /**
     * コンストラクタ
     */
    public function __construct(array $arrSelfInfo) {
        parent::__construct($arrSelfInfo);

		$price_title = plg_ManageCustomerStatus_Utils::getConfig("member_rank_price_title");
		$price_title_mode = plg_ManageCustomerStatus_Utils::getConfig("member_rank_price_title_mode");
		define("MEMBER_RANK_PRICE_TITLE",$price_title);
		define("MEMBER_RANK_PRICE_TITLE_MODE",$price_title_mode);
		define('PLG_MANAGECUSTOMER_LOGIN_DISP',plg_ManageCustomerStatus_Utils::getConfig("login_disp"));
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
		
		$objQuery = SC_Query_Ex::getSingletonInstance();
		

		$objQuery->query("CREATE TABLE plg_managecustomerstatus_dtb_customer_status (status_id int, name text, discount_rate int, discount_value int DEFAULT 0, point_rate int ,point_value int DEFAULT 0, discount_fee int DEFAULT 0, free_fee smallint DEFAULT 0, total_amount int,buy_times int, priority int,total_point int,initial_rank smallint DEFAULT 0,fixed_rank smallint DEFAULT 0, PRIMARY KEY (status_id))");
		$objQuery->query("CREATE TABLE plg_managecustomerstatus_config (name text, value text)");
		$objQuery->query("CREATE TABLE plg_managecustomerstatus_dtb_csv_no (status_id int, csv_no int)");
		
		$objQuery->query("ALTER TABLE dtb_customer ADD COLUMN plg_managecustomerstatus_status int DEFAULT NULL");
		$objQuery->query("CREATE TABLE plg_managecustomerstatus_dtb_product_disp (product_id int,status_id int)");
		if(DB_TYPE == "pgsql"){
			$objQuery->query("ALTER TABLE dtb_customer ADD COLUMN plg_managecustomerstatus_check_date timestamp without time zone DEFAULT NULL");
			$objQuery->query("CREATE TABLE plg_managecustomerstatus_dtb_price (product_id int, product_class_id int, status_id int, price numeric)");
		}elseif(DB_TYPE == "mysql"){
			$objQuery->query("ALTER TABLE dtb_customer ADD COLUMN plg_managecustomerstatus_check_date datetime DEFAULT NULL");
			$objQuery->query("CREATE TABLE plg_managecustomerstatus_dtb_price (product_id int, product_class_id int, status_id int, price decimal)");
		}
		$objQuery->insert("plg_managecustomerstatus_config", array("name" => "member_rank_price_title","value"=>"会員価格"));
		$objQuery->insert("plg_managecustomerstatus_config", array("name" => "login_disp","value"=>"0"));
		
		$objQuery->insert("plg_managecustomerstatus_config", array('name' => 'target_id', 'value' => ORDER_NEW .','. ORDER_PAY_WAIT .','. ORDER_PRE_END .','. ORDER_BACK_ORDER. ',' . ORDER_DELIV));
		
		plg_ManageCustomerStatus_Utils::insertBloc($arrPlugin);
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
		$objQuery = SC_Query_Ex::getSingletonInstance();
		
		//CSV項目を削除
		$arrCsvNo = $objQuery->getCol("csv_no","plg_managecustomerstatus_dtb_csv_no");

		if(count($arrCsvNo) > 0){
			foreach($arrCsvNo as $csv_no){
				$objQuery->delete("dtb_csv","no = ?",array($csv_no));
			}
		}
		
		plg_ManageCustomerStatus_Utils::deleteBloc($arrPlugin);
				
        $objQuery->query("DROP TABLE plg_managecustomerstatus_dtb_customer_status");
		$objQuery->query("DROP TABLE plg_managecustomerstatus_config");
		$objQuery->query("DROP TABLE plg_managecustomerstatus_dtb_csv_no");
		$objQuery->query("DROP TABLE plg_managecustomerstatus_dtb_price");
		$objQuery->query("DROP TABLE plg_managecustomerstatus_dtb_product_disp");
		$objQuery->query("ALTER TABLE dtb_customer DROP COLUMN plg_managecustomerstatus_status");
		$objQuery->query("ALTER TABLE dtb_customer DROP COLUMN plg_managecustomerstatus_check_date");
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
		copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . "/html/admin/customer/plg_managecustomerstatus_status.php", HTML_REALDIR . ADMIN_DIR."customer/plg_managecustomerstatus_status.php");
		copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . "/html/admin/customer/plg_managecustomerstatus_upload_csv.php", HTML_REALDIR . ADMIN_DIR."customer/plg_managecustomerstatus_upload_csv.php");
		
		$objQuery = SC_Query_Ex::getSingletonInstance();

        // dtb_csvテーブルにレコードを追加
		$sqlval_dtb_csv = array();
		$max = $objQuery->max('no','dtb_csv')+1;
		$next = $objQuery->nextVal('dtb_csv_no');
		if($max > $next){
			$no = $max;
		}else{
			$no = $next;
		}
		$sqlval_dtb_csv['no'] = $no;
		$sqlval_dtb_csv['csv_id'] = 2;
		$sqlval_dtb_csv['col'] = '(SELECT name FROM plg_managecustomerstatus_dtb_customer_status WHERE plg_managecustomerstatus_dtb_customer_status.status_id = dtb_customer.plg_managecustomerstatus_status)';
		$sqlval_dtb_csv['disp_name'] = '会員ランク';
		$sqlval_dtb_csv['rw_flg'] = 1;
		$sqlval_dtb_csv['status'] = 2;
		$sqlval_dtb_csv['create_date'] = 'CURRENT_TIMESTAMP';
		$sqlval_dtb_csv['update_date'] = 'CURRENT_TIMESTAMP';
		$sqlval_dtb_csv['mb_convert_kana_option'] = "";
		$sqlval_dtb_csv['size_const_type'] = "";
		$sqlval_dtb_csv['error_check_types'] = "";
		$objQuery->insert("dtb_csv", $sqlval_dtb_csv);
		
		$sqlval_dtb_csv = array();
		$max = $objQuery->max('no','dtb_csv')+1;
		$next = $objQuery->nextVal('dtb_csv_no');
		if($max > $next){
			$no = $max;
		}else{
			$no = $next;
		}
		$sqlval_dtb_csv['no'] = $no;
		$sqlval_dtb_csv['csv_id'] = 1;
		$sqlval_dtb_csv['col'] = "(SELECT ARRAY_TO_STRING(ARRAY(SELECT status_id FROM plg_managecustomerstatus_dtb_product_disp WHERE plg_managecustomerstatus_dtb_product_disp.product_id = prdcls.product_id ORDER BY plg_managecustomerstatus_dtb_product_disp.status_id), ',')) as plg_managecustomerstatus_product_disp";
		$sqlval_dtb_csv['disp_name'] = '会員ランク別購入不可設定';
		$sqlval_dtb_csv['rw_flg'] = 1;
		$sqlval_dtb_csv['status'] = 2;
		$sqlval_dtb_csv['create_date'] = 'CURRENT_TIMESTAMP';
		$sqlval_dtb_csv['update_date'] = 'CURRENT_TIMESTAMP';
		$sqlval_dtb_csv['mb_convert_kana_option'] = "KVa";
		$sqlval_dtb_csv['size_const_type'] = "LTEXT_LEN";
		$sqlval_dtb_csv['error_check_types'] = "SPTAB_CHECK,MAX_LENGTH_CHECK";
		$objQuery->insert("dtb_csv", $sqlval_dtb_csv);		
		
		
		//CSV項目を表示に
		$arrCsvNo = $objQuery->getCol("csv_no","plg_managecustomerstatus_dtb_csv_no");

		if(count($arrCsvNo) > 0){
			foreach($arrCsvNo as $csv_no){
				$objQuery->update("dtb_csv",array("status"=>1),"no = ?",array($csv_no));
			}
		}
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
		SC_Helper_FileManager_Ex::deleteFile(HTML_REALDIR . ADMIN_DIR."customer/plg_managecustomerstatus_status.php");
		SC_Helper_FileManager_Ex::deleteFile(HTML_REALDIR . ADMIN_DIR."customer/plg_managecustomerstatus_upload_csv.php");
		
		// dtb_csvテーブルからレコードを削除
		$objQuery = SC_Query_Ex::getSingletonInstance();
		$objQuery->delete("dtb_csv","csv_id = 2 AND disp_name = ?",array('会員ランク'));
		$objQuery->delete("dtb_csv","csv_id = 1 AND disp_name = ?",array('会員ランク別購入不可設定'));
		
		//CSV項目を非表示に
		$arrCsvNo = $objQuery->getCol("csv_no","plg_managecustomerstatus_dtb_csv_no");

		if(count($arrCsvNo) > 0){
			foreach($arrCsvNo as $csv_no){
				$objQuery->update("dtb_csv",array("status"=>2),"no = ?",array($csv_no));
			}
		}
    }

    /**
     * 処理の介入箇所とコールバック関数を設定
     * registerはプラグインインスタンス生成時に実行されます
     * 
     * @param SC_Helper_Plugin $objHelperPlugin 
     */
    function register(SC_Helper_Plugin $objHelperPlugin) {		
		if(plg_ManageCustomerStatus_Utils::getECCUBEVer() >= 2130){
			$version = '213';
		}else{
			$version = '212';
		}
		require_once PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/class/'.$version.'/plg_ManageCustomerStatus_LC_Page_FrontParts_LoginCheck_Ex.php';
		require_once PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/class/'.$version.'/plg_ManageCustomerStatus_LC_Page_FrontParts_Bloc_Recommend_Ex.php';
		require_once PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/class/'.$version.'/plg_ManageCustomerStatus_LC_Page_FrontParts_Bloc_Login_Ex.php';
		require_once PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/class/'.$version.'/plg_ManageCustomerStatus_LC_Page_Entry_Ex.php';
		require_once PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/class/'.$version.'/plg_ManageCustomerStatus_LC_Page_AbstractMypage_Ex.php';
		require_once PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/class/'.$version.'/plg_ManageCustomerStatus_LC_Page_Mypage_History_Ex.php';
		require_once PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/class/'.$version.'/plg_ManageCustomerStatus_LC_Page_Shopping_Confirm_Ex.php';
		require_once PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/class/'.$version.'/plg_ManageCustomerStatus_LC_Page_Admin_Customer_Ex.php';
		require_once PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/class/'.$version.'/plg_ManageCustomerStatus_LC_Page_Admin_Customer_Edit_Ex.php';
		require_once PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/class/'.$version.'/plg_ManageCustomerStatus_LC_Page_Admin_Products_Product_Ex.php';
		require_once PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/class/'.$version.'/plg_ManageCustomerStatus_LC_Page_Admin_Products_ProductClass_Ex.php';
		require_once PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/class/'.$version.'/plg_ManageCustomerStatus_LC_Page_Admin_Products_UploadCSV_Ex.php';
		require_once PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/class/'.$version.'/plg_ManageCustomerStatus_LC_Page_Admin_Order_Edit_Ex.php';
		require_once PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/class/'.$version.'/plg_ManageCustomerStatus_LC_Page_Admin_Mail_Ex.php';
		if(plg_ManageCustomerStatus_Utils::getECCUBEVer() >= 2133){
			$tpl_version = '2133';
		}else{
			$tpl_version = $version;
		}
		require_once PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/class/'.$tpl_version.'/plg_ManageCustomerStatus_LC_Template_Ex.php';
		
		$objHelperPlugin->addAction("loadClassFileChange", array(&$this, "loadClassFileChange"), $this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("SC_FormParam_construct",array(&$this,"addParam"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction('prefilterTransform', array('plg_ManageCustomerStatus_LC_Template_Ex', 'prefilterTransform'), $this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_FrontParts_LoginCheck_action_login",array('plg_ManageCustomerStatus_LC_Page_FrontParts_LoginCheck_Ex',"login"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_FrontParts_LoginCheck_action_logout",array('plg_ManageCustomerStatus_LC_Page_FrontParts_LoginCheck_Ex',"logout"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_FrontParts_Bloc_Recommend_action_after",array("plg_ManageCustomerStatus_LC_Page_FrontParts_Bloc_Recommend_Ex","after"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_FrontParts_Bloc_Login_action_after",array("plg_ManageCustomerStatus_LC_Page_FrontParts_Bloc_Login_Ex","after"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_FrontParts_Bloc_LoginFooter_action_after",array("plg_ManageCustomerStatus_LC_Page_FrontParts_Bloc_Login_Ex","after"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Entry_action_complete",array("plg_ManageCustomerStatus_LC_Page_Entry_Ex","complete"),$this->arrSelfInfo['priority']);
		if(plg_ManageCustomerStatus_Utils::getECCUBEVer() >= 2130){
			$objHelperPlugin->addAction("LC_Page_Mypage_action_before",array("plg_ManageCustomerStatus_LC_Page_AbstractMypage_Ex","before"),$this->arrSelfInfo['priority']);
			$objHelperPlugin->addAction("LC_Page_Mypage_Favorite_action_before",array("plg_ManageCustomerStatus_LC_Page_AbstractMypage_Ex","before"),$this->arrSelfInfo['priority']);
			$objHelperPlugin->addAction("LC_Page_Mypage_History_action_after",array("plg_ManageCustomerStatus_LC_Page_Mypage_History_Ex","after"),$this->arrSelfInfo['priority']);
		}else{
			$objHelperPlugin->addAction("LC_Page_MyPage_action_before",array("plg_ManageCustomerStatus_LC_Page_AbstractMypage_Ex","before"),$this->arrSelfInfo['priority']);
			$objHelperPlugin->addAction("LC_Page_MyPage_Favorite_action_before",array("plg_ManageCustomerStatus_LC_Page_AbstractMypage_Ex","before"),$this->arrSelfInfo['priority']);
		}
		$objHelperPlugin->addAction("LC_Page_Mypage_Change_action_before",array("plg_ManageCustomerStatus_LC_Page_AbstractMypage_Ex","before"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Mypage_ChangeComplete_action_before",array("plg_ManageCustomerStatus_LC_Page_AbstractMypage_Ex","before"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Mypage_Delivery_action_before",array("plg_ManageCustomerStatus_LC_Page_AbstractMypage_Ex","before"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Mypage_History_action_before",array("plg_ManageCustomerStatus_LC_Page_AbstractMypage_Ex","before"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Mypage_Order_action_before",array("plg_ManageCustomerStatus_LC_Page_AbstractMypage_Ex","before"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Mypage_Refusal_action_before",array("plg_ManageCustomerStatus_LC_Page_AbstractMypage_Ex","before"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Shopping_Confirm_action_before",array("plg_ManageCustomerStatus_LC_Page_Shopping_Confirm_Ex","before"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Shopping_Confirm_action_after",array("plg_ManageCustomerStatus_LC_Page_Shopping_Confirm_Ex","after"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Admin_Customer_action_before",array("plg_ManageCustomerStatus_LC_Page_Admin_Customer_Ex","before"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Admin_Customer_Edit_action_after",array("plg_ManageCustomerStatus_LC_Page_Admin_Customer_Edit_Ex","after"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Admin_Products_Product_action_after",array("plg_ManageCustomerStatus_LC_Page_Admin_Products_Product_Ex","after"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Admin_Products_ProductClass_action_after",array("plg_ManageCustomerStatus_LC_Page_Admin_Products_ProductClass_Ex","after"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Admin_Products_UploadCSV_action_before",array("plg_ManageCustomerStatus_LC_Page_Admin_Products_UploadCSV_Ex","before"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Admin_Products_UploadCSV_action_after",array("plg_ManageCustomerStatus_LC_Page_Admin_Products_UploadCSV_Ex","after"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Admin_Order_Edit_action_before",array("plg_ManageCustomerStatus_LC_Page_Admin_Order_Edit_Ex","before"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Admin_Order_Edit_action_after",array("plg_ManageCustomerStatus_LC_Page_Admin_Order_Edit_Ex","after"),$this->arrSelfInfo['priority']);
		$objHelperPlugin->addAction("LC_Page_Admin_Mail_action_before",array("plg_ManageCustomerStatus_LC_Page_Admin_Mail_Ex","before"),$this->arrSelfInfo['priority']);
    }
	
	function loadClassFileChange(&$classname,&$classpath){
		if(plg_ManageCustomerStatus_Utils::getECCUBEVer() >= 2130){
			$version = '213';
		}else{
			$version = '212';
		}
		if($classname == 'SC_Helper_Customer_Ex'){
			$classpath = PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/class/plg_ManageCustomerStatus_SC_Helper_Customer.php";
			$classname = "plg_ManageCustomerStatus_SC_Helper_Customer";
		}
		if($classname == 'SC_Helper_Purchase_Ex'){
			$classpath = PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/class/".$version."/plg_ManageCustomerStatus_SC_Helper_Purchase_Ex.php";
			$classname = "plg_ManageCustomerStatus_SC_Helper_Purchase_Ex";
		}
		if($classname == 'SC_Helper_Mail_Ex'){
			$classpath = PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/class/plg_ManageCustomerStatus_SC_Helper_Mail.php";
			$classname = "plg_ManageCustomerStatus_SC_Helper_Mail";
		}
		if($classname == 'SC_CartSession_Ex'){
			$classpath = PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/class/plg_ManageCustomerStatus_SC_CartSession.php";
			$classname = "plg_ManageCustomerStatus_SC_CartSession";
		}
		if($classname == 'SC_Product_Ex'){
			$classpath = PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/class/".$version."/plg_ManageCustomerStatus_SC_Product_Ex.php";
			$classname = "plg_ManageCustomerStatus_SC_Product_Ex";
		}
	}
	
	function addParam($class_name,$param){
		if($class_name == 'LC_Page_Admin_Customer'){
			plg_ManageCustomerStatus_Utils::addSearchManageCustomerStatusParam($param);
		}
		if(strpos($class_name,'LC_Page_Admin_Customer_Edit') !== false){
			plg_ManageCustomerStatus_Utils::addManageCustomerStatusParam($param);
		}
		if($class_name == 'LC_Page_Admin_Mail'){
			plg_ManageCustomerStatus_Utils::addSearchManageCustomerStatusParam($param);
		}
	}
	
	function process(LC_Page_Ex $objPage){
		if(MEMBER_RANK_PRICE_TITLE_MODE == 1){
			$objPage->arrCustomerRank = plg_ManageCustomerStatus_Utils::getStatusRankList();
			$objCustomer = new SC_Customer_Ex();
			if($objCustomer->isLoginSuccess(true)){
				$customer_rank_id = $objCustomer->getValue('plg_managecustomerstatus_status');
			}
			if(empty($customer_rank_id)){
				$objQuery =& SC_Query_Ex::getSingletonInstance();
				$customer_rank_id = $objQuery->get("status_id","plg_managecustomerstatus_dtb_customer_status","initial_rank = ?",array(1));
			}
			$objPage->customer_rank_id = $customer_rank_id;
		}
	}
}
?>
