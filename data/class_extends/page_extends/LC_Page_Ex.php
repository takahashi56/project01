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

require_once CLASS_REALDIR . 'pages/LC_Page.php';

class LC_Page_Ex extends LC_Page
{
  public function init()
  {   
      parent::init();

      // ログイン判定
      $this->memberShipCategory = 217;

      $objCustomer = new SC_Customer_Ex();
      if ($objCustomer->isLoginSuccess() === true) {
          $this->tpl_login = true;
          $this->CustomerName1 = $objCustomer->getValue('name01');
          $this->CustomerName2 = $objCustomer->getValue('name02');
          $this->CustomerPoint = $objCustomer->getValue('point');
          if ($this->VideoValidDays == null)
            $this->VideoValidDays = $this->lfGetMembershipFeeOrder($objCustomer->getValue('customer_id'));
      } else {
          $this->tpl_login = false;
      }

      // カテゴリ情報を取得する。
      //$cats = SC_Helper_DB_Ex::sfGetLevelCatList();
      // 最新
      $arrCategoryData = $this->lfGetCategories(48, false);
      $this->arrSaisin = $arrCategoryData['arrChildren'];
      
      // モデルタイプ
      $arrCategoryData = $this->lfGetCategories(8, false);
      $this->arrModelType = $arrCategoryData['arrChildren'];
      
      // フェチタイプ
      $arrCategoryData = $this->lfGetCategories(101, false);
      $this->arrFetchType = $arrCategoryData['arrChildren'];

      // レーベル
      $arrCategoryData = $this->lfGetCategories(10, false);
      $this->arrLabel = $arrCategoryData['arrChildren'];
      
      // メーカー
      $arrCategoryData = $this->lfGetCategories(9, false);
      $this->arrMaker = $arrCategoryData['arrChildren'];
      
      // モデル
      $arrCategoryData = $this->lfGetCategories(47, false);
      $this->arrModel = $arrCategoryData['arrChildren'];
      
      // ランキング
      $this->arrBestProducts = $this->lfGetRanking();
      //$this->action();


  }

  public function lfGetMembershipFeeOrder($customerId)
  {
    $objQuery =& SC_Query_Ex::getSingletonInstance();

    $diff = -1;

    // $customerOrders = $objQuery->getCol('o.update_date', '(dtb_order as o left join dtb_order_detail as od on o.order_id = od.order_id) left join dtb_product_categories as pc on od.product_id = pc.product_id', 'o.customer_id = ' . $customerId . ' and pc.category_id = ' . $this->memberShipCategory);

    // if (sizeof($customerOrders) > 0) {
      // $now = time(); 
      // $your_date = strtotime($customerOrders[sizeof($customerOrders) - 1]);
      // $datediff = $now - $your_date;

      // $diff = round($datediff / (60 * 60 * 24));  

    $orders = $objQuery->getCol('o.order_id', '(dtb_order as o left join dtb_order_detail as od on o.order_id = od.order_id) left join dtb_product_categories as pc on od.product_id = pc.product_id', 'o.customer_id = ' . $customerId . ' and o.del_flg = 0 and pc.category_id = ' . $this->memberShipCategory);
    $this->membershipOrderIds = $orders;

    if (sizeof($orders) > 0) {
      $days = $objQuery->getCol('pc.product_code', '(dtb_products_class as pc left join dtb_products as p on p.product_id = pc.product_id) left join dtb_order_detail as od on od.product_id = pc.product_id', 'od.order_id = ?', $orders[sizeof($orders) - 1]);

      if (sizeof($orders) > 1) {
        unset($orders[sizeof($orders) - 1]);
        $objQuery->update('dtb_order', array('del_flg' => 1), 'order_id = ?', $orders);
      }
      
      $validDays = (int) $days[0];
      // $diff = $validDays - $diff;

      return $validDays;
    }

    return -1;

    // return $diff;      
  }
  
  /**
   * 選択されたカテゴリとその子カテゴリの情報を取得し、
   * ページオブジェクトに格納する。
   *
   * @param  string  $category_id カテゴリID
   * @param  boolean $count_check 有効な商品がないカテゴリを除くかどうか
   * @return void
   */
  public function lfGetCategories($category_id, $count_check = false)
  {
      $arrCategory = null;    // 選択されたカテゴリ
      $arrChildren = array(); // 子カテゴリ

      $arrAll = SC_Helper_DB_Ex::sfGetCatTree($category_id, $count_check);
      foreach ($arrAll as $category) {
          // 選択されたカテゴリの場合
          if ($category['category_id'] == $category_id) {
              $arrCategory = $category;
              continue;
          }

          // 関係のないカテゴリはスキップする。
          if ($category['parent_category_id'] != $category_id) {
              continue;
          }

          // 子カテゴリの場合は、孫カテゴリが存在するかどうかを調べる。
          $arrGrandchildrenID = SC_Utils_Ex::sfGetUnderChildrenArray($arrAll, 'parent_category_id', 'category_id', $category['category_id']);
          $category['has_children'] = count($arrGrandchildrenID) > 0;
          $arrChildren[] = $category;
      }

      if (!isset($arrCategory)) {
          SC_Utils_Ex::sfDispSiteError(CATEGORY_NOT_FOUND);
      }

      // 子カテゴリの商品数を合計する。
      $children_product_count = 0;
      foreach ($arrChildren as $category) {
          $children_product_count += $category['product_count'];
      }

      // 選択されたカテゴリに直属の商品がある場合は、子カテゴリの先頭に追加する。
      if ($arrCategory['product_count'] > $children_product_count) {
          $arrCategory['product_count'] -= $children_product_count; // 子カテゴリの商品数を除く。
          $arrCategory['has_children'] = false; // 商品一覧ページに遷移させるため。
          array_unshift($arrChildren, $arrCategory);
      }

      return array('arrChildren'=>$arrChildren, 'arrCategory'=>$arrCategory);
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
                        $response[] = array_merge($value, $arrProducts[$value['product_id']]);
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

}
