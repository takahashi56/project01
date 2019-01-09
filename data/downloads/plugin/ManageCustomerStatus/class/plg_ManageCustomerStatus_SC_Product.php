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

class plg_ManageCustomerStatus_SC_Product extends SC_Product{
    /**
     * SC_Queryインスタンスに設定された検索条件をもとに商品一覧の配列を取得する.
     *
     * 主に SC_Product::findProductIds() で取得した商品IDを検索条件にし,
     * SC_Query::setOrder() や SC_Query::setLimitOffset() を設定して, 商品一覧
     * の配列を取得する.
     *
     * @param SC_Query $objQuery SC_Query インスタンス
     * @return array 商品一覧の配列
     */
    function lists(&$objQuery) {
        $col = <<< __EOS__
             product_id
            ,product_code_min
            ,product_code_max
            ,name
            ,comment1
            ,comment2
            ,comment3
            ,main_list_comment
            ,main_image
            ,main_list_image
            ,price01_min
            ,price01_max
            ,price02_min
            ,price02_max
            ,stock_min
            ,stock_max
            ,stock_unlimited_min
            ,stock_unlimited_max
            ,deliv_date_id
            ,status
            ,del_flg
            ,update_date
__EOS__;
        $res = $objQuery->select($col, $this->alldtlSQL());
		
		$objCustomer = new SC_Customer_Ex();
		$objQuery2 =& SC_Query_Ex::getSingletonInstance();
		
		if($objCustomer->isLoginSuccess(true)){
			$status_id = $objCustomer->getValue('plg_managecustomerstatus_status');
		}
		if(empty($status_id)){
			$status_id = $objQuery2->get("status_id","plg_managecustomerstatus_dtb_customer_status","initial_rank = ?",array(1));
			$initail_status_flg = 1;
		}
		
		foreach($res as $key => $item){
			if($status_id > 0){
				$ret = array();
				$cnt = $objQuery2->get('COUNT(*)','dtb_products_class','product_id = ?', array($item['product_id']));
				if($cnt > 1){
					$has_product_class = true;
				}else{
					$has_product_class = false;
				}

				$ret = $objQuery2->getRow("max(plg.price) as max_price,min(plg.price) as min_price",
				"plg_managecustomerstatus_dtb_price plg LEFT JOIN dtb_products_class class ON plg.product_class_id = class.product_class_id",
				"class.del_flg = 0 AND plg.product_id = ? AND plg.status_id =?",array($item['product_id'],$status_id));
				
				if(is_numeric($ret['min_price'])){
					$rprice_min_fix = $ret['min_price'];
					$rprice_max_fix = $ret['max_price'];
				}
			
				$default_product_class_id = $objQuery2->get('product_class_id','dtb_products_class','product_id = ? AND classcategory_id1 = 0 AND classcategory_id2 = 0', array($item['product_id']));
				$member_cnt = $objQuery2->get("COUNT(*)","plg_managecustomerstatus_dtb_price","product_id = ? AND status_id =? AND product_class_id <> ?",array($item['product_id'],$status_id,$default_product_class_id));
				$class_cnt = $objQuery2->get("COUNT(*)","dtb_products_class","product_id = ? AND product_class_id <> ? AND del_flg <> 1",array($item['product_id'],$default_product_class_id));
				if($member_cnt != $class_cnt || ($has_product_class === false && strlen($rprice_min_fix)==0)){
					$arrStatus = $objQuery2->getRow("discount_rate,discount_value","plg_managecustomerstatus_dtb_customer_status","status_id =?",array($status_id));
					if($arrStatus['discount_rate'] > 0){
						$rprice_min_discount = floor($item['price02_min'] * (1.0 - $arrStatus['discount_rate']/100));
						$rprice_max_discount = floor($item['price02_max'] * (1.0 - $arrStatus['discount_rate']/100));
					}else{
						$rprice_min_02 = $item['price02_min'];
						$rprice_max_02 = $item['price02_max'];
					}
				}

				if(isset($rprice_min_fix) && isset($rprice_min_discount)){
					if($rprice_min_fix < $rprice_min_discount){
						$rprice_min = $rprice_min_fix;
					}else{
						$rprice_min = $rprice_min_discount;
					}
				}elseif(isset($rprice_min_fix)){
					$rprice_min = $rprice_min_fix;
				}elseif(isset($rprice_min_discount)){
					$rprice_min = $rprice_min_discount;
				}
				
				if(isset($rprice_min_02)){
					if(isset($rprice_min)){
						if($rprice_min > $rprice_min_02){
							$rprice_min = $rprice_min_02;
						}
					}
				}
				
				if(isset($rprice_max_fix) && isset($rprice_max_discount)){
					if($rprice_max_fix > $rprice_max_discount){
						$rprice_max = $rprice_max_fix;
					}else{
						$rprice_max = $rprice_max_discount;
					}
				}elseif(isset($rprice_max_fix)){
					$rprice_max = $rprice_max_fix;
				}elseif(isset($rprice_max_discount)){
					$rprice_max = $rprice_max_discount;
				}
				
				if(isset($rprice_max_02)){
					if(isset($rprice_max)){
						if($rprice_max < $rprice_max_02){
							$rprice_max = $rprice_max_02;
						}
					}
				}
				
				if(isset($rprice_min))$res[$key]["plg_managecustomerstatus_price_min"] = $rprice_min;
				if(isset($rprice_max))$res[$key]["plg_managecustomerstatus_price_max"] = $rprice_max;
			}
			
			$ret = $objQuery2->getCol('status_id',"plg_managecustomerstatus_dtb_product_disp","product_id = ?",array($item['product_id']));

			if(count($ret) > 0 && !empty($ret[0])){
				if($objCustomer->isLoginSuccess(true)){
					if($initail_status_flg == 1){
						$search_id = 0;
					}else{
						$search_id = $status_id;
					}
					if(in_array($search_id,$ret)){
						$res[$key]["plg_managecustomerstatus_hidden_flg"] = 1;
					}
				}else{
					$res[$key]["plg_managecustomerstatus_hidden_flg"] = 2;
				}
			}
			unset($rprice_min_fix);
			unset($rprice_max_fix);
			unset($rprice_min_discount);
			unset($rprice_max_discount);
			unset($rprice_min_02);
			unset($rprice_max_02);
			unset($rprice_min);
			unset($rprice_max);
		}
		
        return $res;
    }
	
