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

class plg_ManageCustomerStatus_LC_Page_Shopping_Confirm extends plg_ManageCustomerStatus_LC_Page{
    /**
     * @param LC_Page_Shopping_Confirm $objPage 購入手続きのページクラス
     * @return void
     */
    function before($objPage) {
        $objCartSess = new SC_CartSession_Ex();
        $objSiteSess = new SC_SiteSession_Ex();
        $objCustomer = new SC_Customer_Ex();
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objPurchase = new SC_Helper_Purchase_Ex();
        $objHelperMail = new SC_Helper_Mail_Ex();
        $objHelperMail->setPage($objPage);

        $objPage->is_multiple = $objPurchase->isMultiple();

        // 前のページで正しく登録手続きが行われた記録があるか判定
        if (!$objSiteSess->isPrePage()) {
			if(plg_ManageCustomerStatus_Utils::getECCUBEVer() >= 2135){
	            // エラー時は、正当なページ遷移とは認めない
    	        $objSiteSess->setNowPage('');
			}
            SC_Utils_Ex::sfDispSiteError(PAGE_ERROR, $objSiteSess);
        }

        // ユーザユニークIDの取得と購入状態の正当性をチェック
        $objPage->tpl_uniqid = $objSiteSess->getUniqId();
        $objPurchase->verifyChangeCart($objPage->tpl_uniqid, $objCartSess);

        $objPage->cartKey = $objCartSess->getKey();

        // カート内商品のチェック
        $objPage->tpl_message = $objCartSess->checkProducts($objPage->cartKey);
        if (!SC_Utils_Ex::isBlank($objPage->tpl_message)) {

            self::sendRedirect(CART_URLPATH);
			exit;
        }

        // 一時受注テーブルの読込
        $arrOrderTemp = $objPurchase->getOrderTemp($objPage->tpl_uniqid);

        // カート集計を元に最終計算
        $arrCalcResults = $objCartSess->calculate($objPage->cartKey, $objCustomer,
                                                  $arrOrderTemp['use_point'],
                                                  $objPurchase->getShippingPref($objPage->is_multiple),
                                                  $arrOrderTemp['charge'],
                                                  0,
                                                  $arrOrderTemp['deliv_id']);
        $objPage->arrForm = array_merge($arrOrderTemp, $arrCalcResults);

        // 決済モジュールを使用するかどうか
		if(plg_ManageCustomerStatus_Utils::getECCUBEVer() >= 2123){
			$objPage->use_module = SC_Helper_Payment_Ex::useModule($objPage->arrForm['payment_id']);
		}else{
        	$objPage->use_module = $objPage->useModule($objPage->arrForm['payment_id']);
		}

		self::doPrivilege($objPage->arrForm);

        switch ($objPage->getMode()) {
            case 'confirm':
                /*
                 * 決済モジュールで必要なため, 受注番号を取得
                 */
                $objPage->arrForm['order_id'] = $objQuery->nextval('dtb_order_order_id');
                $_SESSION['order_id'] = $objPage->arrForm['order_id'];

                // 集計結果を受注一時テーブルに反映
                $objPurchase->saveOrderTemp($objPage->tpl_uniqid, $objPage->arrForm,
                                            $objCustomer);

                // 正常に登録されたことを記録しておく
                $objSiteSess->setRegistFlag();

                // 決済モジュールを使用する場合
                if ($objPage->use_module) {
                    $objPurchase->completeOrder(ORDER_PENDING);


                    self::sendRedirect(SHOPPING_MODULE_URLPATH);
                }
                // 購入完了ページ
                else {
                    if ($objPage->arrForm['payment_id'] == 5) {
                      $objPurchase->completeOrder(ORDER_PRE_END);
                      $template_id = SC_Display_Ex::detectDevice() == DEVICE_TYPE_MOBILE ? 2 : 1;
                      $objHelperMail->sfSendOrderMail(
                              $objPage->arrForm['order_id'],
                              $template_id);

                      self::sendRedirect(SHOPPING_COMPLETE_URLPATH);
                    } else {
                      $objPurchase->completeOrder(ORDER_NEW);
                      $template_id = SC_Display_Ex::detectDevice() == DEVICE_TYPE_MOBILE ? 2 : 1;
                      $objHelperMail->sfSendOrderMail(
                              $objPage->arrForm['order_id'],
                              $template_id);

                      self::sendRedirect(SHOPPING_COMPLETE_URLPATH);
                    }
                }
				exit;
                break;
            default:
                break;
        }
    }

    /**
     * @param LC_Page_Shopping_Confirm $objPage 購入手続きのページクラス
     * @return void
     */
    function after($objPage) {
		self::doPrivilege($objPage->arrForm);
    }

	function doPrivilege(&$arrForm){
        $objCustomer = new SC_Customer_Ex();
        $objQuery =& SC_Query_Ex::getSingletonInstance();

		$customer_id = $objCustomer->getValue('customer_id');

		$from = "plg_managecustomerstatus_dtb_customer_status status LEFT JOIN dtb_customer customer ON status.status_id = customer.plg_managecustomerstatus_status";
		$ret = $objQuery->select("status.*",$from,"customer.customer_id = ?",array($customer_id));
		$arrRet = $ret[0];

		if($arrRet['discount_value'] > 0){
			if($arrRet['discount_value'] > $arrForm['subtotal']){
				$discount = $arrForm['subtotal'];
			}else{
				$discount = intval($arrRet['discount_value']);
			}
		}

		if(strlen($arrRet['point_rate']) > 0){
			$inc_point = floor($arrForm['add_point'] * (intval($arrRet['point_rate']) / 100));
		}elseif($arrRet['point_value'] > 0){
			$inc_point = intval($arrRet['point_value']);
		}

		if($arrRet['free_fee'] == 1){
			$discount_deliv_fee = $arrForm['deliv_fee'];
		}elseif($arrRet['discount_fee'] > 0){
			if($arrRet['discount_fee'] > $arrForm['deliv_fee']){
				$discount_deliv_fee = $arrForm['deliv_fee'];
			}else{
				$discount_deliv_fee = intval($arrRet['discount_fee']);
			}
		}

		if(isset($discount)){
			$arrForm['payment_total'] -= $discount;
			$arrForm['total'] -= $discount;
			$arrForm['discount'] = $discount;
		}

		if(isset($inc_point)){
			$arrForm['add_point'] += $inc_point;
			if($arrForm['add_point'] < 0)$arrForm['add_point'] = 0;
		}

		if(isset($discount_deliv_fee)){
			$arrForm['payment_total'] -= $discount_deliv_fee;
			$arrForm['total'] -= $discount_deliv_fee;
			$arrForm['deliv_fee'] -= $discount_deliv_fee;
		}
	}
}
