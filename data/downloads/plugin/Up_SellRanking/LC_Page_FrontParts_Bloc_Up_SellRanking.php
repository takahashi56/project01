<?php
/*
 * Up_SellRanking
 * Copyright(c) 2014 Designup All Rights Reserved.
 *
 * http://designup.jp/
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

// {{{ requires
require_once CLASS_REALDIR . 'pages/frontparts/bloc/LC_Page_FrontParts_Bloc.php';

class LC_Page_FrontParts_Bloc_Up_SellRanking extends LC_Page_FrontParts_Bloc {

    /**
     * 初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();
    }

    /**
     * プロセス.
     *
     * @return void
     */
    function process() {
        $this->action();
        $this->sendResponse();
    }

    /**
     * Page のアクション.
     *
     * @return void
     */
    function action() {

        // 売上ランキング取得
        $this->arrBestProducts = $this->lfGetRanking();

        // 商品レビュー情報を取得
        $this->arrReviewList = $this->getReviewList();

        // メーカー情報を取得
        $this->arrMakerList = $this->getMakerList();

        // ブロックのタイトルを取得
        $this->blocTitle = $this->getBlocTitle();

    }

    /**
     * デストラクタ.
     *
     * @return void
     */
    function destroy() {
        parent::destroy();
    }

    /**
     * おすすめ商品検索.
     *
     * @return array $arrBestProducts 検索結果配列
     */
    public function lfGetRanking()
    {

        // 売上ランキング取得、デフォルトは５位まで取得
        $arrRanking = $this -> getList();

        $response = array();
        if (count($arrRanking) > 0) {
            // 商品一覧を取得
            $objQuery =& SC_Query_Ex::getSingletonInstance();
            $objProduct = new SC_Product_Ex();
            // where条件生成&セット
            $arrProductId = array();
            foreach ($arrRanking as $key => $val) {
                $arrProductId[] = $val['product_id'];
            }
            $arrProducts = $objProduct->getListByProductIds($objQuery, $arrProductId);

            // 税込金額を設定する
            SC_Product_Ex::setIncTaxToProducts($arrProducts);

            // 売上ランキング情報にマージ
            foreach ($arrRanking as $key => $value) {
                if (isset($arrProducts[$value['product_id']])) {
                    $product = $arrProducts[$value['product_id']];
                    $product_type = $objProduct->getProductsClassFullByProductId($value['product_id']);
                    $product_type_id = $product_type[0]['product_type_id'];
                    if ($product['status'] == 1 && (!NOSTOCK_HIDDEN || ($product['stock_max'] >= 1 || $product['stock_unlimited_max'] == 1))) {
                      if ($product_type_id == 2) {
                        //VIP会員価格を追加 20170821 kikuzawa
                        $rank_price['vip_price'] = SC_Helper_TaxRule_Ex::sfCalcIncTax($objQuery->get('price', 'plg_managecustomerstatus_dtb_price', 'status_id = 8 AND product_id = '.$value['product_id']), $value['product_id']);
                        $response[] = array_merge($value, $arrProducts[$value['product_id']], $rank_price);

                        $cnt+=1;
                        if($cnt == 10) {
                          return $response;
                        }
                      }
                    }
                } else {
                    // 削除済み商品は除外
                    unset($arrRanking[$key]);
                }
            }
        }

        return $response;
    }

    /**
     * 商品情報を取得
     *
     * @return array $arrNewProducts 検索結果配列
     */
    public function getList($dispNumber = 0, $pageNumber = 0, $has_deleted = false)
    {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $col = 'product_id,price,SUM(quantity),SUM(quantity)*price';
        $table = 'dtb_order_detail';
        $where = '';
        $objQuery->setGroupBy('product_id,price');
        $objQuery->setOrder('SUM(quantity)*price DESC');

        // プラグインの設定情報を取得
        $arrPlugin = array();
        $arrPlugin = SC_Plugin_Util_Ex::getPluginByPluginCode("Up_SellRanking");
        $dispNumber = $arrPlugin['free_field1'];

        if ($dispNumber > 0) {
            if ($pageNumber > 0) {
                $objQuery->setLimitOffset($dispNumber, (($pageNumber - 1) * $dispNumber));
            } else {
                $objQuery->setLimit($dispNumber);
            }
        }
        $arrRet = $objQuery->select($col, $table, $where);

        return $arrRet;
    }

    /**
     * 商品のレビューと商品情報を結合した情報を取得
     * 商品ごとに集計、小数点以下切り捨て
     *
     * @return array $arrReviewList 検索結果配列
     */
    public function getReviewList($dispNumber = 0, $pageNumber = 0, $has_deleted = false)
    {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $col = 'product_id,TRUNC(AVG(recommend_level),0) AS recommend_level,COUNT(*) AS recommend_count';
        $table = 'dtb_review';
        $where = '';
        $objQuery->setGroupBy('product_id');
        $objQuery->setOrder('product_id DESC');

        if ($dispNumber > 0) {
            if ($pageNumber > 0) {
                $objQuery->setLimitOffset($dispNumber, (($pageNumber - 1) * $dispNumber));
            } else {
                $objQuery->setLimit($dispNumber);
            }
        }
        $arrRet = $objQuery->select($col, $table, $where);

        return $arrRet;
    }

    /**
     * メーカー情報の取得
     *
     * @return array $arrMakerList 検索結果配列
     */
    public function getMakerList($dispNumber = 0, $pageNumber = 0, $has_deleted = false)
    {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $col = '*';
        $table = 'dtb_maker';
        $where = '';

        if ($dispNumber > 0) {
            if ($pageNumber > 0) {
                $objQuery->setLimitOffset($dispNumber, (($pageNumber - 1) * $dispNumber));
            } else {
                $objQuery->setLimit($dispNumber);
            }
        }
        $arrRet = $objQuery->select($col, $table, $where);

        return $arrRet;
    }

    /**
     * プラグインDBからブロックタイトルを取得
     *
     * @return $blocTitle プラグイン設定から取得したタイトル
     */
    public function getBlocTitle()
    {
        // プラグインの設定情報を取得
        $arrPlugin = SC_Plugin_Util_Ex::getPluginByPluginCode("Up_SellRanking");
        $blocTitle = $arrPlugin['free_field2'];

        return $blocTitle;
    }

}
?>