    /**
     * 商品詳細を取得する.
     *
     * @param integer $productId 商品ID
     * @return array 商品詳細情報の配列
     */
    function getDetail($productId) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
		$arrProduct = $objQuery->getRow('*', $this->alldtlSQL('product_id = ?'),
										'product_id = ?',
										array($productId, $productId));
		$arrProduct = (array)$arrProduct;

		
		$objCustomer = new SC_Customer_Ex();
		if($objCustomer->isLoginSuccess(true)){
			$status_id = $objCustomer->getValue('plg_managecustomerstatus_status');
		}
		if(empty($status_id)){
			$status_id = $objQuery->get("status_id","plg_managecustomerstatus_dtb_customer_status","initial_rank = ?",array(1));
			$initail_status_flg = 1;
		}
		if($status_id > 0){
			$ret = $objQuery->getRow("max(plg.price) as max_price,min(plg.price) as min_price",
				"plg_managecustomerstatus_dtb_price plg LEFT JOIN dtb_products_class class ON plg.product_class_id = class.product_class_id",
				"class.del_flg = 0 AND plg.product_id = ? AND plg.status_id =?",array($productId,$status_id));

			if(is_numeric($ret['min_price'])){
				$rprice_min_fix = $ret['min_price'];
				$rprice_max_fix = $ret['max_price'];
			}
			
			$cnt = $objQuery->get('COUNT(*)','dtb_products_class','product_id = ?', array($productId));
			if($cnt > 1){
				$has_product_class = true;
			}else{
				$has_product_class = false;
			}
			$default_product_class_id = $objQuery->get('product_class_id','dtb_products_class','product_id = ? AND classcategory_id1 = 0 AND classcategory_id2 = 0', array($productId));
			$member_cnt = $objQuery->get("COUNT(*)","plg_managecustomerstatus_dtb_price","product_id = ? AND status_id =? AND product_class_id <> ?",array($productId,$status_id,$default_product_class_id));
			$class_cnt = $objQuery->get("COUNT(*)","dtb_products_class","product_id = ? AND product_class_id <> ? AND del_flg <> 1",array($productId,$default_product_class_id));

			if($member_cnt != $class_cnt || ($has_product_class === false && strlen($rprice_min_fix)==0)){
				$arrStatus = $objQuery->getRow("discount_rate,discount_value","plg_managecustomerstatus_dtb_customer_status","status_id =?",array($status_id));
				if($arrStatus['discount_rate'] > 0){
					$rprice_min_discount = floor($arrProduct['price02_min'] * (1.0 - $arrStatus['discount_rate']/100));
					$rprice_max_discount = floor($arrProduct['price02_max'] * (1.0 - $arrStatus['discount_rate']/100));
				}else{
					$rprice_min_02 = $arrProduct['price02_min'];
					$rprice_max_02 = $arrProduct['price02_max'];
				}
			}
			
			if(isset($rprice_min_fix) && isset($rprice_min_discount)){
				if($rprice_min_fix < $rprice_min_discount){
					$rprice_min = $rprice_min_fix;
				}else{
					$rprice_min = $rprice_min_discount;
				}
			}elseif(isset($rprice_min_fix)){
				$rprice_min = $rprice_min_fix;
			}elseif(isset($rprice_min_discount)){
				$rprice_min = $rprice_min_discount;
			}
			
			if(isset($rprice_min_02)){
				if($rprice_min > $rprice_min_02){
					$rprice_min = $rprice_min_02;
				}
			}
			
			if(isset($rprice_max_fix) && isset($rprice_max_discount)){
				if($rprice_max_fix > $rprice_max_discount){
					$rprice_max = $rprice_max_fix;
				}else{
					$rprice_max = $rprice_max_discount;
				}
			}elseif(isset($rprice_max_fix)){
				$rprice_max = $rprice_max_fix;
			}elseif(isset($rprice_max_discount)){
				$rprice_max = $rprice_max_discount;
			}
			
			if(isset($rprice_max_02)){
				if($rprice_max < $rprice_max_02){
					$rprice_max = $rprice_max_02;
				}
			}
			
			$arrProduct["plg_managecustomerstatus_price_min"] = $rprice_min;
			$arrProduct["plg_managecustomerstatus_price_max"] = $rprice_max;
		}
		$ret = $objQuery->getCol('status_id',"plg_managecustomerstatus_dtb_product_disp","product_id = ?",array($productId));
		if(count($ret) > 0 && !empty($ret[0])){
			if($objCustomer->isLoginSuccess(true)){
				if($initail_status_flg == 1)$status_id = 0;
				if(in_array($status_id,$ret)){
					$arrProduct["plg_managecustomerstatus_hidden_flg"] = 1;
				}
			}else{
				$arrProduct["plg_managecustomerstatus_hidden_flg"] = 2;
			}
		}
        // 税込金額を設定する
        SC_Product_Ex::setIncTaxToProduct($arrProduct);

