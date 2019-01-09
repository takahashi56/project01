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

/**
 * 共通関数
 *
 * @package AddSearchItem
 * @author Bratech CO.,LTD.
 * @version $Id: $
 */
class plg_AddSearchItem_Util {	
	function getECCUBEVer(){
		return floor(str_replace('.','',ECCUBE_VERSION));
	}

	function getConfig($name){
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$ret = $objQuery->get("value","plg_addsearchitem_config","name = ?",array($name));
		if($name == 'product_status'){
			return unserialize($ret);
		}else{
			return $ret;
		}
	}
	
	function existsFreeShippingPlg(){
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$ret = $objQuery->get("enable","dtb_plugin","plugin_code = ?",array('FreeShipping'));
		if($ret == 1){
			return true;
		}else{
			return false;
		}
	}
	
	function getSortList(){
		$arrList = array();
		if(plg_AddSearchItem_Util::getConfig("sort_price_asc") == 1){
			$text = plg_AddSearchItem_Util::getConfig("text_price_asc");
			if(empty($text)){
				$arrList['price'] = "価格順（低い順）";
			}else{
				$arrList['price'] = $text;
			}
		}
		if(plg_AddSearchItem_Util::getConfig("sort_price_desc") == 1){
			$text = plg_AddSearchItem_Util::getConfig("text_price_desc");
			if(empty($text)){
				$arrList['price_desc'] = "価格順（高い順）";
			}else{
				$arrList['price_desc'] = $text;
			}
		}
		if(plg_AddSearchItem_Util::getConfig("sort_date") == 1){
			$text = plg_AddSearchItem_Util::getConfig("text_date");
			if(empty($text)){
				$arrList['date'] = "新着順";
			}else{
				$arrList['date'] = $text;
			}
		}
		if(plg_AddSearchItem_Util::getConfig("sort_recommend") == 1){
			$text = plg_AddSearchItem_Util::getConfig("text_recommend");
			if(empty($text)){
				$arrList['recommend'] = "評価順";
			}else{
				$arrList['recommend'] = $text;
			}
		}
		if(plg_AddSearchItem_Util::getConfig("sort_review") == 1){
			$text = plg_AddSearchItem_Util::getConfig("text_review");
			if(empty($text)){
				$arrList['review'] = "レビュー数順";
			}else{
				$arrList['review'] = $text;
			}
		}
		if(plg_AddSearchItem_Util::getConfig("sort_discount") == 1){
			$text = plg_AddSearchItem_Util::getConfig("text_discount");
			if(empty($text)){
				$arrList['discount'] = "割引率順";
			}else{
				$arrList['discount'] = $text;
			}
		}
		if(plg_AddSearchItem_Util::getConfig("sort_quantity") == 1){
			$text = plg_AddSearchItem_Util::getConfig("text_quantity");
			if(empty($text)){
				$arrList['quantity'] = "売れ筋順";
			}else{
				$arrList['quantity'] = $text;
			}
		}
		if(plg_AddSearchItem_Util::getConfig("sort_sales") == 1){
			$text = plg_AddSearchItem_Util::getConfig("text_sales");
			if(empty($text)){
				$arrList['sales'] = "売上順";
			}else{
				$arrList['sales'] = $text;
			}
		}
		return $arrList;
	}
	
	function getStatusList(){
        $masterData = new SC_DB_MasterData_Ex();
        $masterSTATUS = $masterData->getMasterData('mtb_status');
		
		$arrSTATUS = plg_AddSearchItem_Util::getConfig("product_status");

		foreach($masterSTATUS as $status_id => $val){
			if(!in_array($status_id,$arrSTATUS))unset($masterSTATUS[$status_id]);
		}
		
		return $masterSTATUS;
	}
}