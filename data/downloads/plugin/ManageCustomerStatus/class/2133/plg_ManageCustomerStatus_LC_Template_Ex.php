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
require_once PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/class/plg_ManageCustomerStatus_LC_Template.php";

class plg_ManageCustomerStatus_LC_Template_Ex extends plg_ManageCustomerStatus_LC_Template{
    function prefilterTransform(&$source, LC_Page_Ex $objPage, $filename) {
		if(GC_Utils_Ex::isAdminFunction()){
			parent::prefilterTransform($source, $objPage, $filename);
		}
		
        $objTransform = new SC_Helper_Transform($source);
        $template_base_dir = PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/templates/';
        $template_ex_dir = PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/templates/2133/';
        switch($objPage->arrPageLayout['device_type_id']){
            case DEVICE_TYPE_PC:
				$template_dir = $template_base_dir . "default/";
				$template_ex_dir = $template_ex_dir . "default/";
                if (strpos($filename, 'mypage/navi.tpl') !== false) {
					$objTransform->select('div#mynavi_area',0,false)->appendChild(file_get_contents($template_ex_dir . 'mypage/info.tpl'));
					$objTransform->select('div.point_announce',0,false)->appendChild(file_get_contents($template_dir . 'mypage/point_info.tpl'));
                }
                if (strpos($filename, 'mypage/favorite.tpl') !== false) {
					$objTransform->select('span.price',0,false)->insertAfter(file_get_contents($template_ex_dir . 'mypage/favorite_price.tpl'));
                }
                if(strpos($filename, "products/list.tpl") !== false) {
                    $objTransform->select("span.price",0,false)->insertAfter(file_get_contents($template_ex_dir ."products/list.tpl"));
					$objTransform->select('div#undercolumn',0,false)->insertBefore(file_get_contents($template_ex_dir . 'products/list_js.tpl'));
					$objTransform->select("div.cartin",0,false)->replaceElement(file_get_contents($template_dir ."products/list_cartin.tpl"));
					$objTransform->select("div.classlist",0,false)->replaceElement(file_get_contents($template_dir ."products/list_classlist.tpl"));
				}
                if(strpos($filename, "products/detail.tpl") !== false) {
                   	$objTransform->select("dl.sale_price",0,false)->insertAfter(file_get_contents($template_ex_dir ."products/detail.tpl"));
					$objTransform->select("div.point",0,false)->replaceElement(file_get_contents($template_ex_dir ."products/detail_point.tpl"));
					$objTransform->select("div.cartin",0,false)->replaceElement(file_get_contents($template_dir ."products/detail_cartin.tpl"));
					$objTransform->select("dl.quantity",0,false)->replaceElement(file_get_contents($template_dir ."products/detail_quantity.tpl"));
					$objTransform->select("div.classlist",0,false)->replaceElement(file_get_contents($template_dir ."products/detail_classlist.tpl"));
				}
                break;
            case DEVICE_TYPE_MOBILE:
				$template_dir = $template_base_dir . "mobile/";
				$template_ex_dir = $template_ex_dir . "mobile/";
                if (strpos($filename, 'mypage/index.tpl') !== false) {
					$objTransform->select('hr',0,false)->insertBefore(file_get_contents($template_ex_dir . 'mypage/info.tpl'));
                }
                if(strpos($filename, "products/list.tpl") !== false) {
                    $objTransform->select("br",3,false)->insertAfter(file_get_contents($template_ex_dir ."products/list.tpl"));
				}
                if(strpos($filename, "products/detail.tpl") !== false) {
                    $objTransform->select("",0,false)->replaceElement(file_get_contents($template_ex_dir ."products/detail.tpl"));
				}
                break;
            case DEVICE_TYPE_SMARTPHONE:
				$template_dir = $template_base_dir . "sphone/";
				$template_ex_dir = $template_ex_dir . "sphone/";
                if (strpos($filename, 'mypage/navi.tpl') !== false) {
					$objTransform->select('nav',0,false)->insertAfter(file_get_contents($template_ex_dir . 'mypage/info.tpl'));
                }
                if (strpos($filename, 'mypage/favorite.tpl') !== false) {
					$objTransform->select('div.favoriteContents p',0,false)->appendChild(file_get_contents($template_ex_dir . 'mypage/favorite_price.tpl'));
                }
                if(strpos($filename, "products/list.tpl") !== false) {
                    $objTransform->select("span.price",0,false)->insertAfter(file_get_contents($template_ex_dir ."products/list.tpl"));
					$objTransform->select("div.btn_area p",0,false)->replaceElement(file_get_contents($template_dir ."products/list_btn_area.tpl"));
					$objTransform->select("section#product_list",0,false)->insertAfter(file_get_contents($template_ex_dir ."products/list_js.tpl"));
				}
                if(strpos($filename, "products/detail.tpl") !== false) {
                   	$objTransform->select("p.sale_price",0,false)->insertAfter(file_get_contents($template_ex_dir ."products/detail.tpl"));
					$objTransform->select("p.sale_price",1,false)->replaceElement(file_get_contents($template_ex_dir ."products/detail_point.tpl"));
					$objTransform->select("div.cartin_btn",0,false)->replaceElement(file_get_contents($template_dir ."products/detail_cartin.tpl"));
					$objTransform->select("div.cart_area",0,false)->replaceElement(file_get_contents($template_dir ."products/detail_cart_area.tpl"));
					$objTransform->select("div.review_btn",0,false)->replaceElement(file_get_contents($template_dir ."products/detail_review_btn.tpl"));
				}
				break;
            case DEVICE_TYPE_ADMIN:
            default:
                if(strpos($filename, "frontparts/bloc/recommend.tpl") !== false) {
					if (SC_Display_Ex::$device) {
						switch (SC_Display_Ex::$device) {
							case DEVICE_TYPE_PC:
								$template_dir = $template_base_dir . "default/";
								$template_ex_dir = $template_ex_dir . "default/";
								$objTransform->select("p.sale_price",0,false)->appendChild(file_get_contents($template_ex_dir ."frontparts/bloc/recommend.tpl"));
								break;
							case DEVICE_TYPE_SMARTPHONE:
								$template_dir = $template_base_dir . "sphone/";
								$template_ex_dir = $template_ex_dir . "sphone/";
								$objTransform->select("p.sale_price",0,false)->appendChild(file_get_contents($template_ex_dir ."frontparts/bloc/recommend.tpl"));
								break;
							default:
								break;
						}
					}
				}
                if(strpos($filename, "frontparts/bloc/login.tpl") !== false) {
					if (SC_Display_Ex::$device) {
						switch (SC_Display_Ex::$device) {
							case DEVICE_TYPE_PC:
								$template_dir = $template_base_dir . "default/";
								$objTransform->select("div.block_body p",0,false)->appendChild(file_get_contents($template_dir ."frontparts/bloc/login.tpl"));
								break;
							default:
								break;
						}
					}
				}
                if(strpos($filename, "frontparts/bloc/login_footer.tpl") !== false) {
					if (SC_Display_Ex::$device) {
						switch (SC_Display_Ex::$device) {
							case DEVICE_TYPE_SMARTPHONE:
								$template_dir = $template_base_dir . "sphone/";
								$objTransform->select("p",1,false)->insertAfter(file_get_contents($template_dir ."frontparts/bloc/login_footer.tpl"));
								break;
							default:
								break;
						}
					}
				}
                break;
        }
        $source = $objTransform->getHTML();
    }
}