        return $arrProduct;
    }
	
    /**
     * 複数の商品IDに紐づいた, 商品規格を取得する.
     *
     * @param array $productIds 商品IDの配列
     * @param boolean $has_deleted 削除された商品規格も含む場合 true; 初期値 false
     * @return array 商品規格の配列
     */
    function getProductsClassByProductIds($productIds = array(), $has_deleted = false) {
		$admin_flg = true;
        if (($script_path = realpath($_SERVER['SCRIPT_FILENAME'])) !== FALSE) {
            $arrScriptPath = explode('/', str_replace('\\', '/', $script_path));
            $arrAdminPath = explode('/', str_replace('\\', '/', substr(HTML_REALDIR . ADMIN_DIR, 0, -1)));
            $arrDiff = array_diff_assoc($arrAdminPath, $arrScriptPath);
            if (in_array(substr(ADMIN_DIR, 0, -1), $arrDiff)) {
                $admin_flg = false;
            } else {
                $masterData = new SC_DB_MasterData_Ex();
                $arrExcludes = $masterData->getMasterData('mtb_auth_excludes');
                foreach ($arrExcludes as $exclude) {
                    $arrExcludesPath = explode('/', str_replace('\\', '/', HTML_REALDIR . ADMIN_DIR . $exclude));
                    $arrDiff = array_diff_assoc($arrExcludesPath, $arrScriptPath);
                    if (count($arrDiff) === 0) {
                        $admin_flg = false;
                    }
                }
            }
        }
				
        if (empty($productIds)) {
            return array();
        }
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $where = 'product_id IN (' . SC_Utils_Ex::repeatStrWithSeparator('?', count($productIds)) . ')';
        if (!$has_deleted) {
            $where .= ' AND T1.del_flg = 0';
        }
        $objQuery->setWhere($where);
        $arrRet = $this->getProductsClassByQuery($objQuery, $productIds);
		
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$arrRankList = plg_ManageCustomerStatus_Utils::getStatusRankList();
		foreach($arrRet as $key => $item){
			$ret = $objQuery->select("*","plg_managecustomerstatus_dtb_price","product_class_id = ?",array($item['product_class_id']));
			if(count($ret) > 0){			
				foreach($ret as $item2){
					$arrRet[$key]["plg_managecustomerstatus_price".$item2['status_id']] = $item2['price'];
				}
			}
			if($admin_flg == false){
				foreach($arrRankList as $status_id => $name){
					if(!isset($arrRet[$key]["plg_managecustomerstatus_price".$status_id])){
						$discount_rate = $objQuery->get("discount_rate","plg_managecustomerstatus_dtb_customer_status","status_id =?",array($status_id));
						if($discount_rate > 0){
							$arrRet[$key]["plg_managecustomerstatus_price".$status_id] = floor($arrRet[$key]["price02"] * (1.0 - $discount_rate/100));
						}
					}
				}
			}
		}
		
		return $arrRet;
    }
}