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

// {{{ requires
require_once CLASS_EX_REALDIR . 'page_extends/frontparts/bloc/LC_Page_FrontParts_Bloc_Ex.php';
require_once PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/plg_ManageCustomerStatus_Utils.php";


/**
 * 会員ランク情報表示のブロッククラス
 *
 * @package ManageCustomerStatus
 * @author Bratech CO.,LTD.
 * @version $Id: $
 */
class LC_Page_FrontParts_Bloc_ManageCustomerStatus_Info extends LC_Page_FrontParts_Bloc_Ex {

    /**
     * 初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();
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
		$objCustomer = new SC_Customer_Ex();
		$masterData = new SC_DB_MasterData_Ex();
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		
		$term = plg_ManageCustomerStatus_Utils::getConfig("term");

		list($start_date,$end_date) = plg_ManageCustomerStatus_Utils::getTerm2($term);
		
		$this->arrStatus = plg_ManageCustomerStatus_Utils::getStatusRankList();
		
		$ret = $objQuery->select("*","plg_managecustomerstatus_dtb_customer_status","status_id = ?",array($objCustomer->getValue('plg_managecustomerstatus_status')));
		$arrCustomer = $ret[0];


		$this->rankup = 0;
		$arrNextRank = plg_ManageCustomerStatus_Utils::nextRank($objCustomer->getValue('plg_managecustomerstatus_status'),$objCustomer->getValue('customer_id'),$start_date,$end_date,$this);

		$this->arrCustomer = $arrCustomer;
		$this->arrNextRank = $arrNextRank;
		
		if($term == 99){
			$this->rankup = 0;
		}
		
		if($term == 0){
			$this->rankup = 0;
			$this->rankup_total = 0;
			$this->rankup_times = 0;
			$this->rankup_points = 0;
		}
    }
	

    /**
     * デストラクタ.
     *
     * @return void
     */
    function destroy() {
		if(method_exists('LC_Page_FrontParts_Bloc_Ex','destroy')){
        	parent::destroy();
		}
    }
}
?>
