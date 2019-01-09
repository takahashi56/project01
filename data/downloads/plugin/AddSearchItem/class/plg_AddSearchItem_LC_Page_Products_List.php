<?php
/*
 * AddSearchItem
 * Copyright (C) 2014 Bratech CO.,LTD. All Rights Reserved.
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

require_once PLUGIN_UPLOAD_REALDIR . "AddSearchItem/class/plg_AddSearchItem_LC_Page.php";

class plg_AddSearchitem_LC_Page_Products_List extends plg_AddSearchItem_LC_Page{
    /**
     * @param LC_Page_Products_List $objPage
     * @return void
     */
    function before($objPage) {
		//スマホ：json用
		$mode = $objPage->getMode();
		
		if($mode == 'json'){
			$objProduct = new SC_Product_Ex();
			
			$arrForm = $_REQUEST;
			//modeの取得
			
	
			//表示条件の取得
			$arrSearchData = array(
				'category_id'   => $objPage->lfGetCategoryId(intval($arrForm['category_id'])),
				'maker_id'      => intval($arrForm['maker_id']),
				'name'          => $arrForm['name'],
				'sf'			=> intval($arrForm['sf']),
				'rf'			=> intval($arrForm['rf']),
				'fs'			=> intval($arrForm['fs']),
				'price_min'		=> mb_convert_kana($arrForm['price_min'],'n'),
				'price_max'		=> mb_convert_kana($arrForm['price_max'],'n'),
				'product_status_id'	=> $arrForm['product_status_id'],
			);
			$orderby = $arrForm['orderby'];
			
			//ページング設定
			$tpl_pageno   = $arrForm['pageno'];
			$disp_number  = self::lfGetDisplayNum($arrForm['disp_number']);
			
			// 商品一覧データの取得
			$arrSearchCondition = self::lfGetSearchCondition($arrSearchData);
			$tpl_linemax  = $objPage->lfGetProductAllNum($arrSearchCondition);
			$urlParam           = "category_id={$arrSearchData['category_id']}&pageno=#page#";

			if(plg_AddSearchItem_Util::getECCUBEVer() >= 2130){
				$objNavi      = new SC_PageNavi_Ex($tpl_pageno, $tpl_linemax, $disp_number, 'eccube.movePage', NAVI_PMAX, $urlParam, SC_Display_Ex::detectDevice() !== DEVICE_TYPE_MOBILE);
				$arrProducts  = self::lfGetProductsList($arrSearchCondition, $disp_number, $objNavi->start_row, $tpl_linemax, $orderby, $objProduct);
			}else{
				$objNavi      = new SC_PageNavi_Ex($tpl_pageno, $tpl_linemax, $disp_number, 'fnNaviPage', NAVI_PMAX, $urlParam, true);
				$arrProducts  = self::lfGetProductsList($arrSearchCondition, $disp_number, $objNavi->start_row, $tpl_linemax, $orderby, $objProduct);
			}			

        	$masterData                 = new SC_DB_MasterData_Ex();
    	    $arrSTATUS            = $masterData->getMasterData('mtb_status');
	        $arrSTATUS_IMAGE      = $masterData->getMasterData('mtb_status_image');
			$arrProducts = $objPage->setStatusDataTo($arrProducts, $arrSTATUS, $arrSTATUS_IMAGE);
			$arrProducts = $objProduct->setPriceTaxTo($arrProducts);

			// 一覧メイン画像の指定が無い商品のための処理
			foreach ($arrProducts as $key=>$val) {
				$arrProducts[$key]['main_list_image'] = SC_Utils_Ex::sfNoImageMainList($val['main_list_image']);
			}
			echo SC_Utils_Ex::jsonEncode($arrProducts);
			exit;

		}
    }
	
	
    /**
     * @param LC_Page_Products_List $objPage
     * @return void
     */
    function after($objPage) {
		$objPage->arrSortList = plg_AddSearchItem_Util::getSortList();
		$objPage->fs_enable = plg_AddSearchItem_Util::existsFreeShippingPlg();
        $objProduct = new SC_Product_Ex();

        //表示条件の取得
        $objPage->arrSearchData = array(
            'category_id'   => $objPage->lfGetCategoryId(intval($objPage->arrForm['category_id'])),
            'maker_id'      => intval($objPage->arrForm['maker_id']),
            'name'          => $objPage->arrForm['name'],
			'sf'			=> intval($objPage->arrForm['sf']),
			'rf'			=> intval($objPage->arrForm['rf']),
			'fs'			=> intval($objPage->arrForm['fs']),
			'price_min'		=> mb_convert_kana($objPage->arrForm['price_min'],'n'),
			'price_max'		=> mb_convert_kana($objPage->arrForm['price_max'],'n'),
			'product_status_id'	=> $objPage->arrForm['product_status_id'],
        );

		// 画面に表示する検索条件を設定
        $objPage->arrSearch    = self::lfGetSearchConditionDisp($objPage->arrSearchData);
		
        // 商品一覧データの取得
        $arrSearchCondition = self::lfGetSearchCondition($objPage->arrSearchData);
		$objPage->tpl_linemax  = $objPage->lfGetProductAllNum($arrSearchCondition);
        $urlParam           = "category_id={$arrSearchData['category_id']}&pageno=#page#";

        // モバイルの場合に検索条件をURLの引数に追加
        if (SC_Display_Ex::detectDevice() === DEVICE_TYPE_MOBILE) {
            $searchNameUrl = urlencode(mb_convert_encoding($objPage->arrSearchData['name'], 'SJIS-win', 'UTF-8'));
            $urlParam .= "&mode={$objPage->mode}&name={$searchNameUrl}&orderby={$objPage->orderby}&sf={$objPage->arrSearchData['sf']}&rf={$objPage->arrSearchData['rf']}&fs={$objPage->arrSearchData['fs']}&price_min={$objPage->arrSearchData['price_min']}&price_max={$objPage->arrSearchData['price_max']}&product_status_id={$objPage->arrSearchData['product_status_id']}";
        }
		if(plg_AddSearchItem_Util::getECCUBEVer() >= 2130){
			$objPage->objNavi      = new SC_PageNavi_Ex($objPage->tpl_pageno, $objPage->tpl_linemax, $objPage->disp_number, 'eccube.movePage', NAVI_PMAX, $urlParam, SC_Display_Ex::detectDevice() !== DEVICE_TYPE_MOBILE);
			$objPage->arrProducts  = self::lfGetProductsList($arrSearchCondition, $objPage->disp_number, $objPage->objNavi->start_row, $objPage->tpl_linemax, $objPage->orderby, $objProduct);
		}else{
        	$objPage->objNavi      = new SC_PageNavi_Ex($objPage->tpl_pageno, $objPage->tpl_linemax, $objPage->disp_number, 'fnNaviPage', NAVI_PMAX, $urlParam, SC_Display_Ex::detectDevice() !== DEVICE_TYPE_MOBILE);
			$objPage->arrProducts  = self::lfGetProductsList($arrSearchCondition, $objPage->disp_number, $objPage->objNavi->start_row, $objPage->tpl_linemax, $objPage->orderby, $objProduct);
		}
        
		
        switch ($objPage->getMode()) {
			case 'json':
				break;
            default:
				//商品一覧の表示処理
				$strnavi            = $objPage->objNavi->strnavi;
				// 表示文字列
				$objPage->tpl_strnavi  = empty($strnavi) ? '&nbsp;' : $strnavi;
		
				// 規格1クラス名
				$objPage->tpl_class_name1  = $objProduct->className1;
		
				// 規格2クラス名
				$objPage->tpl_class_name2  = $objProduct->className2;
		
				// 規格1
				$objPage->arrClassCat1     = $objProduct->classCats1;
		
				// 規格1が設定されている
				$objPage->tpl_classcat_find1 = $objProduct->classCat1_find;
				// 規格2が設定されている
				$objPage->tpl_classcat_find2 = $objProduct->classCat2_find;
		
				$objPage->tpl_stock_find       = $objProduct->stock_find;
				$objPage->tpl_product_class_id = $objProduct->product_class_id;
				$objPage->tpl_product_type     = $objProduct->product_type;
					
		        $objPage->productStatus = $objPage->arrProducts['productStatus'];
        		unset($objPage->arrProducts['productStatus']);

				if(plg_AddSearchItem_Util::getECCUBEVer() >= 2130){
					$objPage->tpl_javascript .= 'eccube.productsClassCategories = ' . SC_Utils_Ex::jsonEncode($objProduct->classCategories) . ';';
					if (SC_Display_Ex::detectDevice() === DEVICE_TYPE_PC) {
						//onloadスクリプトを設定. 在庫ありの商品のみ出力する
						foreach ($objPage->arrProducts as $arrProduct) {
							if ($arrProduct['stock_unlimited_max'] || $arrProduct['stock_max'] > 0) {
								$js_fnOnLoad .= "fnSetClassCategories(document.product_form{$arrProduct['product_id']});";
							}
						}
					}
				}else{
					$objPage->tpl_javascript .= 'var productsClassCategories = ' . SC_Utils_Ex::jsonEncode($objProduct->classCategories) . ';';
					//onloadスクリプトを設定. 在庫ありの商品のみ出力する
					foreach ($objPage->arrProducts as $arrProduct) {
						if ($arrProduct['stock_unlimited_max'] || $arrProduct['stock_max'] > 0) {
							$js_fnOnLoad .= "fnSetClassCategories(document.product_form{$arrProduct['product_id']});";
						}
					}
				}
				
				$objPage->tpl_javascript   .= 'function fnOnLoad() {' . $js_fnOnLoad . '}';
				$objPage->tpl_onload       .= 'fnOnLoad(); ';
                break;
        }

    }
	
    /**
     * パラメーターの読み込み
     *
     * @return void
     */
    function lfGetDisplayNum($display_number) {
        // 表示件数
        $masterData                 = new SC_DB_MasterData_Ex();
        $arrPRODUCTLISTMAX    = $masterData->getMasterData('mtb_product_list_max');		
        return (SC_Utils_Ex::sfIsInt($display_number))
            ? $display_number
            : current(array_keys($arrPRODUCTLISTMAX));
    }
	
    /* 商品一覧の表示 */
    function lfGetProductsList($searchCondition, $disp_number, $startno, $linemax, $orderby, &$objProduct) {

        $arrOrderVal = array();

        $objQuery =& SC_Query_Ex::getSingletonInstance();
        // 表示順序
        switch ($orderby) {
            // 販売価格が安い順
            case 'price':
                $objProduct->setProductsOrder('price02', 'dtb_products_class', 'ASC');
                break;
			// 販売価格が高い順
            case 'price_desc':
                $objProduct->setProductsOrder('price02', 'dtb_products_class', 'DESC');
                break;

            // 新着順
            case 'date':
                $objProduct->setProductsOrder('create_date', 'dtb_products', 'DESC');
                break;
			case 'recommend':
                $order = <<< __EOS__
                    (
                        SELECT
                            (CASE WHEN AVG(T2.recommend_level) IS NULL THEN 0
							ELSE AVG(T2.recommend_level) END) as recommend_avg
                        FROM
                            dtb_review T2
						WHERE T2.product_id = alldtl.product_id AND T2.status = 1
						ORDER BY recommend_avg DESC
                        LIMIT 1
                    ) DESC
                    ,product_id DESC
__EOS__;
                	$objQuery->setOrder($order);
				break;
			case 'review':
                $order = <<< __EOS__
                    (
                        SELECT
							(CASE WHEN COUNT(T2.review_id) IS NULL THEN 0
							ELSE COUNT(T2.review_id) END) as review_cnt
                        FROM
                            dtb_review T2
						WHERE T2.product_id = alldtl.product_id AND T2.status = 1
						ORDER BY review_cnt DESC
                        LIMIT 1
                    ) DESC
                    ,product_id DESC
__EOS__;
                	$objQuery->setOrder($order);			
				break;
			case 'discount':
               $order = <<< __EOS__
                    (
                        SELECT
                            (CASE WHEN T2.price01 IS NULL THEN 0
							ELSE ABS(T2.price01 - T2.price02) / price01 END) as diff
                        FROM
                            dtb_products_class T2
                        WHERE T2.product_id = alldtl.product_id
                        ORDER BY diff DESC
                        LIMIT 1
                    ) DESC
                    ,product_id DESC
__EOS__;
                    $objQuery->setOrder($order);
				break;
				
			case 'quantity':
               $order = <<< __EOS__
                    (CASE WHEN EXISTS(
                        SELECT
                            SUM(T2.quantity) as quantity_sum
                        FROM
                            dtb_order_detail T2
							JOIN dtb_order T3
							ON T2.order_id = T3.order_id
                        WHERE T2.product_id = alldtl.product_id AND T3.del_flg = 0
						GROUP BY T2.product_id
                        ORDER BY quantity_sum DESC
                        LIMIT 1
                    ) 
					THEN 
					(
                        SELECT
                            SUM(T2.quantity) as quantity_sum
                        FROM
                            dtb_order_detail T2
							JOIN dtb_order T3
							ON T2.order_id = T3.order_id
                        WHERE T2.product_id = alldtl.product_id AND T3.del_flg = 0
						GROUP BY T2.product_id
                        ORDER BY quantity_sum DESC
                        LIMIT 1
                    )
					ELSE 0 END) DESC
                    ,product_id DESC
__EOS__;
                    $objQuery->setOrder($order);
				break;
				
			case 'sales':
               $order = <<< __EOS__
                    (CASE WHEN EXISTS(
                        SELECT
                            SUM(T2.quantity*T2.price) as sales_sum
                        FROM
                            dtb_order_detail T2
							JOIN dtb_order T3
							ON T2.order_id = T3.order_id
                        WHERE T2.product_id = alldtl.product_id AND T3.del_flg = 0
						GROUP BY T2.product_id
                        ORDER BY sales_sum DESC
                        LIMIT 1
                    ) 
					THEN 
					(
                        SELECT
                            SUM(T2.quantity*T2.price) as sales_sum
                        FROM
                            dtb_order_detail T2
							JOIN dtb_order T3
							ON T2.order_id = T3.order_id
                        WHERE T2.product_id = alldtl.product_id AND T3.del_flg = 0
						GROUP BY T2.product_id
                        ORDER BY sales_sum DESC
                        LIMIT 1
                    )
					ELSE 0 END) DESC
                    ,product_id DESC
__EOS__;
                    $objQuery->setOrder($order);
				break;
				

            default:
                if (strlen($searchCondition['where_category']) >= 1) {
                    $dtb_product_categories = '(SELECT * FROM dtb_product_categories WHERE '.$searchCondition['where_category'].')';
                    $arrOrderVal           = $searchCondition['arrvalCategory'];
                } else {
                    $dtb_product_categories = 'dtb_product_categories';
                }
				if(plg_AddSearchItem_Util::getECCUBEVer() >= 2132){
					$col = 'MAX(T3.rank * 2147483648 + T2.rank)';
					$from = "$dtb_product_categories T2 JOIN dtb_category T3 ON T2.category_id = T3.category_id";
					$where = 'T2.product_id = alldtl.product_id';
					$sub_sql = $objQuery->getSql($col, $from, $where);
	
					$objQuery->setOrder("($sub_sql) DESC ,product_id DESC");
				}else{
                	$order = <<< __EOS__
                    (
                        SELECT
                            T3.rank * 2147483648 + T2.rank
                        FROM
                            $dtb_product_categories T2
                            JOIN dtb_category T3
                              ON T2.category_id = T3.category_id
                        WHERE T2.product_id = alldtl.product_id
                        ORDER BY T3.rank DESC, T2.rank DESC
                        LIMIT 1
                    ) DESC
                    ,product_id DESC
__EOS__;
                    $objQuery->setOrder($order);
				}
                break;
        }
        // 取得範囲の指定(開始行番号、行数のセット)
        $objQuery->setLimitOffset($disp_number, $startno);
        $objQuery->setWhere($searchCondition['where']);

        // 表示すべきIDとそのIDの並び順を一気に取得
       	$arrProductId = $objProduct->findProductIdsOrder($objQuery, array_merge($searchCondition['arrval'], $arrOrderVal));

        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $arrProducts = $objProduct->getListByProductIds($objQuery, $arrProductId);

        // 規格を設定
        $objProduct->setProductsClassByProductIds($arrProductId);
        $arrProducts['productStatus'] = $objProduct->getProductStatus($arrProductId);

        return $arrProducts;
    }
	
    /**
     * 表示用検索条件の設定
     *
     * @return array
     */
    function lfGetSearchConditionDisp($arrSearchData) {
        $objQuery   =& SC_Query_Ex::getSingletonInstance();
        $arrSearch  = array('category' => '指定なし', 'maker' => '指定なし', 'name' => '指定なし');
        // カテゴリ検索条件
        if ($arrSearchData['category_id'] > 0) {
            $arrSearch['category']  = $objQuery->get('category_name', 'dtb_category', 'category_id = ?', array($arrSearchData['category_id']));
        }

        // メーカー検索条件
        if (strlen($arrSearchData['maker_id']) > 0) {
            $arrSearch['maker']     = $objQuery->get('name', 'dtb_maker', 'maker_id = ?', array($arrSearchData['maker_id']));
        }

        // 商品名検索条件
        if (strlen($arrSearchData['name']) > 0) {
            $arrSearch['name']      = $arrSearchData['name'];
        }
		
        // 在庫検索条件
        if (isset($arrSearchData['sf'])) {
            $arrSearch['sf']      = $arrSearchData['sf'];
        }
		
        // レビュー検索条件
        if (isset($arrSearchData['rf'])) {
            $arrSearch['rf']      = $arrSearchData['rf'];
        }
        // 送料無料
        if (isset($arrSearchData['fs'])) {
            $arrSearch['fs']      = $arrSearchData['fs'];
        }		
        // 価格帯検索条件
        if (is_numeric($arrSearchData['price_min'])) {
            $arrSearch['price_min']      = intval($arrSearchData['price_min']);
        }
        if (is_numeric($arrSearchData['price_max'])) {
            $arrSearch['price_max']      = intval($arrSearchData['price_max']);
        }
		
        // 商品ステータス検索条件
        $masterData = new SC_DB_MasterData_Ex();
        $arrSTATUS = $masterData->getMasterData('mtb_status');
        if ($arrSearchData['product_status_id']) {
			$arrSearch['product_status'] = '';
            foreach($arrSearchData['product_status_id'] as $value){
            	$arrSearch['product_status'] .= $arrSTATUS[$value] .",";
			}
			$arrSearch['product_status'] = rtrim($arrSearch['product_status'],',');
        }		
        return $arrSearch;
    }
	
    /**
     * 検索条件のwhere文とかを取得
     *
     * @return array
     */
    function lfGetSearchCondition($arrSearchData) {
        $searchCondition = array(
            'where'             => '',
            'arrval'            => array(),
            'where_category'    => '',
            'arrvalCategory'    => array()
        );

        // カテゴリからのWHERE文字列取得
        if ($arrSearchData['category_id'] != 0) {
            list($searchCondition['where_category'], $searchCondition['arrvalCategory']) = SC_Helper_DB_Ex::sfGetCatWhere($arrSearchData['category_id']);
        }
        // ▼対象商品IDの抽出
        // 商品検索条件の作成（未削除、表示）
        $searchCondition['where'] = 'alldtl.del_flg = 0 AND alldtl.status = 1 ';

        if (strlen($searchCondition['where_category']) >= 1) {
            $searchCondition['where'] .= ' AND EXISTS (SELECT * FROM dtb_product_categories WHERE ' . $searchCondition['where_category'] . ' AND product_id = alldtl.product_id)';
            $searchCondition['arrval'] = array_merge($searchCondition['arrval'], $searchCondition['arrvalCategory']);
        }

		$name_val_cnt = array();
		$search_fluctuation = plg_AddSearchItem_Util::getConfig("search_fluctuation");
        // 商品名をwhere文に
        $name = $arrSearchData['name'];
        $name = str_replace(',', '', $name);
        // 全角スペースを半角スペースに変換
        $name = str_replace('　', ' ', $name);
        // スペースでキーワードを分割
        $names = preg_split('/ +/', $name);
        // 分割したキーワードを一つずつwhere文に追加
		$name_where = ' AND ( alldtl.name ILIKE ? OR alldtl.comment3 ILIKE ?';
		$name_val_cnt[]=2;
		if($search_fluctuation == 1){
			$name_where .= ' OR alldtl.name ILIKE ? OR alldtl.comment3 ILIKE ?';
		}
		// 一覧コメント検索
		if(plg_AddSearchItem_Util::getConfig("search_list_comment")==1){
			$name_where .= ' OR alldtl.main_list_comment ILIKE ?';
			$name_val_cnt[]=1;
			if($search_fluctuation == 1){
				$name_where .= ' OR alldtl.main_list_comment ILIKE ?';
			}
		}
		// メインコメント検索
		if(plg_AddSearchItem_Util::getConfig("search_main_comment")==1){
			$name_where .= ' OR alldtl.main_comment ILIKE ?';
			$name_val_cnt[]=1;
			if($search_fluctuation == 1){
				$name_where .= ' OR alldtl.main_comment ILIKE ?';
			}
		}
		// サブコメント検索
		if(plg_AddSearchItem_Util::getConfig("search_sub_comment")==1){
			for($i=1;$i <= PRODUCTSUB_MAX; $i++){
				$name_where .= ' OR alldtl.sub_comment'.$i.' ILIKE ?';
			}
			$name_val_cnt[]=PRODUCTSUB_MAX;
			if($search_fluctuation == 1){
				for($i=1;$i <= PRODUCTSUB_MAX; $i++){
					$name_where .= ' OR alldtl.sub_comment'.$i.' ILIKE ?';
				}
			}
		}
		// 商品コード検索
		if(plg_AddSearchItem_Util::getConfig("search_product_code")==1){
			$name_where .= ' OR EXISTS(SELECT * FROM dtb_products_class WHERE product_id = alldtl.product_id AND del_flg = 0 AND (product_code ILIKE ?';
			$name_val_cnt[]=1;
			if($search_fluctuation == 1){
				$name_where .= ' OR product_code ILIKE ?';
			}
			$name_where .= '))';
		}
		// 規格名、規格分類名検索
		if(plg_AddSearchItem_Util::getConfig("search_classcategory")==1){			
			$name_where .= " OR EXISTS(SELECT pc1.*,pc2.* FROM dtb_products_class pc1 INNER JOIN dtb_classcategory cat1 ON pc1.classcategory_id1 = cat1.classcategory_id AND pc1.del_flg = '0' LEFT JOIN dtb_class class1 ON cat1.class_id = class1.class_id, dtb_products_class pc2 INNER JOIN dtb_classcategory cat2 ON pc2.classcategory_id2 = cat2.classcategory_id AND pc2.del_flg = '0' LEFT JOIN dtb_class class2 ON cat2.class_id = class2.class_id WHERE pc1.product_id = alldtl.product_id AND pc2.product_id = alldtl.product_id AND (cat1.name ILIKE ? OR cat2.name ILIKE ? OR class1.name ILIKE ? OR class2.name ILIKE ?";
			$name_val_cnt[]=4;
			if($search_fluctuation == 1){
				$name_where .= ' OR cat1.name ILIKE ? OR cat2.name ILIKE ? OR class1.name ILIKE ? OR class2.name ILIKE ?';
			}
			$name_where .= '))';
		}		
		$name_where .= ')';
        foreach ($names as $val) {
            if (strlen($val) > 0) {
				if($search_fluctuation==1){
					$val = mb_convert_kana($val,'askV');
					$lval = mb_convert_kana($val,'ASKV');
				}
                $searchCondition['where']    .= $name_where;
				foreach($name_val_cnt as $cnt){
					for($i=0;$i<$cnt;$i++){
                		$searchCondition['arrval'][]  = "%$val%";
					}
					if($search_fluctuation==1){
						for($i=0;$i<$cnt;$i++){
							$searchCondition['arrval'][]  = "%$lval%";
						}
					}
				}
            }
        }

        // メーカーらのWHERE文字列取得
        if ($arrSearchData['maker_id']) {
            $searchCondition['where']   .= ' AND alldtl.maker_id = ? ';
            $searchCondition['arrval'][] = $arrSearchData['maker_id'];
        }

        // 在庫無し商品の非表示
        if ($arrSearchData['sf'] == 1) {
            $searchCondition['where'] .= ' AND EXISTS(SELECT * FROM dtb_products_class WHERE product_id = alldtl.product_id AND del_flg = 0 AND (stock >= 1 OR stock_unlimited = 1))';
        }
		
		// レビューあり
        if ($arrSearchData['rf'] == 1) {
            $searchCondition['where'] .= ' AND EXISTS(SELECT * FROM dtb_review WHERE product_id = alldtl.product_id AND del_flg = 0)';
        }
		
		// 価格帯
        if (!is_null($arrSearchData['price_min']) && $arrSearchData['price_min'] != '' && is_numeric($arrSearchData['price_min'])) {
            $searchCondition['where'] .= ' AND EXISTS(SELECT * FROM dtb_products_class WHERE product_id = alldtl.product_id AND del_flg = 0 AND price02 >= ?)';
			$searchCondition['arrval'][] = $arrSearchData['price_min'];
        }
		
        if (!is_null($arrSearchData['price_max']) && $arrSearchData['price_max'] != '' && is_numeric($arrSearchData['price_max'])) {
            $searchCondition['where'] .= ' AND EXISTS(SELECT * FROM dtb_products_class WHERE product_id = alldtl.product_id AND del_flg = 0 AND price02 <= ?)';
			$searchCondition['arrval'][] = $arrSearchData['price_max'];
        }
		
        // 商品ステータス
        if ($arrSearchData['product_status_id'] && !empty($arrSearchData['product_status_id'][0])) {
			if(is_array($arrSearchData['product_status_id'])){
				$condition = plg_AddSearchItem_Util::getConfig('product_status_condition');
				if($condition == 1){
					$searchCondition['where'] .= " AND (";
					foreach($arrSearchData['product_status_id'] as $status_id){
						$searchCondition['where'] .= "EXISTS (SELECT * FROM dtb_product_status WHERE product_id = alldtl.product_id AND del_flg = '0' AND product_status_id = ". $status_id . ") AND ";
					}
					$searchCondition['where'] = rtrim($searchCondition['where'],' AND ');
					$searchCondition['where'] .= ")";
				}else{
					$whereProductStatus = implode(',',$arrSearchData['product_status_id']);
					$searchCondition['where'] .= " AND EXISTS (SELECT * FROM dtb_product_status WHERE product_status_id IN (" . $whereProductStatus . ") AND product_id = alldtl.product_id AND del_flg = '0')";
				}
			}
        }
		
		// 送料無料
        if ($arrSearchData['fs'] == 1) {
            $searchCondition['where'] .= ' AND EXISTS(SELECT * FROM dtb_products WHERE product_id = alldtl.product_id AND del_flg = 0 AND plg_freeshipping_flg = ?)';
			$searchCondition['arrval'][] = 1;
        }
		
		$searchCondition['where_for_count'] = $searchCondition['where'];

        return $searchCondition;
    }
}