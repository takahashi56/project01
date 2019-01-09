<?php
/*
 * この商品を買った人はこんな商品も買っていますプラグイン
 *
 * Copyright (C) 2013 Nobuhiko Kimoto
 * http://nob-log.info/contact/
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
*/

/**
 * プラグインのメインクラス
 *
 * @package Recommendify
 * @author Nobuhiko Kimoto
 * @version $Id: $
 */
class Recommendify extends SC_Plugin_Base
{
    /**
     * コンストラクタ
     */
    public function __construct(array $arrSelfInfo)
    {
        parent::__construct($arrSelfInfo);
    }

    /**
     * インストール
     * installはプラグインのインストール時に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param  array $arrPlugin plugin_infoを元にDBに登録されたプラグイン情報(dtb_plugin)
     * @return void
     */
    public function install($arrPlugin)
    {
        // プラグインのロゴ画像をアップ
        if (file_exists(PLUGIN_UPLOAD_REALDIR ."Recommendify/logo.png")) {
            if(copy(PLUGIN_UPLOAD_REALDIR . "Recommendify/logo.png", PLUGIN_HTML_REALDIR . "Recommendify/logo.png") === false);
        }
    }

    /**
     * アンインストール
     * uninstallはアンインストール時に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param  array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    public function uninstall($arrPlugin)
    {
        // ロゴ画像削除
        if (file_exists(PLUGIN_HTML_REALDIR ."Recommendify/logo.png")) {
            if(SC_Helper_FileManager_Ex::deleteFile(PLUGIN_HTML_REALDIR . "Recommendify/logo.png") === false);
        }
        if (file_exists(TEMPLATE_REALDIR ."frontparts/bloc/plg_recommendify.tpl")) {
            if(SC_Helper_FileManager_Ex::deleteFile(TEMPLATE_REALDIR ."frontparts/bloc/plg_recommendify.tpl") === false);
        }
    }

    /**
     * 稼働
     * enableはプラグインを有効にした際に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param  array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    public function enable($arrPlugin)
    {
        self::insertFreeField($arrPlugin);
        if (copy(PLUGIN_UPLOAD_REALDIR . "Recommendify/jquery.dbpas.carousel.css", PLUGIN_HTML_REALDIR . "Recommendify/jquery.dbpas.carousel.css") === false);
        if (copy(PLUGIN_UPLOAD_REALDIR . "Recommendify/jquery.dbpas.carousel.js", PLUGIN_HTML_REALDIR . "Recommendify/jquery.dbpas.carousel.js") === false);
        if (copy(PLUGIN_UPLOAD_REALDIR . "Recommendify/tpl/default/plg_recommendify.tpl", TEMPLATE_REALDIR . "frontparts/bloc/plg_recommendify.tpl") === false);
        self::insertBloc($arrPlugin);
    }

    /**
     * 停止
     * disableはプラグインを無効にした際に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param  array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    public function disable($arrPlugin)
    {
        self::deleteBloc($arrPlugin);
    }

    /**
     * 処理の介入箇所とコールバック関数を設定
     * registerはプラグインインスタンス生成時に実行されます
     *
     * @param SC_Helper_Plugin $objHelperPlugin
     */
    public function register(SC_Helper_Plugin $objHelperPlugin)
    {
        $objHelperPlugin->addAction('LC_Page_Products_Detail_action_after', array($this, 'detail_after_hook'), $this->arrSelfInfo['priority']);
    }

    // プラグイン独自の設定データを追加
    public function insertFreeField($arrPlugin)
    {
        //設定値を書き込む必要がある場合はコメントを外してください
        $objQuery = SC_Query_Ex::getSingletonInstance();
        $sqlval = array();
        $sqlval['free_field1'] = "6";
        //$sqlval['free_field2'] = "1";
        $sqlval['update_date'] = 'CURRENT_TIMESTAMP';
        $where = "plugin_code = ?";
        // UPDATEの実行
        $objQuery->update('dtb_plugin', $sqlval, $where, array($arrPlugin['plugin_code']));

    }

