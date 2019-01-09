<?php
/*
 * AddSearchItem
 * Copyright (C) 2014 Bratech CO.,LTD. All Rights Reserved.
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

require_once PLUGIN_UPLOAD_REALDIR . "AddSearchItem/class/plg_AddSearchItem_LC_Page.php";

class plg_AddSearchitem_LC_Page_FrontParts_Bloc_SearchProducts extends plg_AddSearchItem_LC_Page{	
    /**
     * @param LC_Page_FrontParts_Bloc_SearchProducts $objPage
     * @return void
     */
    function before($objPage) {
		$objPage->fs_enable = plg_AddSearchItem_Util::existsFreeShippingPlg();
		$objPage->use_stock = plg_AddSearchItem_Util::getConfig('stock');
		$objPage->use_review = plg_AddSearchItem_Util::getConfig('review');
		$objPage->use_fs = plg_AddSearchItem_Util::getConfig('freeshipping');
		$objPage->use_price = plg_AddSearchItem_Util::getConfig('price');
		$objPage->arrSTATUS = plg_AddSearchItem_Util::getStatusList();
    }
	
    /**
     * @param LC_Page_FrontParts_Bloc_SearchProducts $objPage
     * @return void
     */
    function after($objPage) {
		parent::after($objPage);
    }
}