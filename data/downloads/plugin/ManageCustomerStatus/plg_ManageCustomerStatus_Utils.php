<?php
/*
 * MagageCustomerStatus
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
 * @package ManageCustomerStatus
 * @author Bratech CO.,LTD.
 * @version $Id: $
 */
class plg_ManageCustomerStatus_Utils {
	function getECCUBEVer(){
		return floor(str_replace('.','',ECCUBE_VERSION));
	}
		
	function getTerm($term){
		if($term == 1){
			$start_date = date('Y-m-01 00:00:00',strtotime(date('Y-m-01')."-1 month"));
			$end_date = date('Y-m-t 23:59:59',strtotime(date('Y-m-01')."-1 month"));
		}elseif($term == 3){
			$month = intval(date('m'));
			if($month > 9){
				$start_date = date('Y-07-01 00:00:00');
				$end_date = date('Y-09-t 23:59:59',strtotime(date('Y-09-01')));
			}elseif($month > 6){
				$start_date = date('Y-04-01 00:00:00');
				$end_date = date('Y-06-t 23:59:59',strtotime(date('Y-06-01')));
			}elseif($month > 3){
				$start_date = date('Y-01-01 00:00:00');
				$end_date = date('Y-03-t 23:59:59',strtotime(date('Y-03-01')));
			}else{
				$start_date = date('Y-10-01 00:00:00',strtotime("-1 year"));
				$end_date = date('Y-12-t 23:59:59',strtotime(date('Y-12-15')."-1 year"));
			}
		}elseif($term == 6){
			$month = intval(date('m'));
			if($month > 6){
				$start_date = date('Y-01-01 00:00:00');
				$end_date = date('Y-06-t 23:59:59',strtotime(date('Y-06-01')));
			}else{
				$start_date = date('Y-07-01 00:00:00',strtotime("-1 year"));
				$end_date = date('Y-12-t 23:59:59',strtotime(date('Y-12-15')."-1 year"));
			}
		}elseif($term == 12){
			$start_date = date('Y-01-01 00:00:00',strtotime("-1 year"));
			$end_date = date('Y-12-t 23:59:59',strtotime(date('Y-12-15')."-1 year"));
		}elseif($term == 24){
			$start_date = date('Y-01-01 00:00:00',strtotime("-2 year"));
			$end_date = date('Y-12-t 23:59:59',strtotime(date('Y-12-15')."-1 year"));
		}else{
			$start_date = date('Y-m-01 00:00:00',strtotime(RELEASE_YEAR."-01-01"));
			$end_date = date('Y-m-t 23:59:59');
		}
		return array($start_date,$end_date);
	}
	
	function getTerm2($term){
		if($term == 1){
			$start_date = date('Y-m-01 00:00:00');
			$end_date = date('Y-m-t 23:59:59');
		}elseif($term == 3){
			$month = intval(date('m'));
			if($month > 9){
				$start_date = date('Y-10-01 00:00:00');
				$end_date = date('Y-12-t 23:59:59',strtotime(date('Y-12-01')));
			}elseif($month > 6){
				$start_date = date('Y-07-01 00:00:00');
				$end_date = date('Y-09-t 23:59:59',strtotime(date('Y-09-01')));
			}elseif($month > 3){
				$start_date = date('Y-04-01 00:00:00');
				$end_date = date('Y-06-t 23:59:59',strtotime(date('Y-06-01')));
			}else{
				$start_date = date('Y-01-01 00:00:00');
				$end_date = date('Y-03-t 23:59:59',strtotime(date('Y-03-01')));
			}
		}elseif($term == 6){
			$month = intval(date('m'));
			if($month > 6){
				$start_date = date('Y-07-01 00:00:00');
				$end_date = date('Y-12-t 23:59:59',strtotime(date('Y-12-01')));
			}else{
				$start_date = date('Y-01-01 00:00:00');
				$end_date = date('Y-06-t 23:59:59',strtotime(date('Y-06-01')));
			}
		}elseif($term == 12){
			$start_date = date('Y-01-01 00:00:00');
			$end_date = date('Y-12-t 23:59:59',strtotime(date('Y-12-01')));
		}elseif($term == 24){
			$start_date = date('Y-01-01 00:00:00',strtotime("-1 year"));
			$end_date = date('Y-12-t 23:59:59',strtotime(date('Y-12-01')));
		}else{
			$start_date = date('Y-m-01 00:00:00',strtotime(RELEASE_YEAR."-01-01"));
			$end_date = date('Y-m-t 23:59:59');
		}
		return array($start_date,$end_date);
	}
	
