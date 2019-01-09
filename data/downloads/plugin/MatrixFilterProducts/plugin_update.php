<?php
/*
 * 条件指定商品リスト・ブロック作成プラグイン
 * Copyright (C) 2015 colori
 * 
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
require_once(PLUGIN_UPLOAD_REALDIR.'MatrixFilterProducts/inc/include.php');

/**
 * プラグインのアップデートクラス
 *
 * @package MatrixFilterProducts
 * @author colori
 * @version $Id: $
 */
class plugin_update{

    /**
     *
     * アップデート
     * updateはアップデート時に実行されます。
     * 引数にはdtb_pluginのプラグイン情報が渡されます。
     * @param $arrPlugin
     */
    function update($arrPlugin){
	
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		if (ECCUBE_VERSION == '2.13.3') {
			$objQuery->begin();
		}
		$arrTables = $objQuery->listTables();
		$arrFields = $objQuery->listTableFields(PLG_MFP_FILTERDB);
		
		if (in_array(PLG_MFP_FILTERDB, $arrTables)!==false) {
			if (in_array('mfp_filter_or_connect', $arrFields)===false) {
				//フィルターテーブル末尾へ「mfp_filter_or_connect」カラムを追加
				$q = "ALTER TABLE ".PLG_MFP_FILTERDB." ADD mfp_filter_or_connect smallint default 0";
				$q .= ";";
				$objQuery->query($q);
			}
		} else {
			SC_Utils_Ex::sfDispSiteError(FREE_ERROR_MSG, '', false, "必要なデータベーステーブルがありません。プラグインをインストールしてください。");
			return false;
		}
		
		//初期設定ファイルに「データベースフィールド」「キャッシュ設定」の記述がない場合は追記する
		$inc_path = PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . "/inc/include.php";
		$add_code = "\ndefine('PLG_MFP_FILTER_VALUETYPE_DBFIELD',	4);\ndefine('PLG_MFP_CACHE_ENABLE', false);\ndefine('PLG_MFP_CACHE_LIFETIME', 3600);\ndefine('PLG_MFP_CACHE_DIR', PLUGIN_UPLOAD_REALDIR . 'MatrixFilterProducts/cache/');\n";
		$inc_str  = file_get_contents($inc_path);
		if (mb_strpos($inc_str, 'PLG_MFP_FILTER_VALUETYPE_DBFIELD') === false) {
			file_put_contents($inc_path, $add_code, FILE_APPEND);
		}
		
		// 変更ファイルの上書き
		self::update_copy($arrPlugin, "/plugin_info.php");
		self::update_copy($arrPlugin, "/plugin_update.php");
		self::update_copy($arrPlugin, "/MatrixFilterProducts.php");
		self::update_copy($arrPlugin, "/templates/config_filter.tpl");
		self::update_copy($arrPlugin, "/templates/plg_MatrixFilterProducts.tpl");
		self::update_copy($arrPlugin, "/class/pages/LC_Page_Plugin_MatrixFilterProducts_Config.php");
		self::update_copy($arrPlugin, "/media/");
		self::update_copy($arrPlugin, "/media/", "html");
		
		// cacheディレクトリの作成
		if (!is_dir(PLG_MFP_CACHE_DIR)) {
			mkdir(PLG_MFP_CACHE_DIR);
		}
		if (!is_writable(PLG_MFP_CACHE_DIR)) {
			chmod(PLG_MFP_CACHE_DIR, 0777);
		}
			
    }
	
	/**
	 * アップデート用一時ディレクトリからプラグインディレクトリへファイル/ディレクトリを上書きする
	 *
	 * @param array $arrPlugin プラグイン情報
	 * @param string $path プラグインディレクトリからの相対パス
	 * @param string $root コピーする先のルートディレクトリ（data, html）
	 * @return boolean
	 */
	function update_copy($arrPlugin, $path, $root="data") {
		$root_dir = ($root == "data") ? PLUGIN_UPLOAD_REALDIR : PLUGIN_HTML_REALDIR;
		if (is_file(DOWNLOADS_TEMP_PLUGIN_UPDATE_DIR . $path)) {
			copy(DOWNLOADS_TEMP_PLUGIN_UPDATE_DIR . $path, $root_dir . $arrPlugin['plugin_code'] . $path);
		} else {
			SC_Helper_FileManager_Ex::deleteFile($root_dir . $arrPlugin['plugin_code'] . $path);
			SC_Utils_Ex::sfCopyDir(DOWNLOADS_TEMP_PLUGIN_UPDATE_DIR . $path, $root_dir . $arrPlugin['plugin_code'] . $path);
		}
	}
	
}

