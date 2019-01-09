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

class plg_ManageCustomerStatus_LC_Page_Admin_Order_Edit extends plg_ManageCustomerStatus_LC_Page{
    /**
     * @param LC_Page_Admin_Order_Edit $objPage
     * @return void
     */
    function before($objPage) {
		$mode = $objPage->getMode();
		if($mode == "edit" || $mode == "add"){
			$objPurchase = new SC_Helper_Purchase_Ex();
			$objFormParam = new SC_FormParam_Ex();
		
			// パラメーター情報の初期化
			$objPage->lfInitParam($objFormParam);
			$objFormParam->setParam($_POST);
			$objFormParam->convParam();
			$order_id = $objFormParam->getValue('order_id');
			$arrValuesBefore = array();
			
			// DBから受注情報を読み込む
			if (!SC_Utils_Ex::isBlank($order_id)) {
				$objPage->setOrderToFormParam($objFormParam, $order_id);
				$objPage->tpl_subno = 'index';
				$arrValuesBefore['deliv_id'] = $objFormParam->getValue('deliv_id');
				$arrValuesBefore['payment_id'] = $objFormParam->getValue('payment_id');
				$arrValuesBefore['payment_method'] = $objFormParam->getValue('payment_method');
			} else {
				$objPage->tpl_subno = 'add';
				$objPage->tpl_mode = 'add';
				$arrValuesBefore['deliv_id'] = NULL;
				$arrValuesBefore['payment_id'] = NULL;
				$arrValuesBefore['payment_method'] = NULL;
				// お届け先情報を空情報で表示
				$arrShippingIds[] = null;
				$objFormParam->setValue('shipping_id', $arrShippingIds);
	
				// 新規受注登録で入力エラーがあった場合の画面表示用に、会員の現在ポイントを取得
				if (!SC_Utils_Ex::isBlank($objFormParam->getValue('customer_id'))) {
					$arrCustomer = SC_Helper_Customer_Ex::sfGetCustomerDataFromId($customer_id);
					$objFormParam->setValue('customer_point', $arrCustomer['point']);
	
					// 新規受注登録で、ポイント利用できるように現在ポイントを設定
					$objFormParam->setValue('point', $arrCustomer['point']);
				}
			}
			$objFormParam->setParam($_POST);
			$objFormParam->convParam();
			$customer_id = $objFormParam->getValue('customer_id');
			if(method_exists($objPage,'setProductsQuantity')){
				$objPage->setProductsQuantity($objFormParam);
			}
			$objPage->arrErr = $objPage->lfCheckError($objFormParam);
			if($customer_id > 0){
				$arrValues = $objFormParam->getHashArray();
				$objQuery =& SC_Query_Ex::getSingletonInstance();
				$from = "plg_managecustomerstatus_dtb_customer_status status LEFT JOIN dtb_customer customer ON status.status_id = customer.plg_managecustomerstatus_status";
				$ret = $objQuery->select("status.*",$from,"customer.customer_id = ?",array($customer_id));
				$arrRet = $ret[0];
				
				$totalpoint = 0;
				$max = count($arrValues['quantity']);
				for ($i = 0; $i < $max; $i++) {
					// 加算ポイントの計算
					$totalpoint += SC_Utils_Ex::sfPrePoint($arrValues['price'][$i], $arrValues['point_rate'][$i]) * $arrValues['quantity'][$i];
				}
				
				$point = SC_Helper_DB_Ex::sfGetAddPoint($totalpoint, $arrValues['use_point']);
				
				$inc_point=0;
				if(strlen($arrRet['point_rate']) > 0){
					$inc_point = floor($point * (intval($arrRet['point_rate']) / 100));
				}elseif($arrRet['point_value'] > 0){
					$inc_point = intval($arrRet['point_value']);
				}
				$add_point = $point + $inc_point;
				if($add_point < 0)$add_point = 0;
				
				$objFormParam->setValue('add_point',$add_point);
			}
			if (SC_Utils_Ex::isBlank($objPage->arrErr)) {
				if($mode == "edit"){
					$message = '受注を編集しました。';
					$order_id = $objPage->doRegister($order_id, $objPurchase, $objFormParam, $message, $arrValuesBefore);
					if ($order_id >= 0) {
						$objPage->setOrderToFormParam($objFormParam, $order_id);					
					}
				}else{
					$message = '受注を登録しました。';
					$order_id = $objPage->doRegister(null, $objPurchase, $objFormParam, $message, $arrValuesBefore);
					if ($order_id >= 0) {
						$objPage->tpl_mode = 'edit';
						$objFormParam->setValue('order_id', $order_id);
						$objPage->setOrderToFormParam($objFormParam, $order_id);
						$_POST['plg_managecustomerstatus_order_id'] = $order_id;
						$_POST['plg_mode'] = 'plg_managecustomerstatus_add';
					}					
				}
				if($order_id > 0){
					if(plg_ManageCustomerStatus_Utils::getECCUBEVer() >= 2130){
						$arrPayment = SC_Helper_Payment_Ex::getIDValueList();
					}else{
						$arrPayment = SC_Helper_DB_Ex::sfGetIDValueList('dtb_payment', 'payment_id', 'payment_method');
					}
					$objQuery =& SC_Query_Ex::getSingletonInstance();
					$arrValues = $objFormParam->getDbArray();
			
					// 支払い方法が変更されたら、支払い方法名称も更新
					if ($arrValues['payment_id'] != $arrValuesBefore['payment_id']) {
						$objQuery->update("dtb_order",array("payment_method" => $arrPayment[$arrValues['payment_id']]),"order_id = ?",array($order_id));
					}
				}
				$objPage->tpl_onload = "window.alert('" . $message . "');";
				$_REQUEST['mode'] = $_POST['mode'] = $_GET['mode'] = 'order_id';
			}
		}
	}
	
