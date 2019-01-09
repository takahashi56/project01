<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2014 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

require_once CLASS_REALDIR . 'pages/products/LC_Page_Products_List.php';

/**
 * LC_Page_Products_List のページクラス(拡張).
 *
 * LC_Page_Products_List をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id$
 */
class LC_Page_Products_List_Ex extends LC_Page_Products_List
{
    /**
     * Page を初期化する.
     *
     * @return void
     */
    function init()
    {
        parent::init();
    }

    /**
     * Page のプロセス.
     *
     * @return void
     */
    function process()
    {
        parent::process();
    }

    /**
     * Page のAction.
     *
     * @return void
     */
    public function action()
    {
        //決済処理中ステータスのロールバック
        $objPurchase = new SC_Helper_Purchase_Ex();
        $objPurchase->cancelPendingOrder(PENDING_ORDER_CANCEL_FLAG);

        $objProduct = new SC_Product_Ex();
        // パラメーター管理クラス
        $objFormParam = new SC_FormParam_Ex();

        // パラメーター情報の初期化
        $this->lfInitParam($objFormParam);

        // 値の設定
        $objFormParam->setParam($_REQUEST);

        // 入力値の変換
        $objFormParam->convParam();

        // 値の取得
        $this->arrForm = $objFormParam->getHashArray();

        //modeの取得
        $this->mode = $this->getMode();

        //表示条件の取得
        $this->arrSearchData = array(
            'category_id'   => $this->lfGetCategoryId(intval($this->arrForm['category_id'])),
            'maker_id'      => intval($this->arrForm['maker_id']),
            'name'          => $this->arrForm['name']
        );
        $this->orderby = $this->arrForm['orderby'];

        //ページング設定
        $this->tpl_pageno   = $this->arrForm['pageno'];
        $this->disp_number  = $this->lfGetDisplayNum($this->arrForm['disp_number']);

        // 画面に表示するサブタイトルの設定
        $this->tpl_subtitle = $this->lfGetPageTitle($this->mode, $this->arrSearchData['category_id']);

        // 画面に表示する検索条件を設定
        $this->arrSearch    = $this->lfGetSearchConditionDisp($this->arrSearchData);

        // 商品一覧データの取得
        $arrSearchCondition = $this->lfGetSearchCondition($this->arrSearchData);
        $this->tpl_linemax  = $this->lfGetProductAllNum($arrSearchCondition);
        $urlParam           = "category_id={$this->arrSearchData['category_id']}&pageno=#page#";
        // モバイルの場合に検索条件をURLの引数に追加
        if (SC_Display_Ex::detectDevice() === DEVICE_TYPE_MOBILE) {
            $searchNameUrl = urlencode(mb_convert_encoding($this->arrSearchData['name'], 'SJIS-win', 'UTF-8'));
            $urlParam .= "&mode={$this->mode}&name={$searchNameUrl}&orderby={$this->orderby}";
        }
        $this->objNavi      = new SC_PageNavi_Ex($this->tpl_pageno, $this->tpl_linemax, $this->disp_number, 'eccube.movePage', NAVI_PMAX, $urlParam, SC_Display_Ex::detectDevice() !== DEVICE_TYPE_MOBILE);
        $this->arrProducts  = $this->lfGetProductsList($arrSearchCondition, $this->disp_number, $this->objNavi->start_row, $objProduct);

        //VIP会員価格を追加 20170821 kikuzawa
        //サブ画像をセット 20170823 kikuzawa
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $this->rank_price = array();
        $this->sub_images = array();
        foreach ($this->arrProducts as $key => $p) {
            $pid = $p['product_id'];
            if($pid){
                //VIP会員価格
                $rprice = SC_Helper_TaxRule_Ex::sfCalcIncTax($objQuery->get('price', 'plg_managecustomerstatus_dtb_price', 'status_id = 8 AND product_id = '.$pid), $pid);
                if($rprice) $this->rank_price[$pid] = $rprice;

                //サブ画像
                for ($cnt = 1; $cnt <= PRODUCTSUB_MAX; $cnt++) {
                    $sub_image_temp = $objQuery->get('sub_image'.$cnt, 'dtb_products', 'product_id = '.$pid);
                    if($sub_image_temp) $this->sub_images[$pid][] = $sub_image_temp;
                }
            }
        }

        switch ($this->getMode()) {
            case 'json':
                $this->doJson($objProduct);
                break;

            default:
                $this->doDefault($objProduct, $objFormParam);
                break;
        }
        $this->tpl_rnd = SC_Utils_Ex::sfGetRandomString(3);
    }
}
