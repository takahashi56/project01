<?php
/*
 * MatrixFilterProducts
 * Copyright (C) 2013 colori All Rights Reserved.
 * http://colo-ri.jp/
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

// ディレクトリパス

// データベース
define('PLG_MFP_MASTERDB', 'plg_matrixfilterproducts_master');	//マスターデータ
define('PLG_MFP_FILTERDB', 'plg_matrixfilterproducts_filter');	//フィルターデータ

// 定数
define('PLG_MFP_ORDER_DIRECTION_ASC',	2);		//昇順
define('PLG_MFP_ORDER_DIRECTION_DESC',	1);		//降順

define('PLG_MFP_ORDER_DIMENSION_SALES',		1);	//売上額
define('PLG_MFP_ORDER_DIMENSION_CREATE',	2);	//作成日
define('PLG_MFP_ORDER_DIMENSION_UPDATE',	3);	//更新日
define('PLG_MFP_ORDER_DIMENSION_RANDOM',	4);	//ランダム
define('PLG_MFP_ORDER_DIMENSION_SOLD',		5);	//購入数

define('PLG_MFP_NUM_DEFAULT', 5);		//初期表示件数
define('PLG_MFP_NUM_SALESDAYS', 3650);	//売上の測定日数（過去何日分を調べるか）
define('PLG_MFP_NUM_SOLDDAYS', 3650);		//購入数の測定日数（過去何日分を調べるか）
define('PLG_MFP_ORDER_CANCEL_STATUS', 3);		//受注キャンセルのステータスID（店舗ごとに異なる場合があるので調整してください）

define('PLG_MFP_FILTER_TARGET_CATEGORY_ID', 1);		//フィルターターゲット：カテゴリーID
define('PLG_MFP_FILTER_TARGET_CATEGORY_NAME', 2);	//フィルターターゲット：カテゴリー名
define('PLG_MFP_FILTER_TARGET_STATUS_ID', 3);		//フィルターターゲット：商品ステータスID
define('PLG_MFP_FILTER_TARGET_PRODUCT_CODE', 4);	//フィルターターゲット：商品コード
define('PLG_MFP_FILTER_TARGET_MAKER_URL', 5);		//フィルターターゲット：メーカーURL
define('PLG_MFP_FILTER_TARGET_NOTE', 6);			//フィルターターゲット：備考欄(SHOP専用)

define('PLG_MFP_FILTER_COND_EQUAL',	1);				//フィルター条件：等しい
define('PLG_MFP_FILTER_COND_LIKE', 2);				//フィルター条件：含む
define('PLG_MFP_FILTER_COND_NOTLIKE', 3);				//フィルター条件：含まない
define('PLG_MFP_FILTER_COND_REGEXP', 4);				//フィルター条件：正規表現
define('PLG_MFP_FILTER_COND_NOTREGEXP', 5);				//フィルター条件：正規表現（否定）

define('PLG_MFP_FILTER_VALUETYPE_DEFAULT', 	1);		//規定値
define('PLG_MFP_FILTER_VALUETYPE_CUSTOM', 	2);		//カスタム値
define('PLG_MFP_FILTER_VALUETYPE_URL', 		3);		//URLパラメーター
define('PLG_MFP_FILTER_VALUETYPE_DBFIELD',	4);		//データベースフィールド

define('PLG_MFP_FILTER_VALUE_CATEGORY_ID', 'category_id');
define('PLG_MFP_FILTER_VALUE_STATUS_ID', 'status_id');
define('PLG_MFP_FILTER_VALUE_PRODUCT_ID', 'product_id');

define('PLG_MFP_IGNORE_CURRENT_PRODUCT', 1);		// 商品単独ページ内に表示させる際、その商品を無視するかどうか

define('PLG_MFP_CACHE_ENABLE', false);				// キャッシュシステムを有効にするかどうか
define('PLG_MFP_CACHE_LIFETIME', 86400);			// キャッシュの有効期限
define('PLG_MFP_CACHE_DIR', PLUGIN_UPLOAD_REALDIR . 'MatrixFilterProducts/cache/');				// キャッシュディレクトリ