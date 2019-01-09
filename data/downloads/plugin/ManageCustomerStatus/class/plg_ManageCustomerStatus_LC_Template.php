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

class plg_ManageCustomerStatus_LC_Template{

    function prefilterTransform(&$source, LC_Page_Ex $objPage, $filename) {
		if(plg_ManageCustomerStatus_Utils::getECCUBEVer() >= 2130){
			$version = '213';
		}else{
			$version = '212';
		}
        $objTransform = new SC_Helper_Transform($source);
        $template_base_dir = PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/templates/';
        $template_ex_dir = PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/templates/'.$version."/";
        switch($objPage->arrPageLayout['device_type_id']){
            case DEVICE_TYPE_PC:
				$template_dir = $template_base_dir . "default/";
				$template_ex_dir = $template_ex_dir . "default/";
                if (strpos($filename, 'mypage/navi.tpl') !== false) {
					$objTransform->select('div#mynavi_area',0,false)->appendChild(file_get_contents($template_dir . 'mypage/info.tpl'));
					$objTransform->select('div.point_announce',0,false)->appendChild(file_get_contents($template_dir . 'mypage/point_info.tpl'));
                }
                if (strpos($filename, 'mypage/favorite.tpl') !== false) {
					$objTransform->select('span.price',0,false)->insertAfter(file_get_contents($template_dir . 'mypage/favorite_price.tpl'));
                }
                if(strpos($filename, "products/list.tpl") !== false) {
                    $objTransform->select("span.price",0,false)->insertAfter(file_get_contents($template_dir ."products/list.tpl"));
					$objTransform->select('div#undercolumn',0,false)->insertBefore(file_get_contents($template_ex_dir . 'products/list_js.tpl'));
					$objTransform->select("div.cartin",0,false)->replaceElement(file_get_contents($template_dir ."products/list_cartin.tpl"));
					$objTransform->select("div.classlist",0,false)->replaceElement(file_get_contents($template_dir ."products/list_classlist.tpl"));
				}
                if(strpos($filename, "products/detail.tpl") !== false) {
                   	$objTransform->select(".sale_price",0,false)->insertAfter(file_get_contents($template_ex_dir ."products/detail.tpl"));
					$objTransform->select(".point",0,false)->replaceElement(file_get_contents($template_dir ."products/detail_point.tpl"));
					$objTransform->select(".cartin",0,false)->replaceElement(file_get_contents($template_dir ."products/detail_cartin.tpl"));
					$objTransform->select(".quantity",0,false)->replaceElement(file_get_contents($template_dir ."products/detail_quantity.tpl"));
					$objTransform->select(".classlist",0,false)->replaceElement(file_get_contents($template_dir ."products/detail_classlist.tpl"));
				}
                break;
            case DEVICE_TYPE_MOBILE:
				$template_dir = $template_base_dir . "mobile/";
                if (strpos($filename, 'mypage/index.tpl') !== false) {
					$objTransform->select('hr',0,false)->insertBefore(file_get_contents($template_dir . 'mypage/info.tpl'));
                }
                if(strpos($filename, "products/list.tpl") !== false) {
                    $objTransform->select("br",3,false)->insertAfter(file_get_contents($template_dir ."products/list.tpl"));
				}
                if(strpos($filename, "products/detail.tpl") !== false) {
                    $objTransform->select("",0,false)->replaceElement(file_get_contents($template_dir ."products/detail.tpl"));
				}
                break;
            case DEVICE_TYPE_SMARTPHONE:
				$template_dir = $template_base_dir . "sphone/";
				$template_ex_dir = $template_ex_dir . "sphone/";
                if (strpos($filename, 'mypage/navi.tpl') !== false) {
					$objTransform->select('nav',0,false)->insertAfter(file_get_contents($template_dir . 'mypage/info.tpl'));
                }
                if (strpos($filename, 'mypage/favorite.tpl') !== false) {
					$objTransform->select('div.favoriteContents p',0,false)->appendChild(file_get_contents($template_dir . 'mypage/favorite_price.tpl'));
                }
                if(strpos($filename, "products/list.tpl") !== false) {
                    $objTransform->select("span.price",0,false)->insertAfter(file_get_contents($template_dir ."products/list.tpl"));
					$objTransform->select("div.btn_area p",0,false)->replaceElement(file_get_contents($template_dir ."products/list_btn_area.tpl"));
					$objTransform->select("section#product_list",0,false)->insertAfter(file_get_contents($template_ex_dir ."products/list_js.tpl"));
				}
                if(strpos($filename, "products/detail.tpl") !== false) {
                   	$objTransform->select("p.sale_price",0,false)->insertAfter(file_get_contents($template_ex_dir ."products/detail.tpl"));
					$objTransform->select("p.sale_price",1,false)->replaceElement(file_get_contents($template_dir ."products/detail_point.tpl"));
					$objTransform->select("div.cartin_btn",0,false)->replaceElement(file_get_contents($template_dir ."products/detail_cartin.tpl"));
					$objTransform->select("div.cart_area",0,false)->replaceElement(file_get_contents($template_dir ."products/detail_cart_area.tpl"));
					$objTransform->select("div.review_btn",0,false)->replaceElement(file_get_contents($template_dir ."products/detail_review_btn.tpl"));
				}
				break;
            case DEVICE_TYPE_ADMIN:
            default:
				$template_dir = $template_base_dir . "admin/";
                if (strpos($filename, 'customer/subnavi.tpl') !== false) {
					$objTransform->select('ul.level1',0)->appendChild(file_get_contents($template_dir . 'customer/subnavi.tpl'));
                }
                if (strpos($filename, 'customer/index.tpl') !== false) {
					$objTransform->select('div#customer table.form tr',0)->insertAfter(file_get_contents($template_dir . 'customer/index.tpl'));
					$objTransform->select('table.list col',2)->replaceElement(file_get_contents($template_dir . 'customer/index_col.tpl'));
					$objTransform->select('table.list th',0)->insertAfter(file_get_contents($template_dir . 'customer/index_th.tpl'));
					$objTransform->select('table.list td',0)->insertAfter(file_get_contents($template_dir . 'customer/index_td.tpl'));
                }
                if (strpos($filename, 'customer/edit.tpl') !== false) {
					$objTransform->select('div#customer table.form tr',1)->insertAfter(file_get_contents($template_dir . 'customer/edit.tpl'));
                }
                if (strpos($filename, 'customer/edit_confirm.tpl') !== false) {
					$objTransform->select('div#customer table.form tr',1)->insertAfter(file_get_contents($template_dir . 'customer/edit_confirm.tpl'));
                }
                if(strpos($filename, "products/product.tpl") !== false) {
                    $objTransform->select("table.form tr",11)->insertAfter(file_get_contents($template_dir ."products/product.tpl"));
					 $objTransform->select("table.form tr",4)->insertAfter(file_get_contents($template_dir ."products/product_disp.tpl"));
				}
                if(strpos($filename, "products/confirm.tpl") !== false) {
                    $objTransform->select("div.contents-main table tr",9)->insertAfter(file_get_contents($template_dir ."products/confirm.tpl"));
                    $objTransform->select("div.contents-main table tr",2)->insertAfter(file_get_contents($template_dir ."products/confirm_disp.tpl"));
					$objTransform->select("form input",5)->replaceElement(file_get_contents($template_dir ."products/confirm_hidden.tpl"));
				}
                if(strpos($filename, "products/product_class.tpl") !== false) {
                    $objTransform->select("table.list tr th",6)->insertAfter(file_get_contents($template_dir ."products/product_class_th.tpl"));
                    $objTransform->select("table.list tr td.center",6)->insertAfter(file_get_contents($template_dir ."products/product_class_td.tpl"));
                    $objTransform->select("h2",0)->insertBefore(file_get_contents($template_dir ."products/product_class_js.tpl"));
				}
                if(strpos($filename, "products/product_class_confirm.tpl") !== false) {
                    $objTransform->select("table.list tr th",5)->insertAfter(file_get_contents($template_dir ."products/product_class_th.tpl"));
					$objTransform->select("table.list tr td.right",2)->insertAfter(file_get_contents($template_dir ."products/product_class_confirm_td.tpl"));
				}
                if(strpos($filename, "order/edit.tpl") !== false || strpos($filename, "order_edit.tpl") !== false) {
                    $objTransform->select("table.form",1,false)->find("tr",0)->insertAfter(file_get_contents($template_dir ."order/edit.tpl"));
                }
                if(strpos($filename, "mail/index.tpl") !== false) {
                    $objTransform->select("table tr",1)->insertBefore(file_get_contents($template_dir ."mail/". "index.tpl"));
                }
                if(strpos($filename, "mail/query.tpl") !== false) {
                    $objTransform->select("table.form tr",18)->insertBefore(file_get_contents($template_dir ."mail/". "query.tpl"));
                }
                if(strpos($filename, "mail/input.tpl") !== false) {
                    $objTransform->select("table.form tr th",2)->replaceElement(file_get_contents($template_dir ."mail/". "input.tpl"));
                }
                if(strpos($filename, "mail/template_input.tpl") !== false) {
                    $objTransform->select("table.form tr th",2)->replaceElement(file_get_contents($template_dir ."mail/". "input.tpl"));
                }
                if(strpos($filename, "frontparts/bloc/recommend.tpl") !== false) {
					if (SC_Display_Ex::$device) {
						switch (SC_Display_Ex::$device) {
							case DEVICE_TYPE_PC:
								$template_dir = $template_base_dir . "default/";
								$objTransform->select("p.sale_price",0,false)->appendChild(file_get_contents($template_dir ."frontparts/bloc/recommend.tpl"));
								break;
							case DEVICE_TYPE_SMARTPHONE:
								$template_dir = $template_base_dir . "sphone/";
								$objTransform->select("p.sale_price",0,false)->appendChild(file_get_contents($template_dir ."frontparts/bloc/recommend.tpl"));
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
	
	function postfilterTransform(&$source, LC_Page_Ex $objPage, $filename){
	}
}