	function checkRank($customer_id,$start_date,$end_date){
		$target_id = plg_ManageCustomerStatus_Utils::getConfig('target_id');
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		if(strlen($target_id) > 0){
			$ret = $objQuery->select("SUM(subtotal) as total_amount, COUNT(order_id) as buy_times","dtb_order","del_flg = ? AND status IN (".$target_id.") AND create_date >= ? AND create_date <= ? AND customer_id = ?",array(0,$start_date,$end_date,$customer_id));
			$total_amount = $ret[0]['total_amount'];
			$buy_times = $ret[0]['buy_times'];
		}else{
			$total_amount = 0;
			$buy_times = 0;
		}
		$total_point = $objQuery->get("point","dtb_customer","customer_id =?",array($customer_id));

		$objQuery->setOrder("priority DESC");
		$statusIds = $objQuery->getCol("status_id","plg_managecustomerstatus_dtb_customer_status","(total_amount IS NOT NULL AND total_amount <= ?) OR (buy_times IS NOT NULL AND buy_times <= ?) OR (total_point IS NOT NULL AND total_point <=?)",array(intval($total_amount),intval($buy_times),intval($total_point)));		
		
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$customer_rank = $objQuery->get("plg_managecustomerstatus_status","dtb_customer","customer_id=?",array($customer_id));
		
//		$fixedrank = $objQuery->get("count(status_id)","plg_managecustomerstatus_dtb_customer_status","total_amount IS NULL AND buy_times IS NULL AND total_point IS NULL AND status_id = ?",array($customer_rank));

		$fixedrank = $objQuery->get("fixed_rank","plg_managecustomerstatus_dtb_customer_status"," status_id = ?",array($customer_rank));		
		
		if($fixedrank != 1){
			if(count($statusIds) > 0){
				// 現在のランクが含まれていればランクアップの可能性あり
				if(in_array($customer_rank,$statusIds)){
					$rank_up = true;
					$rank_down = false;
				// 現在のランクが含まれていなければランクダウン
				}else{
					$rank_up = false;
					$rank_down = true;
				}
				
				foreach($statusIds as $status_id){
					// ランクアップ or ランクダウンした後のステータスID取得
					if($status_id != $customer_rank){
						$new_status_id = $status_id;
						break;
					// ランク維持
					}else{
						$rank_up = false;
						$rank_down = false;
						break;
					}
				}
			// 該当するランクなし
			}else{
				$new_status_id = 0;
			}
		}else{
			$new_status_id = $customer_rank;
		}

		if(isset($new_status_id)){
			$objQuery->update("dtb_customer",array("plg_managecustomerstatus_check_date" => 'CURRENT_TIMESTAMP', "plg_managecustomerstatus_status" => $new_status_id),"customer_id = ?",array($customer_id));
			// ランクアップ
			if($rank_up){
				return array($new_status_id,0);
			}elseif($rank_down){
			// ランクダウン
				return array(0,$new_status_id);
			}
		}else{
			$objQuery->update("dtb_customer",array("plg_managecustomerstatus_check_date" => 'CURRENT_TIMESTAMP'),"customer_id = ?",array($customer_id));
			return array(0,0);
		}
	}
	
