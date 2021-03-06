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
require_once PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/class/plg_ManageCustomerStatus_LC_Page_FrontParts_LoginCheck.php";

class plg_ManageCustomerStatus_LC_Page_FrontParts_LoginCheck_Ex extends plg_ManageCustomerStatus_LC_Page_FrontParts_LoginCheck{
    /**
     * @param LC_Page_FrontParts_LoginChek $objPage
     * @return void
     */	
	function login($objPage){
		parent::login($objPage);
	}
	
    /**
     * @param LC_Page_FrontParts_LoginChek $objPage
     * @return void
     */	
	function logout($objPage){
		parent::logout($objPage);
	}
}