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

class plg_AddSearchitem_LC_Page_Products_Search extends plg_AddSearchItem_LC_Page{
    /**
     * @param LC_Page_Products_Search $objPage
     * @return void
     */
    function before($objPage) {
		parent::before($objPage);
    }
	
    /**
     * @param LC_Page_Products_Search $objPage
     * @return void
     */
    function after($objPage) {
		if(SC_Display_Ex::detectDevice() === DEVICE_TYPE_SMARTPHONE){
			$objPage->tpl_mainpage = PLUGIN_UPLOAD_REALDIR . "AddSearchItem/templates/sphone/products/search.tpl";
		}
        // カテゴリ検索用選択リスト
        $objPage->arrCatList = self::lfGetCategoryList();
        // メーカー検索用選択リスト
        $objPage->arrMakerList = self::lfGetMakerList();

		$objPage->fs_enable = plg_AddSearchItem_Util::existsFreeShippingPlg();
		
		// 商品ステータスリスト
		$objPage->arrSTATUS = plg_AddSearchItem_Util::getStatusList();
    }
	
    /**
     * カテゴリ検索用選択リストを取得する
     *
     * @return array $arrCategoryList カテゴリ検索用選択リスト
     */
    function lfGetCategoryList() {
        $objDb = new SC_Helper_DB_Ex();
        // カテゴリ検索用選択リスト
        $arrCategoryList = $objDb->sfGetCategoryList('', true, '　');
        if (is_array($arrCategoryList)) {
            // 文字サイズを制限する
            foreach ($arrCategoryList as $key => $val) {
                $truncate_str = SC_Utils_Ex::sfCutString($val, SEARCH_CATEGORY_LEN, false);
                $arrCategoryList[$key] = preg_replace('/　/u', '&nbsp;&nbsp;', $truncate_str);
            }
        }
        return $arrCategoryList;
    }

    /**
     * メーカー検索用選択リストを取得する
     *
     * @return array $arrMakerList メーカー検索用選択リスト
     */
    function lfGetMakerList() {
        $objDb = new SC_Helper_DB_Ex();
        // メーカー検索用選択リスト
        $arrMakerList = $objDb->sfGetMakerList('', true);
        if (is_array($arrMakerList)) {
            // 文字サイズを制限する
            foreach ($arrMakerList as $key => $val) {
                $arrMakerList[$key] = SC_Utils_Ex::sfCutString($val, SEARCH_CATEGORY_LEN, false);
            }
        }
        return $arrMakerList;
    }
}