	function getStatusRankList(){
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objQuery->setOrder('priority ASC');
		$res = $objQuery->select('*', 'plg_managecustomerstatus_dtb_customer_status');
		$arrRet = array();
		if(count($res) > 0){
			foreach($res as $item){
				$arrRet[$item['status_id']] = $item['name'];
			}
		}
		return $arrRet;
	}
	
	function getNextRank($status_id){
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$objQuery->setOrder('priority ASC');
		$ret = $objQuery->select("*","plg_managecustomerstatus_dtb_customer_status");
		for($i = 0;$i < count($ret); $i++){
			$item = pos($ret);
			if($item['status_id'] == $status_id){
				return next($ret);
			}
			next($ret);
		}
		return false;
	}
	
	function getConfig($name){
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		return $objQuery->get("value","plg_managecustomerstatus_config","name = ?",array($name));
	}
	
    /**
     * dtb_blocにブロック情報を設定
     * 
     * @param  
     */
    function insertBloc($arrPlugin) {
        $objQuery = SC_Query_Ex::getSingletonInstance();
        // dtb_blocにブロックを追加する.
        $sqlval_bloc = array();
        $sqlval_bloc['device_type_id'] = DEVICE_TYPE_PC;
        $sqlval_bloc['bloc_id'] = $objQuery->max('bloc_id', "dtb_bloc", "device_type_id = " . DEVICE_TYPE_PC) + 1;
        $sqlval_bloc['bloc_name'] = "会員ランク情報表示";
        $sqlval_bloc['tpl_path'] = "plg_ManageCustomerStatus_info.tpl";
        $sqlval_bloc['filename'] = "plg_ManageCustomerStatus_info";
        $sqlval_bloc['create_date'] = "CURRENT_TIMESTAMP";
        $sqlval_bloc['update_date'] = "CURRENT_TIMESTAMP";
        $sqlval_bloc['php_path'] = "frontparts/bloc/plg_ManageCustomerStatus_info.php";
        $sqlval_bloc['deletable_flg'] = 0;
        $sqlval_bloc['plugin_id'] = $arrPlugin['plugin_id'];
        $objQuery->insert("dtb_bloc", $sqlval_bloc);
		
        $sqlval_bloc = array();
        $sqlval_bloc['device_type_id'] = DEVICE_TYPE_SMARTPHONE;
        $sqlval_bloc['bloc_id'] = $objQuery->max('bloc_id', "dtb_bloc", "device_type_id = " . DEVICE_TYPE_SMARTPHONE) + 1;
        $sqlval_bloc['bloc_name'] = "会員ランク情報表示";
        $sqlval_bloc['tpl_path'] = "plg_ManageCustomerStatus_info.tpl";
        $sqlval_bloc['filename'] = "plg_ManageCustomerStatus_info";
        $sqlval_bloc['create_date'] = "CURRENT_TIMESTAMP";
        $sqlval_bloc['update_date'] = "CURRENT_TIMESTAMP";
        $sqlval_bloc['php_path'] = "frontparts/bloc/plg_ManageCustomerStatus_info.php";
        $sqlval_bloc['deletable_flg'] = 0;
        $sqlval_bloc['plugin_id'] = $arrPlugin['plugin_id'];
        $objQuery->insert("dtb_bloc", $sqlval_bloc);
		
        $sqlval_bloc = array();
        $sqlval_bloc['device_type_id'] = DEVICE_TYPE_MOBILE;
        $sqlval_bloc['bloc_id'] = $objQuery->max('bloc_id', "dtb_bloc", "device_type_id = " . DEVICE_TYPE_MOBILE) + 1;
        $sqlval_bloc['bloc_name'] = "会員ランク情報表示";
        $sqlval_bloc['tpl_path'] = "plg_ManageCustomerStatus_info.tpl";
        $sqlval_bloc['filename'] = "plg_ManageCustomerStatus_info";
        $sqlval_bloc['create_date'] = "CURRENT_TIMESTAMP";
        $sqlval_bloc['update_date'] = "CURRENT_TIMESTAMP";
        $sqlval_bloc['php_path'] = "frontparts/bloc/plg_ManageCustomerStatus_info.php";
        $sqlval_bloc['deletable_flg'] = 0;
        $sqlval_bloc['plugin_id'] = $arrPlugin['plugin_id'];
        $objQuery->insert("dtb_bloc", $sqlval_bloc);
		
		if(plg_ManageCustomerStatus_Utils::getECCUBEVer() >= 2133){
			$version = '2133/';
		}else{
			$version = '';
		}
		copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] ."/templates/".$version."default/frontparts/bloc/plg_ManageCustomerStatus_info.tpl", TEMPLATE_REALDIR . "frontparts/bloc/plg_ManageCustomerStatus_info.tpl");
		copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] ."/templates/".$version."sphone/frontparts/bloc/plg_ManageCustomerStatus_info.tpl", SMARTPHONE_TEMPLATE_REALDIR . "frontparts/bloc/plg_ManageCustomerStatus_info.tpl");
		copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] ."/templates/".$version."mobile/frontparts/bloc/plg_ManageCustomerStatus_info.tpl", MOBILE_TEMPLATE_REALDIR . "frontparts/bloc/plg_ManageCustomerStatus_info.tpl");

		copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code']. "/html/default/plg_ManageCustomerStatus_info.php", HTML_REALDIR . "frontparts/bloc/plg_ManageCustomerStatus_info.php");
	}
	
	function deleteBloc($arrPlugin) {
        $objQuery = SC_Query_Ex::getSingletonInstance();
        $bloc_id = $objQuery->get('bloc_id', "dtb_bloc", "device_type_id = ? AND filename = ? AND plugin_id = ?", array(DEVICE_TYPE_PC , "plg_ManageCustomerStatus_info", $arrPlugin['plugin_id']));
        // ブロックを削除する.
        $where = "bloc_id = ? AND device_type_id = ?";
        $objQuery->delete("dtb_bloc", $where, array($bloc_id,DEVICE_TYPE_PC));
        $objQuery->delete("dtb_blocposition", $where, array($bloc_id,DEVICE_TYPE_PC));
		
        $bloc_id = $objQuery->get('bloc_id', "dtb_bloc", "device_type_id = ? AND filename = ? AND plugin_id = ?", array(DEVICE_TYPE_SMARTPHONE , "plg_ManageCustomerStatus_info", $arrPlugin['plugin_id']));
        // ブロックを削除する.
        $where = "bloc_id = ? AND device_type_id = ?";
        $objQuery->delete("dtb_bloc", $where, array($bloc_id,DEVICE_TYPE_SMARTPHONE));
        $objQuery->delete("dtb_blocposition", $where, array($bloc_id,DEVICE_TYPE_SMARTPHONE));
		
        $bloc_id = $objQuery->get('bloc_id', "dtb_bloc", "device_type_id = ? AND filename = ? AND plugin_id = ?", array(DEVICE_TYPE_MOBILE , "plg_ManageCustomerStatus_info", $arrPlugin['plugin_id']));
        // ブロックを削除する.
        $where = "bloc_id = ? AND device_type_id = ?";
        $objQuery->delete("dtb_bloc", $where, array($bloc_id,DEVICE_TYPE_MOBILE));
        $objQuery->delete("dtb_blocposition", $where, array($bloc_id,DEVICE_TYPE_MOBILE));
		
		SC_Helper_FileManager_Ex::deleteFile(TEMPLATE_REALDIR . "frontparts/bloc/plg_ManageCustomerStatus_info.tpl");
		SC_Helper_FileManager_Ex::deleteFile(SMARTPHONE_TEMPLATE_REALDIR . "frontparts/bloc/plg_ManageCustomerStatus_info.tpl");
		SC_Helper_FileManager_Ex::deleteFile(MOBILE_TEMPLATE_REALDIR . "frontparts/bloc/plg_ManageCustomerStatus_info.tpl");
		
		SC_Helper_FileManager_Ex::deleteFile(HTML_REALDIR  . "frontparts/bloc/plg_ManageCustomerStatus_info.php");
	}
	
	function nextRank($status_id,$customer_id,$start_date,$end_date,&$objPage){
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$arrNextRank = plg_ManageCustomerStatus_Utils::getNextRank($status_id);

		if(empty($arrNextRank))return false;
		$rankup_flg = false;
		$target_id = plg_ManageCustomerStatus_Utils::getConfig('target_id');
		if(is_numeric($arrNextRank['total_amount'])){
			if(strlen($target_id) > 0){
				$buy_total = $objQuery->get("SUM(subtotal)","dtb_order","del_flg = ? AND status IN (".$target_id.") AND create_date >= ? AND create_date <= ? AND customer_id =?",array(0,$start_date,$end_date,$customer_id));
			}else{
				$buy_total = 0;
			}
			if($arrNextRank['total_amount'] - $buy_total <= 0){
				$rankup_flg = true;
			}else{
				$objPage->rankup_total = $arrNextRank['total_amount'] - $buy_total;
			}
		}else{
			$objPage->rankup_total = 0;
		}
		
		if(is_numeric($arrNextRank['buy_times'])){
			if(strlen($target_id) > 0){
				$buy_times = $objQuery->get("COUNT(order_id)","dtb_order","del_flg = ? AND status IN (".$target_id.") AND create_date >= ? AND create_date <= ? AND customer_id =?",array(0,$start_date,$end_date,$customer_id));
			}else{
				$buy_times = 0;
			}
			if($arrNextRank['buy_times'] - $buy_times <= 0){
				$rankup_flg = true;
			}else{
				$objPage->rankup_times = $arrNextRank['buy_times'] - $buy_times;
			}
		}else{
			$objPage->rankup_times = 0;
		}
		
		if(is_numeric($arrNextRank['total_point'])){
			$total_point = $objQuery->get("point","dtb_customer","customer_id =?",array($customer_id));
			if($arrNextRank['total_point'] - $total_point <= 0){
				$rankup_flg = true;
			}else{
				$objPage->rankup_points = $arrNextRank['total_point'] - $total_point;
			}
		}else{
			$objPage->rankup_points = 0;
		}
		
		if($rankup_flg){
			$objPage->rankup++;
			$objPage->rankup_total = 0;
			$objPage->rankup_times = 0;
			$objPage->rankup_points = 0;
			$arrRet = plg_ManageCustomerStatus_Utils::nextRank($arrNextRank['status_id'],$customer_id,$start_date,$end_date,$objPage);
			if($arrRet === false){
				return $arrNextRank;
			}else{
				return $arrRet;
			}
		}else{
			return false;
		}
	}
	
	function addManageCustomerStatusParam(&$objFormParam){
		$objFormParam->addParam("会員ランク", 'plg_managecustomerstatus_status', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
	}
	
	function addSearchManageCustomerStatusParam(&$objFormParam){
		$objFormParam->addParam("会員ランク", 'search_plg_managecustomerstatus_status', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
	}
	
	function addManageCustomerStatusDispParam(&$objFormParam){
		$objFormParam->addParam("会員ランク非表示設定", 'plg_managecustomerstatus_product_disp', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
	}
	
	function addManageCustomerStatusPriceParam(&$objFormParam){
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$objQuery->setOrder('priority ASC');
		$arrRankNames = $objQuery->select("status_id,name","plg_managecustomerstatus_dtb_customer_status");
		foreach($arrRankNames as $item){
			$objFormParam->addParam($item['name']."価格","plg_managecustomerstatus_price".$item['status_id'],INT_LEN,'n',array('NUM_CHECK','MAX_LENGTH_CHECK'));
		}
	}
}