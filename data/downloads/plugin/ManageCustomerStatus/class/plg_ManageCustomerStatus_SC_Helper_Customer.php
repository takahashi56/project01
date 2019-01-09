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

class plg_ManageCustomerStatus_SC_Helper_Customer extends SC_Helper_Customer{

    /**
     * 会員一覧検索をする処理（ページング処理付き、管理画面用共通処理）
     *
     * @param array $arrParam 検索パラメーター連想配列
     * @param string $limitMode ページングを利用するか判定用フラグ
     * @return array( integer 全体件数, mixed 会員データ一覧配列, mixed SC_PageNaviオブジェクト)
     */
    function sfGetSearchData($arrParam, $limitMode = '') {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objSelect = new SC_CustomerList_Ex($arrParam, 'customer');
        $page_max = SC_Utils_Ex::sfGetSearchPageMax($arrParam['search_page_max']);
        $disp_pageno = $arrParam['search_pageno'];
        if ($disp_pageno == 0) {
            $disp_pageno = 1;
        }
        $offset = intval($page_max) * (intval($disp_pageno) - 1);
        if ($limitMode == '') {
            $objQuery->setLimitOffset($page_max, $offset);
        }
		$where = $objSelect->getList();
		if(strpos($where,'mailmaga_flg FROM') > 0){
			$where = str_replace('mailmaga_flg FROM','mailmaga_flg,plg_managecustomerstatus_status FROM',$where);
		}
		$arrWhere = $objSelect->arrVal;
		$count_where = $objSelect->getListCount();
		
		$add_where = "";
        // 会員ランク
		if(plg_ManageCustomerStatus_Utils::getECCUBEVer() >= 2130){
			if (!isset($arrParam['search_plg_managecustomerstatus_status'])) $arrParam['search_plg_managecustomerstatus_status'] = '';
			if (is_array($arrParam['search_plg_managecustomerstatus_status'])) {
				$add_where .= " AND (";
				foreach ($arrParam['search_plg_managecustomerstatus_status'] as $key => $data) {
					if($key > 0)$add_where .= " OR ";
					$add_where .= "plg_managecustomerstatus_status = ?";
					$arrWhere[] = $data;
				}
				$add_where .= ")";
			}
			if(strpos($where,'ORDER BY') > 0){
				$where = str_replace('ORDER BY',$add_where . ' ORDER BY',$where);
			}
			$count_where .= $add_where;
		}else{
			if (!isset($arrParam['search_plg_managecustomerstatus_status'])) $arrParam['search_plg_managecustomerstatus_status'] = '';
			if (is_array($arrParam['search_plg_managecustomerstatus_status'])) {
				$add_where .= " AND (";
				foreach ($arrParam['search_plg_managecustomerstatus_status'] as $key => $data) {
					if($key > 0)$add_where .= " OR ";
					$add_where .= "plg_managecustomerstatus_status = ?";
					$arrWhere[] = $data;
				}
				$add_where .= ")";
			}
			$where .= $add_where;
			$count_where .= $add_where;
		}

        $arrData = $objQuery->getAll($where, $arrWhere);

        // 該当全体件数の取得
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $linemax = $objQuery->getOne($count_where, $arrWhere);

        // ページ送りの取得
		if(plg_ManageCustomerStatus_Utils::getECCUBEVer() >= 2130){
			$objNavi = new SC_PageNavi_Ex($arrParam['search_pageno'],
										$linemax,
										$page_max,
										'eccube.moveSearchPage',
										NAVI_PMAX);			
		}else{
			$objNavi = new SC_PageNavi_Ex($arrParam['search_pageno'],
										$linemax,
										$page_max,
										'fnNaviSearchOnlyPage',
										NAVI_PMAX);
		}
        return array($linemax, $arrData, $objNavi);
    }

    function getListMailMagazine($is_mobile = false) {

        $colomn = $this->getMailMagazineColumn($is_mobile);
        $this->select = "
            SELECT
                $colomn
            FROM
                dtb_customer";
        return $this->getSql(0);
    }
}