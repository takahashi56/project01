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

require_once CLASS_REALDIR . 'pages/admin/products/LC_Page_Admin_Products_UploadCSV.php';

/**
 * CSV アップロード のページクラス(拡張).
 *
 * LC_Page_Admin_Products_UploadCSV をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $$Id$$
 */
class LC_Page_Admin_Products_UploadCSV_Ex extends LC_Page_Admin_Products_UploadCSV
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
     * 商品登録を行う.
     *
     * FIXME: 商品登録の実処理自体は、LC_Page_Admin_Products_Productと共通化して欲しい。
     *
     * @param  SC_Query       $objQuery SC_Queryインスタンス
     * @param  string|integer $line     処理中の行数
     * @return void
     */
    public function lfRegistProduct($objQuery, $line = '', &$objFormParam)
    {
        $objProduct = new SC_Product_Ex();
        // 登録データ対象取得
        $arrList = $objFormParam->getDbArray();

        // 登録時間を生成(DBのCURRENT_TIMESTAMPだとcommitした際、全て同一の時間になってしまう)
        $arrList['update_date'] = $this->lfGetDbFormatTimeWithLine($line);

        // 商品登録情報を生成する。
        // 商品テーブルのカラムに存在しているもののうち、Form投入設定されていないデータは上書きしない。
        $sqlval = SC_Utils_Ex::sfArrayIntersectKeys($arrList, $this->arrProductColumn);

        // 必須入力では無い項目だが、空文字では問題のある特殊なカラム値の初期値設定
        $sqlval = $this->lfSetProductDefaultData($sqlval);

        if ($sqlval['product_id'] != '') {
            // 同じidが存在すればupdate存在しなければinsert
            $where = 'product_id = ?';
            $product_exists = $objQuery->exists('dtb_products', $where, array($sqlval['product_id']));
            if ($product_exists) {
                $objQuery->update('dtb_products', $sqlval, $where, array($sqlval['product_id']));
            } else {
                $sqlval['create_date'] = $arrList['update_date'];
                // INSERTの実行
                $objQuery->insert('dtb_products', $sqlval);
                // シーケンスの調整
                $seq_count = $objQuery->currVal('dtb_products_product_id');
                if ($seq_count < $sqlval['product_id']) {
                    $objQuery->setVal('dtb_products_product_id', $sqlval['product_id'] + 1);
                }
            }
            $product_id = $sqlval['product_id'];
        } else {
            // 新規登録
            $sqlval['product_id'] = $objQuery->nextVal('dtb_products_product_id');
            $product_id = $sqlval['product_id'];
            $sqlval['create_date'] = $arrList['update_date'];
            // INSERTの実行
            $objQuery->insert('dtb_products', $sqlval);
        }

        // カテゴリ登録
        if (isset($arrList['category_ids'])) {
            $arrCategory_id = explode(',', $arrList['category_ids']);
            $this->objDb->updateProductCategories($arrCategory_id, $product_id);
        }
        // 商品ステータス登録
        if (isset($arrList['product_statuses'])) {
            $arrStatus_id = explode(',', $arrList['product_statuses']);
            $objProduct->setProductStatus($product_id, $arrStatus_id);
        }

        // 商品規格情報を登録する
        $this->lfRegistProductClass($objQuery, $arrList, $product_id, $arrList['product_class_id']);

        // 関連商品登録
        $this->lfRegistReccomendProducts($objQuery, $arrList, $product_id);

        // プラグインで追加した項目を登録 20170822 kikuzawa
        $this->lfRegistAddedProductColumn($objQuery, $arrList, $product_id);
    }

    /**
     * プラグインで追加した項目を登録.
     *
     * @param  SC_Query $objQuery   SC_Queryインスタンス
     * @param  array    $arrList    商品規格情報配列
     * @param  integer  $product_id 商品ID
     * @return void
     */
    public function lfRegistAddedProductColumn($objQuery, $arrList, $product_id)
    {
        print_r($arrList);exit();
        // $arr_keyname = array('papc4');
        // $table = 'plg_apc_dtb_values';
        // $where = 'product_id = ? AND column_id = ?';

        // foreach($arr_keyname as $keyname){
        //     $column_id = $arrMatches[1];
        //     $arrWhereValues = array($product_id, $column_id);
        //     $arrValues = compact('value', 'column_id', 'product_id');
        //     $exists = $objQuery->exists($table, $where, $arrWhereValues);

        //     if($exists){

        //         $objQuery->update($table, $arrValues, $where, $arrWhereValues);
        //     }
        //     else{

        //         $arrValues['value_id'] = $objQuery->nextVal('plg_apc_dtb_values_value_id');
        //         $objQuery->insert($table, $arrValues);
        //     }
        // }
    }

}
