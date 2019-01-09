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

class plg_ManageCustomerStatus_LC_Page_Entry extends plg_ManageCustomerStatus_LC_Page{
    /**
     * @param LC_Page_Entry $objPage 会員登録のページクラス
     * @return void
     */
    function complete($objPage) {
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$status_id = $objQuery->get("status_id","plg_managecustomerstatus_dtb_customer_status","initial_rank = ?",array(1));
		if($status_id > 0){			
			$objQuery->update("dtb_customer",array("plg_managecustomerstatus_status" => $status_id),"email = ? AND del_flg <> 1",array($_POST['email']));
			
			$objCustomer = new SC_Customer_Ex();
			if ($objCustomer->isLoginSuccess(true)) {
				$objCustomer->setValue('plg_managecustomerstatus_status',$status_id);
			}
		}
    }
}