    public function insertBloc($arrPlugin)
    {
        $objQuery = SC_Query_Ex::getSingletonInstance();
        // dtb_blocにブロックを追加する.
        $sqlval_bloc = array();
        $sqlval_bloc['device_type_id'] = DEVICE_TYPE_PC;
        $sqlval_bloc['bloc_id'] = $objQuery->max('bloc_id', "dtb_bloc", "device_type_id = " . DEVICE_TYPE_PC) + 1;
        $sqlval_bloc['bloc_name'] = $arrPlugin['plugin_name'];
        $sqlval_bloc['tpl_path'] = "plg_recommendify.tpl";
        $sqlval_bloc['filename'] = "plg_recommendify";
        $sqlval_bloc['create_date'] = "CURRENT_TIMESTAMP";
        $sqlval_bloc['update_date'] = "CURRENT_TIMESTAMP";
        $sqlval_bloc['deletable_flg'] = 0;
        $sqlval_bloc['plugin_id'] = $arrPlugin['plugin_id'];
        $objQuery->insert("dtb_bloc", $sqlval_bloc);
    }

    public function deleteBloc($arrPlugin)
    {
        $objQuery = SC_Query_Ex::getSingletonInstance();
        $objQuery->delete("dtb_bloc", 'plugin_id = ?', array($arrPlugin['plugin_id']));
    }

    /**
     * プレフィルタコールバック関数
     *
     * @param string &$source テンプレートのHTMLソース
     * @param  LC_Page_Ex $objPage  ページオブジェクト
     * @param  string     $filename テンプレートのファイル名
     * @return void
     */
    public function prefilterTransform(&$source, LC_Page_Ex $objPage, $filename)
    {
        $objTransform = new SC_Helper_Transform($source);
        $template_dir = PLUGIN_UPLOAD_REALDIR . 'Recommendify/';
        switch ($objPage->arrPageLayout['device_type_id']) {
            case DEVICE_TYPE_MOBILE:
            case DEVICE_TYPE_SMARTPHONE:
            case DEVICE_TYPE_PC:
                break;
            case DEVICE_TYPE_ADMIN:
            default:
                break;
        }
        //トランスフォームされた値で書き換え
        //$source = $objTransform->getHTML();
    }

    //設定を取得する必要がある場合はコメントを外す
    public function loadData()
    {
        $arrRet = array();
        $arrData = SC_Plugin_Util_Ex::getPluginByPluginCode("Recommendify");
        if (!SC_Utils_Ex::isBlank($arrData['free_field1'])) {
            return $arrData['free_field1'];
        }
        //return $arrRet;
    }

    public function detail_after_hook($objPage)
    {
        $product_id = $objPage->tpl_product_id;

        $objProduct = new SC_Product_Ex();
        $objQuery =& SC_Query_Ex::getSingletonInstance();

        //$objQuery->setOrder('count(product_id) desc');
        //$objQuery->setGroupBy('product_id');
        //$objQuery->setLimit(self::loadData());

        //"ポイントを購入する"カテゴリーに属する商品は除外 20170820 kikuzawa
        $arrRecommendData =
            $objQuery->getCol(
                'distinct dtb_order_detail.product_id as recommend_product_id',
                '   dtb_order_detail
                    JOIN dtb_order USING ( order_id )
                    JOIN dtb_products USING ( product_id )
                    JOIN dtb_product_categories USING ( product_id )
                ',
                '
                    dtb_order_detail.product_id <> ?
                    AND dtb_products.del_flg = 0
                    AND dtb_products.status = 1
                    AND dtb_product_categories.category_id <> 2
                    AND dtb_order.order_email
                    IN (
                        SELECT dtb_order.order_email
                        FROM dtb_order_detail
                        JOIN dtb_order USING ( order_id )
                        WHERE dtb_order_detail.product_id = ?
                    )',
                array($product_id, $product_id));

        if (count($arrRecommendData) > self::loadData()) {
            $datetime = new DateTime('today', new DateTimeZone('Asia/Tokyo'));
            srand($datetime->format('U'));
            $rand_keys = array_rand($arrRecommendData, self::loadData());
        } else {
            $rand_keys = array_keys($arrRecommendData);
        }

        $arrRecommendProductId = array();
        foreach($rand_keys as $key){
	        $arrRecommendProductId[] = $arrRecommendData[$key];
        }

        /*$arrRecommendProductId = array();
        foreach ($arrRecommendData as $recommend) {
            $arrRecommendProductId[] = $recommend['recommend_product_id'];
        }*/

        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $arrProducts = $objProduct->getListByProductIds($objQuery, $arrRecommendProductId);

        $arrRecommend = array();
        foreach ($arrRecommendProductId as $key => $product_id) {
            $arrRecommendfy[$key] = $arrProducts[$product_id];
            $arrRecommendfy[$key]['recommend_product_id'] = $product_id;
            //$arrRecommendData[$key] = array_merge($arrRow, $arrProducts[$arrRow['recommend_product_id']]);
        }

        $objPage->arrRecommendify = $arrRecommendfy;
        //var_dump($arrRecommendData);
    }

}
