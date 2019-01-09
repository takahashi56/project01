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

class plg_ManageCustomerStatus_LC_Page_Admin_Products_ProductClass extends plg_ManageCustomerStatus_LC_Page{
    /**
     * @param LC_Page_Admin_Products_ProductClass $objPage 商品管理のページクラス
     * @return void
     */
    function after($objPage) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objQuery->setOrder('priority ASC');
        $objPage->arrRankPrices = $objQuery->select('*', 'plg_managecustomerstatus_dtb_customer_status');
			
		$objFormParam = new SC_FormParam_Ex();
        $objPage->initParam($objFormParam);
		plg_ManageCustomerStatus_Utils::addManageCustomerStatusPriceParam($objFormParam);

        $objFormParam->setParam($_POST);
        $objFormParam->convParam();		
        switch($objPage->getMode($objPage)) {
            case "edit":
                $objPage->arrErr = $objPage->lfCheckProductsClass($objFormParam);

                // エラーの無い場合は確認画面を表示
                if (SC_Utils_Ex::isBlank($objPage->arrErr)) {
                    self::doDispManageCustomerPrice($objFormParam,$objPage);
                    $objFormParam->setParam($_POST);
                    $objFormParam->convParam();
                }
                // エラーが発生した場合
                else {
                    $objFormParam->setParam($_POST);
                    $objFormParam->convParam();
                }
                break;			
            case "delete" :
				self::doDispManageCustomerPrice($objFormParam,$objPage);
				$objQuery2 =& SC_Query_Ex::getSingletonInstance();
				$default_product_class_id = $objQuery2->get('product_class_id','dtb_products_class','product_id = ? AND classcategory_id1 = 0 AND classcategory_id2 = 0', array($objFormParam->getValue('product_id')));
				$objQuery2->delete('plg_managecustomerstatus_dtb_price','product_id = ? AND product_class_id <> ?',array($objFormParam->getValue('product_id'),$default_product_class_id));
                $objFormParam->setValue('class_id1', '');
                $objFormParam->setValue('class_id2', '');
                $objPage->doDisp($objFormParam);
				break;
            case "pre_edit":
				self::doPreEditManageCustomerPrice($objFormParam,$objPage);
				break;
            case "disp":
				self::doDispManageCustomerPrice($objFormParam,$objPage);
				$objPage->initDispParam($objFormParam);
				break;
            case "file_upload":
            case "file_delete":
				return;
				break;
            case "confirm_return":
                self::doPreEditManageCustomerPrice($objFormParam,$objPage);
                $objFormParam->setParam($_POST);
                $objFormParam->convParam();
                break;

            case "complete":
                self::registerProductClassManageCustomerPrice($objFormParam->getHashArray(),
                                            $objFormParam->getValue('product_id'),
                                            $objFormParam->getValue('total'));
                break;
            default:
                break;
        }
		$objFormParam->setValue('product_name',
                $objPage->getProductName($objFormParam->getValue('product_id')));		
		$objPage->arrForm = $objFormParam->getFormParamList();
    }
	
    /**
     * 規格編集画面を表示する
     *
     * @param integer $product_id 商品ID
     * @param bool $existsValue
     * @param bool $usepostValue
     */
    function doPreEditManageCustomerPrice(&$objFormParam,$objPage) {
        $product_id = $objFormParam->getValue('product_id');
        $objProduct = new SC_Product_Ex();
        $existsProductsClass = $objProduct->getProductsClassFullByProductId($product_id);

        // 規格のデフォルト値(すべての組み合わせ)を取得し, フォームに反映
        $class_id1 = $existsProductsClass[0]['class_id1'];
        $class_id2 = $existsProductsClass[0]['class_id2'];
        $objFormParam->setValue('class_id1', $class_id1);
        $objFormParam->setValue('class_id2', $class_id2);
        self::doDispManageCustomerPrice($objFormParam,$objPage);

        /*
         * 登録済みのデータで, フォームの値を上書きする.
         *
         * 登録済みデータと, フォームの値は, 配列の形式が違うため,
         * 同じ形式の配列を生成し, マージしてフォームの値を上書きする
         */
        $arrKeys = array('classcategory_id1', 'classcategory_id2','product_code',
            'classcategory_name1', 'classcategory_name2', 'stock',
            'stock_unlimited', 'price01', 'price02',
            'product_type_id', 'down_filename', 'down_realfilename', 'upload_index',
        );
		if(plg_ManageCustomerStatus_Utils::getECCUBEVer() >= 2130){
			$arrKeys[] = "tax_rate";
		}
		
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $arrRankPrices = $objQuery->select('*', 'plg_managecustomerstatus_dtb_customer_status');
		foreach($arrRankPrices as $item){
			$arrKeys[] = "plg_managecustomerstatus_price".$item["status_id"];
		}
		
        $arrFormValues = $objFormParam->getSwapArray($arrKeys);

        // フォームの規格1, 規格2をキーにした配列を生成
        $arrClassCatKey = array();
        foreach ($arrFormValues as $formValue) {
            $arrClassCatKey[$formValue['classcategory_id1']][$formValue['classcategory_id2']] = $formValue;
        }
        // 登録済みデータをマージ
        foreach ($existsProductsClass as $existsValue) {
            $arrClassCatKey[$existsValue['classcategory_id1']][$existsValue['classcategory_id2']] = $existsValue;
        }

        // 規格のデフォルト値に del_flg をつけてマージ後の1次元配列を生成
        $arrMergeProductsClass = array();
        foreach ($arrClassCatKey as $arrC1) {
            foreach ($arrC1 as $arrValues) {
                $arrValues['del_flg'] = (string) $arrValues['del_flg'];
                if (SC_Utils_Ex::isBlank($arrValues['del_flg'])
                    || $arrValues['del_flg'] === '1') {
                    $arrValues['del_flg'] = '1';
                } else {
                    $arrValues['del_flg'] = '0';
                }
				
                // 消費税率を設定
				if(plg_ManageCustomerStatus_Utils::getECCUBEVer() >= 2130){
					if (OPTION_PRODUCT_TAX_RULE) {
						$arrRet = SC_Helper_TaxRule_Ex::getTaxRule($arrValues['product_id'], $arrValues['product_class_id']);
						$arrValues['tax_rate'] = $arrRet['tax_rate'];
					}
				}
                $arrMergeProductsClass[] = $arrValues;
            }
        }

        // 登録済みのデータで上書き
        $objFormParam->setParam(SC_Utils_Ex::sfSwapArray($arrMergeProductsClass));

        // $arrMergeProductsClass で product_id が配列になってしまうため数値で上書き
        $objFormParam->setValue('product_id', $product_id);

        // check を設定
        $arrChecks = array();
        $index = 0;
        foreach ($objFormParam->getValue('del_flg') as $key => $val) {
            if ($val === '0') {
                $arrChecks[$index] = 1;
            }
            $index++;
        }
        $objFormParam->setValue('check', $arrChecks);

        // class_id1, class_id2 を取得値で上書き
        $objFormParam->setValue('class_id1', $class_id1);
        $objFormParam->setValue('class_id2', $class_id2);
    }
	
	
    /**
     * 規格の組み合わせ一覧を表示する.
     *
     * 規格1, 規格2における規格分類のすべての組み合わせを取得し,
     * 該当商品の商品規格の内容を取得後, フォームに設定する.
     *
     * @param SC_FormParam $objFormParam SC_FormParam インスタンス
     * @return void
     */
    function doDispManageCustomerPrice(&$objFormParam,$objPage) {
        $product_id = $objFormParam->getValue('product_id');
        $class_id1 = $objFormParam->getValue('class_id1');
        $class_id2 = $objFormParam->getValue('class_id2');

        // すべての組み合わせを取得し, フォームに設定
        $arrClassCat = $objPage->getAllClassCategory($class_id1, $class_id2);
        $total = count($arrClassCat);
        $objFormParam->setValue('total', $total);
        $objFormParam->setParam(SC_Utils_Ex::sfSwapArray($arrClassCat));

        // class_id1, class_id2 を, 入力値で上書き
        $objFormParam->setValue('class_id1', $class_id1);
        $objFormParam->setValue('class_id2', $class_id2);

        // 商品情報を取得し, フォームに設定
        $arrProductsClass = self::getProductsClassManageCustomerPrice($product_id);

        foreach ($arrProductsClass as $key => $val) {
            // 組み合わせ数分の値の配列を生成する
            $arrValues = array();
            for ($i = 0; $i < $total; $i++) {
                $arrValues[] = $val;
            }
            $objFormParam->setValue($key, $arrValues);
        }
        // 商品種別を 1 に初期化
        $objFormParam->setValue('product_type_id', array_pad(array(), $total, 1));
    }
	
    /**
     * 規格の登録または更新を行う.
     *
     * @param array $arrList 入力フォームの内容
     * @param integer $product_id 登録を行う商品ID
     */
    function registerProductClassManageCustomerPrice($arrList, $product_id, $total) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
		$arrRankPrices = $objQuery->select('*', 'plg_managecustomerstatus_dtb_customer_status');
		
        $objDb = new SC_Helper_DB_Ex();

        $objQuery->begin();

        $arrProductsClass = $objQuery->select('*', 'dtb_products_class', 'product_id = ?', array($product_id));
        $arrExists = array();
        foreach ($arrProductsClass as $val) {
            $arrExists[$val['product_class_id']] = $val;
        }

        // デフォルト値として設定する値を取得しておく
        $arrDefault = self::getProductsClassManageCustomerPrice($product_id);

        $objQuery->delete('dtb_products_class', 'product_id = ? AND (classcategory_id1 <> 0 OR classcategory_id2 <> 0)', array($product_id));

		$default_product_class_id = $objQuery->get('product_class_id','dtb_products_class','product_id = ? AND classcategory_id1 = 0 AND classcategory_id2 = 0', array($product_id));
		$objQuery->delete('plg_managecustomerstatus_dtb_price','product_id = ? AND product_class_id <> ?',array($product_id,$default_product_class_id));

        for ($i = 0; $i < $total; $i++) {
            $del_flg = SC_Utils_Ex::isBlank($arrList['check'][$i]) ? 1 : 0;
            $stock_unlimited = SC_Utils_Ex::isBlank($arrList['stock_unlimited'][$i]) ? 0 : $arrList['stock_unlimited'][$i];
            $price02 = SC_Utils_Ex::isBlank($arrList['price02'][$i]) ? 0 : $arrList['price02'][$i];

            // dtb_products_class 登録/更新用
            $registerKeys = array(
                'classcategory_id1', 'classcategory_id2',
                'product_code', 'stock', 'price01', 'product_type_id',
                'down_filename', 'down_realfilename',
            );

            $arrPC = array();
            foreach ($registerKeys as $key) {
                $arrPC[$key] = $arrList[$key][$i];
            }
            $arrPC['product_id'] = $product_id;
            $arrPC['sale_limit'] = $arrDefault['sale_limit'];
            $arrPC['deliv_fee'] = $arrDefault['deliv_fee'];
            $arrPC['point_rate'] = $arrDefault['point_rate'];
            $arrPC['stock_unlimited'] = $stock_unlimited;
            $arrPC['price02'] = $price02;

            // 該当関数が無いため, セッションの値を直接代入
            $arrPC['creator_id'] = $_SESSION['member_id'];
            $arrPC['update_date'] = 'CURRENT_TIMESTAMP';
            $arrPC['del_flg'] = $del_flg;

            $arrPC['create_date'] = 'CURRENT_TIMESTAMP';
            // 更新の場合は, product_class_id を使い回す
            if (!SC_Utils_Ex::isBlank($arrList['product_class_id'][$i])) {
                $arrPC['product_class_id'] = $arrList['product_class_id'][$i];
            } else {
                $arrPC['product_class_id'] = $objQuery->nextVal('dtb_products_class_product_class_id');
            }

            /*
             * チェックを入れない商品は product_type_id が NULL になるので, 0 を入れる
             */
            $arrPC['product_type_id'] = SC_Utils_Ex::isBlank($arrPC['product_type_id']) ? 0 : $arrPC['product_type_id'];

            $objQuery->insert('dtb_products_class', $arrPC);

			if($del_flg == 0){
				foreach($arrRankPrices as $item){
					$rprice = $arrList["plg_managecustomerstatus_price".$item["status_id"]][$i];
					if(strlen($rprice) > 0){
						$sqlval = array();
						$sqlval['product_id'] = $product_id;
						$sqlval['product_class_id'] = $arrPC['product_class_id'];
						$sqlval['status_id'] = $item['status_id'];
						$sqlval['price'] = $rprice;
						$objQuery->insert("plg_managecustomerstatus_dtb_price", $sqlval);
					}
				}
			}
			
            // 税情報登録/更新
			if(plg_ManageCustomerStatus_Utils::getECCUBEVer() >= 2130){
				if (OPTION_PRODUCT_TAX_RULE) {
					SC_Helper_TaxRule_Ex::setTaxRuleForProduct($arrList['tax_rate'][$i], $arrPC['product_id'], $arrPC['product_class_id']);
				}
			}
        }

        // 規格無し用の商品規格を非表示に
        $arrBlank['del_flg'] = 1;
        $arrBlank['update_date'] = 'CURRENT_TIMESTAMP';
        $objQuery->update('dtb_products_class', $arrBlank,
                          'product_id = ? AND classcategory_id1 = 0 AND classcategory_id2 = 0',
                          array($product_id));

        $objDb->sfCountCategory($objQuery);
        $objQuery->commit();
    }
	
    /**
     * 商品IDをキーにして, 商品規格の初期値を取得する.
     *
     * 商品IDをキーにし, デフォルトに設定されている商品規格を取得する.
     *
     * @param integer $product_id 商品ID
     * @return array 商品規格の配列
     */
    function getProductsClassManageCustomerPrice($product_id) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $col = 'product_class_id, product_code, price01, price02, stock, stock_unlimited, sale_limit, deliv_fee, point_rate';
        $where = 'product_id = ? AND classcategory_id1 = 0 AND classcategory_id2 = 0';
        $arrRet = $objQuery->getRow($col, 'dtb_products_class', $where, array($product_id));
		if(strlen($arrRet['product_class_id']) > 0){
			$ret = $objQuery->select("*","plg_managecustomerstatus_dtb_price","product_class_id = ?",array($arrRet['product_class_id']));
			if(count($ret) > 0){
				foreach($ret as $item){
					$arrRet["plg_managecustomerstatus_price".$item['status_id']] = $item['price'];
				}
			}
			unset($arrRet['product_class_id']);
		}
		return $arrRet;
    }
}