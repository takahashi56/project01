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

class plg_ManageCustomerStatus_LC_Page_Admin_Products_Product extends plg_ManageCustomerStatus_LC_Page{
    /**
     * @param LC_Page_Admin_Products_Product $objPage 商品管理のページクラス
     * @return void
     */
    function after($objPage) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objQuery->setOrder('priority ASC');
        $objPage->arrRankPrices = $objQuery->select('*', 'plg_managecustomerstatus_dtb_customer_status');
		$objPage->arrPlgManageCustomerStatus = plg_ManageCustomerStatus_Utils::getStatusRankList();
		$objPage->arrPlgManageCustomerStatus[0] = "ランクなし";
		
		$objFormParam = new SC_FormParam_Ex();
        switch($objPage->getMode($objPage)) {
            case "pre_edit":
            case "copy" :
				$objPage->lfInitFormParam_PreEdit($objFormParam, $_POST);
				// エラーチェック
				$arrErr = $objFormParam->checkError();
				if (count($arrErr) == 0) {
					$product_id = $objFormParam->getValue('product_id');
					$objQuery =& SC_Query_Ex::getSingletonInstance();
					$table = <<< __EOF__
						dtb_products AS T1
						LEFT JOIN (
							SELECT product_id AS product_id_sub,price,status_id
							FROM plg_managecustomerstatus_dtb_price
						) AS T2
							ON T1.product_id = T2.product_id_sub
__EOF__;
					$where = 'product_id = ?';
					$arrProduct = $objQuery->select('*', $table, $where, array($product_id));
					foreach((array)$arrProduct as $product){
						$objPage->arrForm['plg_managecustomerstatus_price'.$product['status_id']] = $product['price'];
					}
					
					$arrProductDisp = $objQuery->getCol('status_id',"plg_managecustomerstatus_dtb_product_disp","product_id = ?",array($product_id));
					foreach($objPage->arrPlgManageCustomerStatus as $status_id => $value){
						if(in_array($status_id,$arrProductDisp)){
							$objPage->arrForm['plg_managecustomerstatus_product_disp'][] = $status_id;
						}
					}
				}
                break;
            case "edit":
            case "upload_image":
            case "delete_image":
            case "upload_down":
            case "delete_down":
            case "recommend_select":
            case "confirm_return":
				plg_ManageCustomerStatus_Utils::addManageCustomerStatusPriceParam($objFormParam);
				plg_ManageCustomerStatus_Utils::addManageCustomerStatusDispParam($objFormParam);
                $objPage->lfInitFormParam($objFormParam, $_POST);
				$arrForm = $objFormParam->getHashArray();
                foreach($objPage->arrRankPrices as $item){
					$objPage->arrForm['plg_managecustomerstatus_price'.$item['status_id']] = $arrForm['plg_managecustomerstatus_price'.$item['status_id']];
				}
				$objPage->arrForm['plg_managecustomerstatus_product_disp'] = $arrForm['plg_managecustomerstatus_product_disp'];
                break;
            case "complete":
				if(count($objPage->arrErr) == 0){
					$objQuery =& SC_Query_Ex::getSingletonInstance();
					if($_POST['has_product_class'] != 1){
						plg_ManageCustomerStatus_Utils::addManageCustomerStatusPriceParam($objFormParam);
					
						$objPage->lfInitFormParam($objFormParam, $_POST);
						$arrForm = $objPage->lfGetFormParam_Complete($objFormParam);
						// エラーチェック
						$arrErr = $objFormParam->checkError();
						if (count($arrErr) == 0) {
							if($arrForm['product_class_id'] > 0 && empty($arrForm['copy_product_id'])){
								$product_class_id = $arrForm['product_class_id'];
							}else{
								$product_class_id = SC_Utils_Ex::sfGetProductClassId($objPage->arrForm['product_id'],'0','0');
							}
							foreach($objPage->arrRankPrices as $item){
								$rprice = $objFormParam->getValue("plg_managecustomerstatus_price".$item['status_id']);
								$objQuery->delete("plg_managecustomerstatus_dtb_price","product_class_id = ? AND status_id = ?",array($product_class_id,$item['status_id']));
								if(strlen($rprice) > 0){
									$sqlval = array();
									$sqlval['product_id'] = $objPage->arrForm['product_id'];
									$sqlval['product_class_id'] = $product_class_id;
									$sqlval['status_id'] = $item['status_id'];
									$sqlval['price'] = $rprice;
									$objQuery->insert("plg_managecustomerstatus_dtb_price", $sqlval);
								}
							}
						}
					}
					plg_ManageCustomerStatus_Utils::addManageCustomerStatusDispParam($objFormParam);
					$objPage->lfInitFormParam($objFormParam, $_POST);
					$arrForm = $objPage->lfGetFormParam_Complete($objFormParam);
					
					$objQuery->delete("plg_managecustomerstatus_dtb_product_disp","product_id = ?",array($objPage->arrForm['product_id']));
					foreach($arrForm['plg_managecustomerstatus_product_disp'] as $value){
						$sqlval = array();
						$sqlval['product_id'] = $objPage->arrForm['product_id'];
						$sqlval['status_id'] = $value;
						$objQuery->insert("plg_managecustomerstatus_dtb_product_disp", $sqlval);
					}
					
				}
                break;

            default:
                break;
        }
	}
}