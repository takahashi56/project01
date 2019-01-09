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
 

require_once PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/class/plg_ManageCustomerStatus_SC_Product.php";

class plg_ManageCustomerStatus_SC_Product_Ex extends plg_ManageCustomerStatus_SC_Product{
	
    /**
     * 商品規格IDから商品規格を取得する.
     *
     * 削除された商品規格は取得しない.
     *
     * @param integer $productClassId 商品規格ID
     * @return array 商品規格の配列
     */
    function getProductsClass($productClassId) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objQuery->setWhere('product_class_id = ? AND T1.del_flg = 0');
        $arrRes = $this->getProductsClassByQuery($objQuery, $productClassId);
        $arrRet = (array)$arrRes[0];
		
        // 税込計算
        if(!SC_Utils_Ex::isBlank($arrRet['price01'])) {
            $arrRet['price01_inctax'] = SC_Helper_TaxRule_Ex::sfCalcIncTax($arrRet['price01'], $arrRet['product_id'], $productClassId);
        }
        if(!SC_Utils_Ex::isBlank($arrRet['price02'])) {
            $arrRet['price02_inctax'] = SC_Helper_TaxRule_Ex::sfCalcIncTax($arrRet['price02'], $arrRet['product_id'], $productClassId);
        }
		
		$objCustomer = new SC_Customer_Ex();
		if($objCustomer->isLoginSuccess(true)){
			$objQuery =& SC_Query_Ex::getSingletonInstance();
			$status_id = $objCustomer->getValue('plg_managecustomerstatus_status');
			if($status_id > 0){
				$rprice = $objQuery->get("price","plg_managecustomerstatus_dtb_price","product_class_id = ? AND status_id =?",array($productClassId,$status_id));
				if(strlen($rprice) == 0){
					$arrStatus = $objQuery->getRow("discount_rate,discount_value","plg_managecustomerstatus_dtb_customer_status","status_id =?",array($status_id));
					if($arrStatus['discount_rate'] > 0){
						$rprice = floor($arrRet['price02'] * (1.0 - $arrStatus['discount_rate']/100));
					}
				}
				$arrRet["plg_managecustomerstatus_price"] = $rprice;
			}
		}
		return $arrRet;
    }
	
    /**
     * 商品IDに紐づく商品規格を自分自身に設定する.
     *
     * 引数の商品IDの配列に紐づく商品規格を取得し, 自分自身のフィールドに
     * 設定する.
     *
     * @param array $arrProductId 商品ID の配列
     * @param boolean $has_deleted 削除された商品規格も含む場合 true; 初期値 false
     * @return void
     */
    function setProductsClassByProductIds($arrProductId, $has_deleted = false) {
		$objCustomer = new SC_Customer_Ex();
		$status_id = $objCustomer->getValue('plg_managecustomerstatus_status');
		
		if(empty($status_id)){
			$objQuery =& SC_Query_Ex::getSingletonInstance();
			$status_id = $objQuery->get("status_id","plg_managecustomerstatus_dtb_customer_status","initial_rank = ?",array(1));
		}
				
        foreach ($arrProductId as $productId) {
            $arrProductClasses = $this->getProductsClassFullByProductId($productId, $has_deleted);

            $classCats1 = array();
            $classCats1['__unselected'] = '選択してください';

            // 規格1クラス名
            $this->className1[$productId] =
                isset($arrProductClasses[0]['class_name1'])
                ? $arrProductClasses[0]['class_name1']
                : '';

            // 規格2クラス名
            $this->className2[$productId] =
                isset($arrProductClasses[0]['class_name2'])
                ? $arrProductClasses[0]['class_name2']
                : '';

            // 規格1が設定されている
            $this->classCat1_find[$productId] = $arrProductClasses[0]['classcategory_id1'] > 0; // 要変更ただし、他にも改修が必要となる
            // 規格2が設定されている
            $this->classCat2_find[$productId] = $arrProductClasses[0]['classcategory_id2'] > 0; // 要変更ただし、他にも改修が必要となる

            $this->stock_find[$productId] = false;
            $classCategories = array();
            $classCategories['__unselected']['__unselected']['name'] = '選択してください';
            $classCategories['__unselected']['__unselected']['product_class_id'] = $arrProductClasses[0]['product_class_id'];
            // 商品種別
            $classCategories['__unselected']['__unselected']['product_type'] = $arrProductClasses[0]['product_type_id'];
            $this->product_class_id[$productId] = $arrProductClasses[0]['product_class_id'];
            // 商品種別
            $this->product_type[$productId] = $arrProductClasses[0]['product_type_id'];
            foreach ($arrProductClasses as $arrProductsClass) {
                $arrClassCats2 = array();
                $classcategory_id1 = $arrProductsClass['classcategory_id1'];
                $classcategory_id2 = $arrProductsClass['classcategory_id2'];
                // 在庫
                $stock_find_class = ($arrProductsClass['stock_unlimited'] || $arrProductsClass['stock'] > 0);

                $arrClassCats2['classcategory_id2'] = $classcategory_id2;
                $arrClassCats2['name'] = $arrProductsClass['classcategory_name2'] . ($stock_find_class ? '' : ' (品切れ中)');

                $arrClassCats2['stock_find'] = $stock_find_class;

                if ($stock_find_class) {
                    $this->stock_find[$productId] = true;
                }

                if (!array_key_exists($classcategory_id1, $classCats1)) {
                    $classCats1[$classcategory_id1] = $arrProductsClass['classcategory_name1']
                        . ($classcategory_id2 == 0 && !$stock_find_class ? ' (品切れ中)' : '');
                }

                // 価格
				$arrClassCats2['price01']
					= strlen($arrProductsClass['price01'])
					? number_format(SC_Helper_TaxRule_Ex::sfCalcIncTax($arrProductsClass['price01'],$productId, $arrProductsClass['product_class_id']))
					: '';

				$arrClassCats2['price02']
					= strlen($arrProductsClass['price02'])
					? number_format(SC_Helper_TaxRule_Ex::sfCalcIncTax($arrProductsClass['price02'],$productId, $arrProductsClass['product_class_id']))
					: '';
				
				if($status_id > 0){
					$arrClassCats2['plg_managecustomerstatus_price']
						= strlen($arrProductsClass['plg_managecustomerstatus_price'.$status_id])
						? number_format(SC_Helper_TaxRule_Ex::sfCalcIncTax($arrProductsClass['plg_managecustomerstatus_price'.$status_id],$productId, $arrProductsClass['product_class_id']))
						: number_format(SC_Helper_TaxRule_Ex::sfCalcIncTax($arrProductsClass['price02'],$productId, $arrProductsClass['product_class_id']));
				}


                // ポイント
				if($objCustomer->isLoginSuccess(true) && $arrProductsClass['plg_managecustomerstatus_price'.$status_id] != "" && !empty($arrProductsClass['plg_managecustomerstatus_price'.$status_id])){
					$arrClassCats2['point']
                    = number_format(SC_Utils_Ex::sfPrePoint($arrProductsClass['plg_managecustomerstatus_price'.$status_id], $arrProductsClass['point_rate']));
				}else{
					$arrClassCats2['point']
                    = number_format(SC_Utils_Ex::sfPrePoint($arrProductsClass['price02'], $arrProductsClass['point_rate']));
				}

                // 商品コード
                $arrClassCats2['product_code'] = $arrProductsClass['product_code'];
                // 商品規格ID
                $arrClassCats2['product_class_id'] = $arrProductsClass['product_class_id'];
                // 商品種別
                $arrClassCats2['product_type'] = $arrProductsClass['product_type_id'];

                // #929(GC8 規格のプルダウン順序表示不具合)対応のため、2次キーは「#」を前置
                if (!$this->classCat1_find[$productId]) {
                    $classcategory_id1 = '__unselected2';
                }
                $classCategories[$classcategory_id1]['#'] = array(
                    'classcategory_id2' => '',
                    'name' => '選択してください',
                );
                $classCategories[$classcategory_id1]['#' . $classcategory_id2] = $arrClassCats2;
            }

            $this->classCategories[$productId] = $classCategories;

            // 規格1
            $this->classCats1[$productId] = $classCats1;
        }
    }	
	
	
    /**
     * 商品情報の配列に, 税込金額を設定して返す.
     *
     * この関数は, 主にスマートフォンで使用します.
     *
     * @param array $arrProducts 商品情報の配列
     * @return array 税込金額を設定した商品情報の配列
     */
    public static function setPriceTaxTo(&$arrProducts) {
        foreach ($arrProducts as &$arrProduct) {
            $arrProduct['price01_min_format'] = number_format($arrProduct['price01_min']);
            $arrProduct['price01_max_format'] = number_format($arrProduct['price01_max']);
            $arrProduct['price02_min_format'] = number_format($arrProduct['price02_min']);
            $arrProduct['price02_max_format'] = number_format($arrProduct['price02_max']);
            $arrProduct['plg_managecustomerstatus_price_min_format'] = number_format($arrProduct['plg_managecustomerstatus_price_min']);
            $arrProduct['plg_managecustomerstatus_price_max_format'] = number_format($arrProduct['plg_managecustomerstatus_price_max']);			

            SC_Product_Ex::setIncTaxToProduct($arrProduct);

            $arrProduct['price01_min_inctax_format'] = number_format($arrProduct['price01_min_inctax']);
            $arrProduct['price01_max_inctax_format'] = number_format($arrProduct['price01_max_inctax']);
            $arrProduct['price02_min_inctax_format'] = number_format($arrProduct['price02_min_inctax']);
            $arrProduct['price02_max_inctax_format'] = number_format($arrProduct['price02_max_inctax']);
            $arrProduct['plg_managecustomerstatus_price_min_inctax_format'] = number_format($arrProduct['plg_managecustomerstatus_price_min_inctax']);
            $arrProduct['plg_managecustomerstatus_price_max_inctax_format'] = number_format($arrProduct['plg_managecustomerstatus_price_max_inctax']);

            // @deprecated 2.12.4
            // 旧バージョン互換用
            // 本来は、税額の代入で使用すべきキー名。
            $arrProduct['price01_min_tax_format'] =& $arrProduct['price01_min_inctax_format'];
            $arrProduct['price01_max_tax_format'] =& $arrProduct['price01_max_inctax_format'];
            $arrProduct['price02_min_tax_format'] =& $arrProduct['price02_min_inctax_format'];
            $arrProduct['price02_max_tax_format'] =& $arrProduct['price02_max_inctax_format'];
            $arrProduct['plg_managecustomerstatus_price_min_tax_format'] = & $arrProduct['plg_managecustomerstatus_price_min_inctax_format'];
            $arrProduct['plg_managecustomerstatus_price_max_tax_format'] = & $arrProduct['plg_managecustomerstatus_price_max_inctax_format'];
        }
        return $arrProducts;
    }	
	
    /**
     * 商品情報の配列に税込金額を設定する
     *
     * @param array $arrProducts 商品情報の配列
     * @return void
     */
    public static function setIncTaxToProduct(&$arrProduct) {
		$arrProduct['price01_min_inctax'] = isset($arrProduct['price01_min']) ? SC_Helper_TaxRule_Ex::sfCalcIncTax($arrProduct['price01_min'], $arrProduct['product_id']) : null;
		$arrProduct['price01_max_inctax'] = isset($arrProduct['price01_max']) ? SC_Helper_TaxRule_Ex::sfCalcIncTax($arrProduct['price01_max'], $arrProduct['product_id']) : null;
		$arrProduct['price02_min_inctax'] = isset($arrProduct['price02_min']) ? SC_Helper_TaxRule_Ex::sfCalcIncTax($arrProduct['price02_min'], $arrProduct['product_id']) : null;
		$arrProduct['price02_max_inctax'] = isset($arrProduct['price02_max']) ? SC_Helper_TaxRule_Ex::sfCalcIncTax($arrProduct['price02_max'], $arrProduct['product_id']) : null;
		$arrProduct['plg_managecustomerstatus_price_min_inctax'] = isset($arrProduct['plg_managecustomerstatus_price_min']) ? SC_Helper_TaxRule_Ex::sfCalcIncTax($arrProduct['plg_managecustomerstatus_price_min'], $arrProduct['product_id']) : null;
		$arrProduct['plg_managecustomerstatus_price_max_inctax'] = isset($arrProduct['plg_managecustomerstatus_price_max']) ? SC_Helper_TaxRule_Ex::sfCalcIncTax($arrProduct['plg_managecustomerstatus_price_max'], $arrProduct['product_id']) : null;

    }
	
    /**
     * 商品詳細を取得する.
     *
     * @param integer $productId 商品ID
     * @return array 商品詳細情報の配列
     */
    public function getDetail($productId) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
		if(plg_ManageCustomerStatus_Utils::getECCUBEVer() >= 2133){
			$from = $this->alldtlSQL();
			$where = 'product_id = ?';
			$arrWhereVal = array($productId);
			$arrProduct = (array)$objQuery->getRow('*', $from, $where, $arrWhereVal);			
		}else{
			$arrProduct = $objQuery->getRow('*', $this->alldtlSQL('product_id = ?'),
										'product_id = ?',
										array($productId, $productId));
			$arrProduct = (array)$arrProduct;
		}
		
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
}