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

require_once PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/class/plg_ManageCustomerStatus_LC_Page_Mypage_History.php";

class plg_ManageCustomerStatus_LC_Page_Mypage_History_Ex extends plg_ManageCustomerStatus_LC_Page_Mypage_History{
    /**
     * @param LC_Page_Mypage_History $objPage MYページ購入履歴のページクラス
     * @return void
     */
    function before($objPage) {
		parent::before($objPage);
	}
	
    /**
     * @param LC_Page_Mypage_History $objPage MYページ購入履歴のページクラス
     * @return void
     */
    function after($objPage) {
		$objProduct  = new SC_Product_Ex();
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		
		$objPage->is_price_change = false;
        foreach ($objPage->tpl_arrOrderDetail as $product_index => $arrOrderDetail) {
			$arrTempProductDetail = $objProduct->getProductsClass($arrOrderDetail['product_class_id']);
			if(strlen($arrTempProductDetail['plg_managecustomerstatus_price']) > 0){
				$arrTempProductDetail['plg_managecustomerstatus_price_inctax'] = SC_Helper_TaxRule_Ex::sfCalcIncTax(
					$arrTempProductDetail['plg_managecustomerstatus_price'],
					$arrTempProductDetail['product_id'],
					$arrTempProductDetail['product_class_id']
					);
				if ($objPage->tpl_arrOrderDetail[$product_index]['price_inctax'] != $arrTempProductDetail['plg_managecustomerstatus_price_inctax']) {
					$objPage->is_price_change = true;
				}
				$objPage->tpl_arrOrderDetail[$product_index]['product_price_inctax'] = $arrTempProductDetail['plg_managecustomerstatus_price_inctax'];
			}else{
				$arrTempProductDetail['price02_inctax'] = SC_Helper_TaxRule_Ex::sfCalcIncTax(
					$arrTempProductDetail['price02'],
					$arrTempProductDetail['product_id'],
					$arrTempProductDetail['product_class_id']
					);
				if ($objPage->tpl_arrOrderDetail[$product_index]['price_inctax'] != $arrTempProductDetail['price02_inctax']) {
					$objPage->is_price_change = true;
				}
				$objPage->tpl_arrOrderDetail[$product_index]['product_price_inctax'] = ($arrTempProductDetail['price02_inctax']) ? $arrTempProductDetail['price02_inctax'] : 0 ;
			}
        }
	}
}