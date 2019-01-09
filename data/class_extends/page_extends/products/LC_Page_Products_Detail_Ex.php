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

require_once CLASS_REALDIR . 'pages/products/LC_Page_Products_Detail.php';

/**
 * LC_Page_Products_Detail のページクラス(拡張).
 *
 * LC_Page_Products_Detail をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id$
 */
class LC_Page_Products_Detail_Ex extends LC_Page_Products_Detail
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

        // 会員クラス
        $objCustomer = new SC_Customer_Ex();

        // パラメーター管理クラス
        $this->objFormParam = new SC_FormParam_Ex();
        // パラメーター情報の初期化
        $this->arrForm = $this->lfInitParam($this->objFormParam);
        // ファイル管理クラス
        $this->objUpFile = new SC_UploadFile_Ex(IMAGE_TEMP_REALDIR, IMAGE_SAVE_REALDIR);
        // ファイル情報の初期化
        $this->objUpFile = $this->lfInitFile($this->objUpFile);
        $this->mode = $this->getMode();

        $objProduct = new SC_Product_Ex();

        // プロダクトIDの正当性チェック
        $product_id = $this->lfCheckProductId($this->objFormParam->getValue('admin'), $this->objFormParam->getValue('product_id'), $objProduct);

        $objProduct->setProductsClassByProductIds(array($product_id));

        // 規格1クラス名
        $this->tpl_class_name1 = $objProduct->className1[$product_id];

        // 規格2クラス名
        $this->tpl_class_name2 = $objProduct->className2[$product_id];

        // 規格1
        $this->arrClassCat1 = $objProduct->classCats1[$product_id];

        // 規格1が設定されている
        $this->tpl_classcat_find1 = $objProduct->classCat1_find[$product_id];
        // 規格2が設定されている
        $this->tpl_classcat_find2 = $objProduct->classCat2_find[$product_id];

        $this->tpl_stock_find = $objProduct->stock_find[$product_id];
        $this->tpl_product_class_id = $objProduct->classCategories[$product_id]['__unselected']['__unselected']['product_class_id'];
        $this->tpl_product_type = $objProduct->classCategories[$product_id]['__unselected']['__unselected']['product_type'];

        // 在庫が無い場合は、OnLoadしない。(javascriptエラー防止)
        if ($this->tpl_stock_find) {
            // 規格選択セレクトボックスの作成
            $this->js_lnOnload .= $this->lfMakeSelect();
        }

        $this->tpl_javascript .= 'eccube.classCategories = ' . SC_Utils_Ex::jsonEncode($objProduct->classCategories[$product_id]) . ';';
        $this->tpl_javascript .= 'function lnOnLoad()
        {' . $this->js_lnOnload . '}';
        $this->tpl_onload .= 'lnOnLoad();';

        // モバイル用 規格選択セレクトボックスの作成
        if (SC_Display_Ex::detectDevice() == DEVICE_TYPE_MOBILE) {
            $this->lfMakeSelectMobile($this, $product_id, $this->objFormParam->getValue('classcategory_id1'));
        }

        // 商品IDをFORM内に保持する
        $this->tpl_product_id = $product_id;

        switch ($this->mode) {
            case 'cart':
                $this->doCart();
                break;

            case 'add_favorite':
                $this->doAddFavorite($objCustomer);
                break;

            case 'add_favorite_sphone':
                $this->doAddFavoriteSphone($objCustomer);
                break;

            case 'select':
            case 'select2':
            case 'selectItem':
                /**
                 * モバイルの数量指定・規格選択の際に、
                 * $_SESSION['cart_referer_url'] を上書きさせないために、
                 * 何もせずbreakする。
                 */
                break;

            default:
                $this->doDefault();
                break;
        }

        // モバイル用 ポストバック処理
        if (SC_Display_Ex::detectDevice() == DEVICE_TYPE_MOBILE) {
            switch ($this->mode) {
                case 'select':
                    $this->doMobileSelect();
                    break;

                case 'select2':
                    $this->doMobileSelect2();
                    break;

                case 'selectItem':
                    $this->doMobileSelectItem();
                    break;

                case 'cart':
                    $this->doMobileCart();
                    break;

                default:
                    $this->doMobileDefault();
                    break;
            }
        }

        // 商品詳細を取得
        $this->arrProduct = $objProduct->getDetail($product_id);

        // サブタイトルを取得
        $this->tpl_subtitle = $this->arrProduct['name'];

        // 関連カテゴリを取得
        $this->arrRelativeCat = SC_Helper_DB_Ex::sfGetMultiCatTree($product_id);

        // 商品ステータスを取得
        $this->productStatus = $objProduct->getProductStatus($product_id);

        // 商品ステータスを取得
        $this->productStatusIcon = $objProduct->getProductStatusIcon($product_id);

        // 画像ファイル指定がない場合の置換処理
        $this->arrProduct['main_image']
            = SC_Utils_Ex::sfNoImageMain($this->arrProduct['main_image']);

        $this->subImageFlag = $this->lfSetFile($this->objUpFile, $this->arrProduct, $this->arrFile);
        //レビュー情報の取得
        $this->arrReview = $this->lfGetReviewData($product_id);

        //関連商品情報表示
        $this->arrRecommend = $this->lfPreGetRecommendProducts($product_id);

        // ログイン判定
        if ($objCustomer->isLoginSuccess() === true) {
            //お気に入りボタン表示
            $this->tpl_login = true;
            $this->is_favorite = SC_Helper_DB_Ex::sfDataExists('dtb_customer_favorite_products', 'customer_id = ? AND product_id = ?', array($objCustomer->getValue('customer_id'), $product_id));
        }

        //出演、モデル、スタイルを取得 20170727 kikuzawa
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $parent_actor_category_id = $objQuery->get('category_id', 'dtb_category', "level = 1 AND category_name = '出演モデル'");
        $actor_class_id = SC_Utils_Ex::sfGetChildCategory($parent_actor_category_id);
        $this->actor_categorytree = array();
        foreach ($actor_class_id as $class_id) {
            $temp = SC_Utils_Ex::sfGetChildCategory($class_id['category_id'], $product_id);
            foreach ($temp as $v) {
                $this->actor_categorytree[] = $v;
            }
        }
        $parent_modeltype_category_id = $objQuery->get('category_id', 'dtb_category', "level = 1 AND category_name = 'モデルタイプ'");
        $this->modeltype_categorytree = SC_Utils_Ex::sfGetChildCategory($parent_modeltype_category_id, $product_id);
        $parent_playstyle_category_id = $objQuery->get('category_id', 'dtb_category', "level = 1 AND category_name = 'プレイスタイル'");
        $this->playstyle_categorytree = SC_Utils_Ex::sfGetChildCategory($parent_playstyle_category_id, $product_id);

        //ランクごとの金額を取得
        $this->customer_rank = plg_ManageCustomerStatus_Utils::getStatusRankList();
        $rank_price_temp = $objQuery->select('*', 'plg_managecustomerstatus_dtb_price', 'product_id = '.$product_id);
        $this->rank_price = array();
        foreach ($rank_price_temp as $price) {
            switch ($price['status_id']) {
                case 8://vip
                    $this->rank_price[8] = SC_Helper_TaxRule_Ex::sfCalcIncTax($price['price'], $price['product_id']);
                    break;
                case 6://FM
                    $this->rank_price[6] = SC_Helper_TaxRule_Ex::sfCalcIncTax($price['price'], $price['product_id']);
                    break;
                case 7://DX
                    $this->rank_price[7] = SC_Helper_TaxRule_Ex::sfCalcIncTax($price['price'], $price['product_id']);
                    break;
            }
        }
    }
}
