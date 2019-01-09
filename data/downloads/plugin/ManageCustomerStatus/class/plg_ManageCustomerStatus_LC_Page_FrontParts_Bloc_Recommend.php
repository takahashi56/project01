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

class plg_ManageCustomerStatus_LC_Page_Frontparts_Bloc_Recommend extends plg_ManageCustomerStatus_LC_Page{
    /**
     * @param LC_Page_FrontParts_Bloc_Recommend $objPage
     * @return void
     */
    function after($objPage) {
		$objCustomer = new SC_Customer_Ex();
			
		if($objCustomer->isLoginSuccess(true)){
			$status_id = $objCustomer->getValue('plg_managecustomerstatus_status');
			if($status_id > 0){
				$objQuery =& SC_Query_Ex::getSingletonInstance();
        		foreach($objPage->arrBestProducts as $key => $arrProduct){
					$ret = $objQuery->getRow("max(price) as max_price,min(price) as min_price","plg_managecustomerstatus_dtb_price","product_id = ? AND status_id =?",array($item['product_id'],$status_id));
					if(is_numeric($ret['min_price'])){
						$rprice_min = $ret['min_price'];
						$rprice_max = $ret['max_price'];
					}else{
						$discount_rate = $objQuery->get("discount_rate","plg_managecustomerstatus_dtb_customer_status","status_id =?",array($status_id));
						if($discount_rate > 0){
							$rprice_min = floor($arrProduct['price02_min'] * (1.0 - $discount_rate/100));
							$rprice_max = floor($arrProduct['price02_max'] * (1.0 - $discount_rate/100));
						}
					}
					if(isset($rprice_min))$objPage->arrBestProducts[$key]["plg_managecustomerstatus_price_min"] = $rprice_min;
					if(isset($rprice_max))$objPage->arrBestProducts[$key]["plg_managecustomerstatus_price_max"] = $rprice_max;
				}
			}
		}
    }
}