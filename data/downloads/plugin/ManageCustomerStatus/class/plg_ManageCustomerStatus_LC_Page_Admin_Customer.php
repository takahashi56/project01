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

class plg_ManageCustomerStatus_LC_Page_Admin_Customer extends plg_ManageCustomerStatus_LC_Page{
    /**
     * @param LC_Page_Admin_Customer_Edit $objPage 会員マスタのページクラス
     * @return void
     */
    function before($objPage) {
		$objPage->arrPlgManageCustomerStatus = plg_ManageCustomerStatus_Utils::getStatusRankList();
		if($objPage->getMode() == 'csv'){
			// パラメーター管理クラス
			$objFormParam = new SC_FormParam_Ex();
			// パラメーター設定
			$objPage->lfInitParam($objFormParam);
			plg_ManageCustomerStatus_Utils::addSearchManageCustomerStatusParam($objFormParam);
			$objFormParam->setParam($_POST);
			$objFormParam->convParam();

			// 検索ワードの引き継ぎ
			$objPage->arrHidden = $objFormParam->getSearchArray();
	
			// 入力パラメーターチェック
			$objPage->arrErr = $objPage->lfCheckError($objFormParam);
			if (!SC_Utils_Ex::isBlank($objPage->arrErr)) {
				return;
			}
			
			$arrParam = $objFormParam->getHashArray();
			$objSelect = new SC_CustomerList_Ex($arrParam, 'customer');
			$objCSV = new SC_Helper_CSV_Ex();
	
			$order = 'update_date DESC, customer_id DESC';
	
			list($where, $arrVal) = $objSelect->getWhere();
						
			$add_where = "";
			// 会員ランク

			if (!isset($arrParam['search_plg_managecustomerstatus_status'])) $arrParam['search_plg_managecustomerstatus_status'] = '';
			if (is_array($arrParam['search_plg_managecustomerstatus_status'])) {
				$add_where .= " AND (";
				foreach ($arrParam['search_plg_managecustomerstatus_status'] as $key => $data) {
					if($key > 0)$add_where .= " OR ";
					$add_where .= "plg_managecustomerstatus_status = ?";
					$arrVal[] = $data;
				}
				$add_where .= ")";
			}
			$where .= $add_where;
	
			$objCSV->sfDownloadCsv('2', $where, $arrVal, $order, true);
			exit;
		}
    }
}