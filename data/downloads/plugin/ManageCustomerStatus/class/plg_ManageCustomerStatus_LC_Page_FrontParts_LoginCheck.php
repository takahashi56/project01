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

class plg_ManageCustomerStatus_LC_Page_Frontparts_LoginCheck extends plg_ManageCustomerStatus_LC_Page{
    /**
     * @param LC_Page_FrontParts_LoginChek $objPage
     * @return void
     */	
	function login($objPage){
		$objCartSess = new SC_CartSession_Ex();
		$cartKeys = $objCartSess->getKeys();
		foreach($cartKeys as $key){
			$objCartSess->getCartList($key);
		}
		
		//昇格・降格の判定
		$objQuery =& SC_Query_Ex::getSingletonInstance();
        $objCustomer = new SC_Customer_Ex();
		
		$customer_id = $objCustomer->getValue('customer_id');
		$term = plg_ManageCustomerStatus_Utils::getConfig("term");
		
		if($term > 0){
			list($start_date,$end_date) = plg_ManageCustomerStatus_Utils::getTerm($term);
	
			// 更新期間内で初めてのログインかどうかを判定
			$cnt = $objQuery->get("count(*)","dtb_customer","customer_id = ? AND (plg_managecustomerstatus_check_date IS NULL OR plg_managecustomerstatus_check_date <= ?)",array($customer_id,$end_date));
			
			if($cnt > 0 || $term == 99){
				list($rankup,$rankdown) = plg_ManageCustomerStatus_Utils::checkRank($customer_id,$start_date,$end_date);
	
				if($rankup != 0){
					$objCustomer->setValue('plg_managecustomerstatus_status',$rankup);
					$_SESSION['plg_managecustomerstatus_rankup'] = $rankup;
				}
				if($rankdown != 0){
					$objCustomer->setValue('plg_managecustomerstatus_status',$rankdown);
				}
			}
		}
		
		//保有ポイントの有効期間チェック
		$period = plg_ManageCustomerStatus_Utils::getConfig("point_term");
		
		if($period > 0){
			$expired_date = date("Y-m-d 00:00:00",strtotime("-".(intval($period))." day"));
			$expired_cnt = $objQuery->get("COUNT(*)","dtb_customer","customer_id = ? AND last_buy_date IS NOT NULL AND last_buy_date < ?",array($customer_id,$expired_date));
			
			if($expired_cnt > 0){
				$objQuery->update("dtb_customer",array("point" => 0),"customer_id = ?",array($customer_id));
				$objCustomer->setValue('point',0);
			}
		}
	}
	
    /**
     * @param LC_Page_FrontParts_LoginChek $objPage
     * @return void
     */	
	function logout($objPage){
		$objCartSess = new SC_CartSession_Ex();
		$cartKeys = $objCartSess->getKeys();
		foreach($cartKeys as $key){
			$objCartSess->getCartList($key);
		}
	}
}