    /**
     * @param LC_Page_Admin_Order_Edit $objPage
     * @return void
     */
    function after($objPage) {
		$objFormParam = new SC_FormParam_Ex();

		// パラメーター情報の初期化
		$objPage->lfInitParam($objFormParam);
		$objFormParam->setParam($_POST);
		$objFormParam->convParam();
		$customer_id = $objPage->arrForm['customer_id']['value'];
		
		$objPage->arrPlgManageCustomerStatus = plg_ManageCustomerStatus_Utils::getStatusRankList();
		
		if($customer_id > 0){
			$objQuery =& SC_Query_Ex::getSingletonInstance();
			$status_id = $objQuery->get("plg_managecustomerstatus_status","dtb_customer","customer_id=?",array($customer_id));
			$objPage->status_id = $status_id;

			if($objPage->getMode() == "select_product_detail"){
				$target_product_class_id = $objFormParam->getValue('add_product_class_id');
				if (SC_Utils_Ex::isBlank($target_product_class_id)) {
					$target_product_class_id = $objFormParam->getValue('edit_product_class_id');
				}
				
				if($status_id > 0){
					$rprice = $objQuery->get("price","plg_managecustomerstatus_dtb_price","product_class_id = ? AND status_id=?",array($target_product_class_id,$status_id));
	
					if(strlen($rprice) == 0){
						$arrStatus = $objQuery->getRow("discount_rate,discount_value","plg_managecustomerstatus_dtb_customer_status","status_id =?",array($status_id));
					}

					// 受注商品の価格変更
					$arrProductClassIds = $objPage->arrForm['product_class_id']['value'];
					foreach($arrProductClassIds as $relation_index => $product_class_id){
						if($target_product_class_id == $product_class_id){
							if(strlen($rprice) == 0){
								$objPage->arrForm['price']['value'][$relation_index] = floor($objPage->arrForm['price']['value'][$relation_index] * (1.0 - $arrStatus['discount_rate']/100));
							}else{
								$objPage->arrForm['price']['value'][$relation_index] = $rprice;
							}
						}
					}
					
					// 配送先商品の価格変更
					$arrShipmentProducts = $objPage->arrForm['shipment_product_class_id']['value'];
					foreach($arrShipmentProducts as $shipping_id => $productIds){
						foreach($productIds as $relation_index => $product_class_id){
							if($target_product_class_id == $product_class_id){
								if(strlen($rprice) == 0){
									$objPage->arrAllShipping[$shipping_id]['shipment_price'][$relation_index] = floor($objPage->arrAllShipping[$shipping_id]['shipment_price'][$relation_index] * (1.0 - $arrStatus['discount_rate']/100));
								}else{
									$objPage->arrAllShipping[$shipping_id]['shipment_price'][$relation_index] = $rprice;
								}
							}
						}
					}
				}
			}
			

			$from = "plg_managecustomerstatus_dtb_customer_status status LEFT JOIN dtb_customer customer ON status.status_id = customer.plg_managecustomerstatus_status";
			$ret = $objQuery->select("status.*",$from,"customer.customer_id = ?",array($customer_id));
			$arrRet = $ret[0];
			
			$totalpoint = 0;
			$max = count($objPage->arrForm['quantity']['value']);
			for ($i = 0; $i < $max; $i++) {
				// 加算ポイントの計算
				$totalpoint += SC_Utils_Ex::sfPrePoint($objPage->arrForm['price']['value'][$i], $objPage->arrForm['point_rate']['value'][$i]) * $objPage->arrForm['quantity']['value'][$i];
			}
			
			$point = SC_Helper_DB_Ex::sfGetAddPoint($totalpoint, $objPage->arrForm['use_point']['value']);
			
			$inc_point=0;
			if(strlen($arrRet['point_rate']) > 0){
				$inc_point = floor($point * (intval($arrRet['point_rate']) / 100));
			}elseif($arrRet['point_value'] > 0){
				$inc_point = intval($arrRet['point_value']);
			}
			
			$objPage->arrForm['add_point']['value'] = $point + $inc_point;
			if($objPage->arrForm['add_point']['value'] < 0)$objPage->arrForm['add_point']['value'] = 0;
		}
		

		if($_POST['plg_mode'] == "plg_managecustomerstatus_add"){
			$objPage->tpl_mode = 'edit';
			$objPage->arrForm['order_id']['value'] = $_POST['plg_managecustomerstatus_order_id'];
		}
    }
}