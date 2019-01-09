<?php
/*
 * ManageCustomerStatus
 * Copyright (C) 2012 Bratech CO.,LTD. All Rights Reserved.
 * http://wwww.bratech.co.jp/
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
require_once PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/class/plg_ManageCustomerStatus_LC_Page.php";

class plg_ManageCustomerStatus_LC_Page_AbstractMypage extends plg_ManageCustomerStatus_LC_Page{
    /**
     * @param LC_Page_AbstractMypage $objPage
     * @return void
	 * AbstractMypageのフックポイントを利用できない
     */
    function before($objPage) {
		$objCustomer = new SC_Customer_Ex();
		$masterData = new SC_DB_MasterData_Ex();
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		
		$term = plg_ManageCustomerStatus_Utils::getConfig("term");

		list($start_date,$end_date) = plg_ManageCustomerStatus_Utils::getTerm2($term);
		
		$objPage->arrStatus = plg_ManageCustomerStatus_Utils::getStatusRankList();
		
		if(isset($_SESSION['plg_managecustomerstatus_rankup'])){
			$objPage->new_status_id = $_SESSION['plg_managecustomerstatus_rankup'];
			unset($_SESSION['plg_managecustomerstatus_rankup']);
		}
		
		$ret = $objQuery->select("*","plg_managecustomerstatus_dtb_customer_status","status_id = ?",array($objCustomer->getValue('plg_managecustomerstatus_status')));
		$arrCustomer = $ret[0];
		$expired_period = plg_ManageCustomerStatus_Utils::getConfig("point_term");
		if($expired_period > 0){
			$last_buy_date = $objQuery->get("last_buy_date","dtb_customer","customer_id = ?",array($objCustomer->getValue('customer_id')));
			$objPage->expired_date = date("Y-m-d",strtotime($last_buy_date."+".$expired_period." day"));
		}

		$objPage->rankup = 0;
		$arrNextRank = plg_ManageCustomerStatus_Utils::nextRank($objCustomer->getValue('plg_managecustomerstatus_status'),$objCustomer->getValue('customer_id'),$start_date,$end_date,$objPage);
		$objPage->arrCustomer = $arrCustomer;
		$objPage->arrNextRank = $arrNextRank;
		
		if($term == 99){
			$objPage->rankup = 0;
		}
		
		if($term == 0){
			$objPage->rankup = 0;
			$objPage->rankup_total = 0;
			$objPage->rankup_times = 0;
			$objPage->rankup_points = 0;
		}
    }
}