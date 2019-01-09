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

      // ���O�C������
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

      // �J�e�S�������擾����B
      //$cats = SC_Helper_DB_Ex::sfGetLevelCatList();
      // �ŐV
      $arrCategoryData = $this->lfGetCategories(48, false);
      $this->arrSaisin = $arrCategoryData['arrChildren'];
      
      // ���f���^�C�v
      $arrCategoryData = $this->lfGetCategories(8, false);
      $this->arrModelType = $arrCategoryData['arrChildren'];
      
      // �t�F�`�^�C�v
      $arrCategoryData = $this->lfGetCategories(101, false);
      $this->arrFetchType = $arrCategoryData['arrChildren'];

      // ���[�x��
      $arrCategoryData = $this->lfGetCategories(10, false);
      $this->arrLabel = $arrCategoryData['arrChildren'];
      
      // ���[�J�[
      $arrCategoryData = $this->lfGetCategories(9, false);
      $this->arrMaker = $arrCategoryData['arrChildren'];
      
      // ���f��
      $arrCategoryData = $this->lfGetCategories(47, false);
      $this->arrModel = $arrCategoryData['arrChildren'];
      
      // �����L���O
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
   * �I�����ꂽ�J�e�S���Ƃ��̎q�J�e�S���̏����擾���A
   * �y�[�W�I�u�W�F�N�g�Ɋi�[����B
   *
   * @param  string  $category_id �J�e�S��ID
   * @param  boolean $count_check �L���ȏ��i���Ȃ��J�e�S�����������ǂ���
   * @return void
   */
  public function lfGetCategories($category_id, $count_check = false)
  {
      $arrCategory = null;    // �I�����ꂽ�J�e�S��
      $arrChildren = array(); // �q�J�e�S��

      $arrAll = SC_Helper_DB_Ex::sfGetCatTree($category_id, $count_check);
      foreach ($arrAll as $category) {
          // �I�����ꂽ�J�e�S���̏ꍇ
          if ($category['category_id'] == $category_id) {
              $arrCategory = $category;
              continue;
          }

          // �֌W�̂Ȃ��J�e�S���̓X�L�b�v����B
          if ($category['parent_category_id'] != $category_id) {
              continue;
          }

          // �q�J�e�S���̏ꍇ�́A���J�e�S�������݂��邩�ǂ����𒲂ׂ�B
          $arrGrandchildrenID = SC_Utils_Ex::sfGetUnderChildrenArray($arrAll, 'parent_category_id', 'category_id', $category['category_id']);
          $category['has_children'] = count($arrGrandchildrenID) > 0;
          $arrChildren[] = $category;
      }

      if (!isset($arrCategory)) {
          SC_Utils_Ex::sfDispSiteError(CATEGORY_NOT_FOUND);
      }

      // �q�J�e�S���̏��i�������v����B
      $children_product_count = 0;
      foreach ($arrChildren as $category) {
          $children_product_count += $category['product_count'];
      }

      // �I�����ꂽ�J�e�S���ɒ����̏��i������ꍇ�́A�q�J�e�S���̐擪�ɒǉ�����B
      if ($arrCategory['product_count'] > $children_product_count) {
          $arrCategory['product_count'] -= $children_product_count; // �q�J�e�S���̏��i���������B
          $arrCategory['has_children'] = false; // ���i�ꗗ�y�[�W�ɑJ�ڂ����邽�߁B
          array_unshift($arrChildren, $arrCategory);
      }

      return array('arrChildren'=>$arrChildren, 'arrCategory'=>$arrCategory);
  }

    /**
     * �������ߏ��i����.
     *
     * @return array $arrBestProducts �������ʔz��
     */
    public function lfGetRanking()
    {

        // ���ド���L���O�擾�A�f�t�H���g�͂T�ʂ܂Ŏ擾
        $arrRanking = $this -> getList();

        $response = array();
        if (count($arrRanking) > 0) {
            // ���i�ꗗ���擾
            $objQuery =& SC_Query_Ex::getSingletonInstance();
            $objProduct = new SC_Product_Ex();
            // where��������&�Z�b�g
            $arrProductId = array();
            foreach ($arrRanking as $key => $val) {
                $arrProductId[] = $val['product_id'];
            }
            $arrProducts = $objProduct->getListByProductIds($objQuery, $arrProductId);

            // �ō����z��ݒ肷��
            SC_Product_Ex::setIncTaxToProducts($arrProducts);

            // ���ド���L���O���Ƀ}�[�W
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
                    // �폜�ςݏ��i�͏��O
                    unset($arrRanking[$key]);
                }
            }
        }

        return $response;
    }

    /**
     * ���i�����擾
     *
     * @return array $arrNewProducts �������ʔz��
     */
    public function getList($dispNumber = 0, $pageNumber = 0, $has_deleted = false)
    {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $col = 'product_id,price,SUM(quantity),SUM(quantity)*price';
        $table = 'dtb_order_detail';
        $where = '';
        $objQuery->setGroupBy('product_id,price');
        $objQuery->setOrder('SUM(quantity)*price DESC');

        // �v���O�C���̐ݒ�����擾
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
