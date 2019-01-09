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

require_once CLASS_EX_REALDIR . 'page_extends/mypage/LC_Page_AbstractMypage_Ex.php';

/**
 * ビデオ一覧 のページクラス.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id$
 */
class LC_Page_Mypage_Videos extends LC_Page_AbstractMypage_Ex {

    /**
     * Page を初期化する.
     *
     * @return void
     */
    public function init() {
        parent::init();

        $this->tpl_mainpage = 'mypage/videos.tpl';
        $this->tpl_mypageno = 'videos';
        $this->tpl_subtitle = 'ビデオ一覧';
        $this->httpCacheControl('nocache');

        $masterData = new SC_DB_MasterData_Ex();
        $this->arrMAILTEMPLATE = $masterData->getMasterData('mtb_mail_template');
        $this->arrPref = $masterData->getMasterData('mtb_pref');
        $this->arrCountry = $masterData->getMasterData('mtb_country');
        $this->arrWDAY = $masterData->getMasterData('mtb_wday');
        $this->arrProductType = $masterData->getMasterData('mtb_product_type');
        $this->arrCustomerOrderStatus = $masterData->getMasterData('mtb_customer_order_status');
    }

    /**
     * Page のプロセス.
     *
     * @return void
     */
    public function process() {
        parent::process();
    }

    /**
     * Page のAction.
     *
     * @return void
     */
    public function action() {
        //決済処理中ステータスのロールバック
        $objPurchase = new SC_Helper_Purchase_Ex();
        $objPurchase->cancelPendingOrder(PENDING_ORDER_CANCEL_FLAG);

        $objCustomer = new SC_Customer_Ex();
        $customer_id = $objCustomer->getValue('customer_id');

        //受注データの取得
        $this->tpl_arrOrderDetail = $objPurchase->getDownloadList($customer_id);
        //ページ送り用
        $objCustomer = new SC_Customer_Ex();
        $customer_id = $objCustomer->getValue('customer_id');

        //ページ送り用
        $this->objNavi = new SC_PageNavi_Ex($_REQUEST['pageno'], $objPurchase->getDownloadList($customer_id), SEARCH_PMAX, 'eccube.movePage', NAVI_PMAX, 'pageno=#page#', SC_Display_Ex::detectDevice() !== DEVICE_TYPE_MOBILE);

        $this->tpl_arrOrderDetail = $objPurchase->getDownloadList($customer_id, $this->objNavi->start_row);
        $objPurchase->setDownloadableFlgTo($this->tpl_arrOrderDetail);
        $i = 0;
        foreach ($this->tpl_arrOrderDetail as $arrOrderDetail) {
            $this->tpl_arrOrderDetail[$i]['down_videourl'] = $objPurchase->strGetVideoUrl($arrOrderDetail['down_filename']);
            $i++;
        }

        // 1ページあたりの件数
        $this->dispNumber = SEARCH_PMAX;

        // モバイルダウンロード対応処理
        //$this->lfSetAU($this->tpl_arrOrderDetail);
    }

    /**
     * 購入履歴商品にMIMETYPE、ファイル名をセット
     *
     * @param $arrOrderDetail 購入履歴の配列
     * @return array MIMETYPE、ファイル名をセットした購入履歴の配列
     */
    public function lfSetMimetype($arrOrderDetails) {
        $objHelperMobile = new SC_Helper_Mobile_Ex();

        return $arrOrderDetails;
    }

    /**
     * 特定キャリア（AU）モバイルダウンロード処理
     * キャリアがAUのモバイル端末からダウンロードする場合は単純に
     * Aタグでダウンロードできないケースがある為、対応する。
     *
     * @param $arrOrderDetail 購入履歴の配列
     */
    public function lfSetAU($arrOrderDetails) {
        $this->isAU = false;
        // モバイル端末かつ、キャリアがAUの場合に処理を行う
        if (SC_Display_Ex::detectDevice() == DEVICE_TYPE_MOBILE && SC_MobileUserAgent::getCarrier() == 'ezweb') {
            // MIMETYPE、ファイル名のセット
            $this->tpl_arrOrderDetail = $this->lfSetMimetype($arrOrderDetails);

            // @deprecated 2.12.0 PHP 定数 SID を使うこと
            $this->phpsessid = $_GET['PHPSESSID'];

            $this->isAU = true;
        }
    }

}
