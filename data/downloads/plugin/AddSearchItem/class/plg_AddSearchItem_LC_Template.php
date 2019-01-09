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


class plg_AddSearchItem_LC_Template{

    function prefilterTransform(&$source, LC_Page_Ex $objPage, $filename) {
        $objTransform = new SC_Helper_Transform($source);
		$template_dir = PLUGIN_UPLOAD_REALDIR . "AddSearchItem/templates/";
		
		$deviceTypeId = GC_Utils_Ex::isAdminFunction() ? DEVICE_TYPE_ADMIN : (isset($objPage->arrPageLayout['device_type_id']) ? $objPage->arrPageLayout['device_type_id'] : SC_Display_Ex::detectDevice());
		
        switch($deviceTypeId) {
            case DEVICE_TYPE_SMARTPHONE:
				$template_dir .= "sphone/";
                if(strpos($filename, "products/list.tpl") !== false) {
                    $objTransform->select("section.pagenumberarea",0,false)->replaceElement(file_get_contents($template_dir ."products/list_sort.tpl"));
                    $objTransform->select("form#form1",0,false)->appendChild(file_get_contents($template_dir ."products/list_hidden.tpl"));
				}
                if(strpos($filename, "shopping/payment.tpl") === false) {
                    $objTransform->select("section#search_area",NULL,false)->appendChild(file_get_contents($template_dir ."search_area.tpl"));
				}
				break;
            case DEVICE_TYPE_MOBILE:
				$template_dir .= "mobile/";
                if(strpos($filename, "products/search.tpl") !== false) {
                    $objTransform->select("")->replaceElement(file_get_contents($template_dir ."products/search.tpl"));
				}
				break;
            case DEVICE_TYPE_PC:
				$template_dir .= "default/";
                if(strpos($filename, "products/list.tpl") !== false) {
                    $objTransform->select("div.change",0,false)->replaceElement(file_get_contents($template_dir ."products/list_sort.tpl"));
                    $objTransform->select("form#form1",0,false)->appendChild(file_get_contents($template_dir ."products/list_hidden.tpl"));
                    $objTransform->select("ul.pagecond_area li",2,false)->replaceElement(file_get_contents($template_dir ."products/list_result.tpl"));
				}
                if(strpos($filename, "frontparts/bloc/search_products.tpl") !== false) {
                    $objTransform->select("div.block_body dl.formlist",2,false)->insertAfter(file_get_contents($template_dir ."frontparts/bloc/search_products.tpl"));
				}
                break;
            case DEVICE_TYPE_ADMIN:
			default:			
				break;
        }
        $source = $objTransform->getHTML();
    }
	
	function postfilterTransform(&$source, LC_Page_Ex $objPage, $filename){
	}
}