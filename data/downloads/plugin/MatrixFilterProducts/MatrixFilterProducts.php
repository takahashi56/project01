<?php
/*
 * 条件指定商品リスト・ブロック作成プラグイン
 * Copyright (C) 2013 colori
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
 * プラグインのメインクラス
 *
 * @package MatrixFilterProducts
 * @author colori
 * @version $Id: $
 */
class MatrixFilterProducts extends SC_Plugin_Base {
	
	private static $arrDimensionName_ = array(
		PLG_MFP_ORDER_DIMENSION_SALES	=>'売上',
		PLG_MFP_ORDER_DIMENSION_SOLD	=>'購入数',
		PLG_MFP_ORDER_DIMENSION_CREATE	=>'作成日',
		PLG_MFP_ORDER_DIMENSION_UPDATE	=>'更新日',
		PLG_MFP_ORDER_DIMENSION_RANDOM	=>'ランダム'
	);
	
	private static $arrDirectionName_ = array(
		PLG_MFP_ORDER_DIRECTION_DESC	=>'降順',
		PLG_MFP_ORDER_DIRECTION_ASC		=>'昇順'
	);
	
	private static $arrTargetName_ = array(
		PLG_MFP_FILTER_TARGET_CATEGORY_ID	=> 'カテゴリーID',
		PLG_MFP_FILTER_TARGET_CATEGORY_NAME	=> 'カテゴリー名',
		PLG_MFP_FILTER_TARGET_STATUS_ID		=> '商品ステータス',
		PLG_MFP_FILTER_TARGET_PRODUCT_CODE  => '商品コード',
		PLG_MFP_FILTER_TARGET_MAKER_URL		=> 'メーカーURL',
		PLG_MFP_FILTER_TARGET_NOTE			=> '備考欄(SHOP専用)',
	);
	
	private static $arrConditionName_ = array(
		PLG_MFP_FILTER_COND_EQUAL	=> '等しい',
		PLG_MFP_FILTER_COND_LIKE	=> '含む',
		PLG_MFP_FILTER_COND_NOTLIKE => '含まない',
		PLG_MFP_FILTER_COND_REGEXP  => '正規表現',
		PLG_MFP_FILTER_COND_NOTREGEXP  => '正規表現（否定）',
	);
	
	private static $arrFilterValuetypeName_ = array(
		PLG_MFP_FILTER_VALUETYPE_DEFAULT	=> '規定値',
		PLG_MFP_FILTER_VALUETYPE_CUSTOM		=> 'カスタム値',
		PLG_MFP_FILTER_VALUETYPE_URL		=> 'URLパラメーター',
		PLG_MFP_FILTER_VALUETYPE_DBFIELD	=> 'データベース',
	);
	
	private static $arrFilterValueUrlName_ = array(
		PLG_MFP_FILTER_VALUE_CATEGORY_ID	=> 'カテゴリーID',
		PLG_MFP_FILTER_VALUE_STATUS_ID		=> '商品ステータスID',
		PLG_MFP_FILTER_VALUE_PRODUCT_ID		=> '商品ID'
	);
	
    /**
     * コンストラクタ
     */
    public function __construct(array $arrSelfInfo) {
        parent::__construct($arrSelfInfo);
    }

	/**
	 * プラグインデータを取得
	 *
	 * @return array プラグインデータハッシュ
	 */
	function getPluginData() {
		return SC_Plugin_Util_Ex::getPluginByPluginCode('MatrixFilterProducts');
	}
	
    /**
     * インストール
     * installはプラグインのインストール時に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin plugin_infoを元にDBに登録されたプラグイン情報(dtb_plugin)
     * @return void
     */
    function install($arrPlugin) {
		//ファイルコピー
		copy(PLUGIN_UPLOAD_REALDIR . "MatrixFilterProducts/logo.png", PLUGIN_HTML_REALDIR . "MatrixFilterProducts/logo.png");
		copy(PLUGIN_UPLOAD_REALDIR . "MatrixFilterProducts/bloc/plg_MatrixFilterProducts.php", 		HTML_REALDIR     . "frontparts/bloc/plg_MatrixFilterProducts.php");
		mkdir(PLUGIN_HTML_REALDIR . "MatrixFilterProducts/media");
		SC_Utils_Ex::sfCopyDir(PLUGIN_UPLOAD_REALDIR . "MatrixFilterProducts/media/", PLUGIN_HTML_REALDIR . "MatrixFilterProducts/media/");
		@chmod(PLUGIN_DATA_REALDIR . "MatrixFilterProducts", 0777);
		
		// cacheディレクトリの作成
		$cacheDir = PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . "/cache/";
		if (!is_dir($cacheDir)) {
			mkdir($cacheDir);
		}
		if (!is_writable($cacheDir)) {
			chmod($cacheDir, 0777);
		}
		
		//データベース作成
		self::createDB();
    }


    /**
     * アンインストール
     * uninstallはアンインストール時に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    function uninstall($arrPlugin) {
        SC_Helper_FileManager_Ex::deleteFile(TEMPLATE_REALDIR . "frontparts/bloc/plg_MatrixFilterProducts.tpl");
        SC_Helper_FileManager_Ex::deleteFile(HTML_REALDIR  . "frontparts/bloc/plg_MatrixFilterProducts.php");
        SC_Helper_FileManager_Ex::deleteFile(PLUGIN_HTML_REALDIR . "MatrixFilterProducts/logo.png");
        SC_Helper_FileManager_Ex::deleteFile(PLUGIN_HTML_REALDIR . "MatrixFilterProducts");
		
		//データベース削除
		self::deleteDB();
    }

	/**
	 * データベースの作成
	 *
	 */
	function createDB() {
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$arrTables = $objQuery->listTables();
		
		//マスターテーブル
		if (in_array(PLG_MFP_MASTERDB, $arrTables)===false) {
			$q = "CREATE TABLE ".PLG_MFP_MASTERDB." (
				mfp_id				int not null,
				mfp_bloc_id			int not null,
				mfp_device_type_id	int not null,
				mfp_bloc_name		varchar(255) not null,
				mfp_bloc_elementid	varchar(255) not null,
				mfp_bloc_title		varchar(255) default '',
				mfp_bloc_exp		text default '',
				mfp_num				int not null,
				mfp_order_direction	smallint not null,
				mfp_order_dimension	smallint not null,
				mfp_disp_random		smallint default 0,
				mfp_image_width 	int not null,
				mfp_image_height	int not null,
				PRIMARY KEY(mfp_id),
				UNIQUE(mfp_bloc_id, mfp_device_type_id),
				UNIQUE(mfp_bloc_elementid)
			)";
			if (DB_TYPE == "mysql") $q .= " ENGINE=InnoDB";
			$q .= ";";
			$objQuery->query($q);
		}
		
		//フィルターテーブル
		if (in_array(PLG_MFP_FILTERDB, $arrTables)===false) {
			$q = "CREATE TABLE ".PLG_MFP_FILTERDB." (
				mfp_filter_id			int not null,
				mfp_id					int not null,
				mfp_filter_target		smallint not null,
				mfp_filter_condition	smallint not null,
				mfp_filter_valuetype	smallint not null,
				mfp_filter_value		varchar(255) not null,
				mfp_filter_except_self	smallint default 0,
				mfp_filter_or_connect   smallint default 0,
				PRIMARY KEY(mfp_filter_id)
			)";
			if (DB_TYPE == "mysql") $q .= " ENGINE=InnoDB";
			$q .= ";";
			$objQuery->query($q);
			$q = "CREATE INDEX mfp_id ON ".PLG_MFP_FILTERDB."(mfp_id);";
			$objQuery->query($q);
		}
	}
	
	/**
	 * データベースの削除
	 *
	 */
	function deleteDB() {
		// 関連テーブルを削除
        $objQuery =& SC_Query_Ex::getSingletonInstance();
		
		$arrTables = $objQuery->listTables();
		$dropTables = array(
			PLG_MFP_MASTERDB,
			PLG_MFP_FILTERDB
		);
		
		if (in_array(PLG_MFP_MASTERDB, $arrTables)!==false) {
			//プラグインで作成したブロックリストを抽出
			$masterAll = $objQuery->select('*', PLG_MFP_MASTERDB, "", array());
			foreach($masterAll as $master) {
				$where       = 'device_type_id = ? AND bloc_id = ?';
				$arrWhereVal = array($master['mfp_device_type_id'], $master['mfp_bloc_id']);
				$objQuery->delete('dtb_bloc', $where, $arrWhereVal);
				$objQuery->delete('dtb_bloc', $where, $arrWhereVal);
			}
		}
		foreach($dropTables as $tbl) {
			if (in_array($tbl, $arrTables)!==false) {
				$objQuery->query("DROP TABLE {$tbl}");
			}
		}
	}
	
    /**
     * 稼働
     * enableはプラグインを有効にした際に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    function enable($arrPlugin) {
        // nop
    }

    /**
     * 停止
     * disableはプラグインを無効にした際に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     *
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    function disable($arrPlugin) {
        // nop
    }

    /**
     * 処理の介入箇所とコールバック関数を設定
     * registerはプラグインインスタンス生成時に実行されます
     *
     * @param SC_Helper_Plugin $objHelperPlugin
     */
    function register(SC_Helper_Plugin $objHelperPlugin) {
		//SC_Utils_Ex::clearCompliedTemplate();
        return parent::register($objHelperPlugin, $priority);
    }

	/**
	 * ブロックデータリストを返す
	 *
	 * @param array ブロックデータリスト
	 */
	function getBlocList() {
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$cols  = '*';
		$table = PLG_MFP_MASTERDB.',dtb_bloc';
		$where = PLG_MFP_MASTERDB.'.mfp_bloc_id = dtb_bloc.bloc_id AND ' . 
		         PLG_MFP_MASTERDB.'.mfp_device_type_id = dtb_bloc.device_type_id';
		return $objQuery->select($cols, $table, $where, array());
	}
	
	/**
	 * ブロックデータを返す
	 *
	 * @param integer $mfp_id 主キーID
	 * @return array ブロックデータ
	 */
	function getBlocFromId($mfp_id) {
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$cols  = '*';
		$table = PLG_MFP_MASTERDB.',dtb_bloc';
		$where = PLG_MFP_MASTERDB.'.mfp_bloc_id = dtb_bloc.bloc_id AND ' . 
		         PLG_MFP_MASTERDB.'.mfp_device_type_id = dtb_bloc.device_type_id AND ' . 
				 PLG_MFP_MASTERDB.'.mfp_id = ?';
		$result = $objQuery->select($cols, $table, $where, array($mfp_id));
		return count($result) ? $result[0] : array();
	}
	
	/**
	 * ブロックデータを返す
	 *
	 * @param integer $bloc_id ブロックID
	 * @param integer $device_type_id デバイスタイプID
	 * @return array ブロックデータ
	 */
	function getBlocFromBlocInfo($bloc_id, $device_type_id) {
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$cols  = '*';
		$table = PLG_MFP_MASTERDB.',dtb_bloc';
		$where = PLG_MFP_MASTERDB.'.mfp_bloc_id = dtb_bloc.bloc_id AND ' . 
		         PLG_MFP_MASTERDB.'.mfp_device_type_id = dtb_bloc.device_type_id AND ' . 
				 'dtb_bloc.bloc_id = ? AND dtb_bloc.device_type_id = ?';
		$result = $objQuery->select($cols, $table, $where, array($bloc_id, $device_type_id));
		return count($result) ? $result[0] : array();
	}
	
	/**
	 * 新しいブロックIDを取得
	 *
	 * @access public
	 * @param integer $device_type_id デバイスタイプID
	 * @return integer
	 */
	function getNewBlockId($device_type_id) {
		$objQuery = SC_Query_Ex::getSingletonInstance();
		return $objQuery->max('bloc_id', "dtb_bloc", "device_type_id = " . $device_type_id) + 1;
	}
	
	/**
	 * デバイスタイプIDからテンプレートディレクトリパスを返す
	 *
	 * @access public
	 * @param integer $device_type_id デバイスタイプID
	 * @return string
	 */
	function getTemplatePathByDevice($device_type_id) {
		switch ($device_type_id) {
			case DEVICE_TYPE_PC:
				return TEMPLATE_REALDIR;
			case DEVICE_TYPE_SMARTPHONE:
				return SMARTPHONE_TEMPLATE_REALDIR;
			case DEVICE_TYPE_MOBILE:
				return MOBILE_TEMPLATE_REALDIR;
			default:
				return DEVICE_TYPE_PC;
		}
	}
	
	/**
	 * ブロックを更新
	 * ブロックIDがなければ新規追加、ブロックIDがあればアップデートする
	 *
	 * @param array $arrForm フォームデータ
	 */
    function updateBloc($arrForm) {
        
        $objQuery = SC_Query_Ex::getSingletonInstance();
		$arrValues = $objQuery->extractOnlyColsOf(PLG_MFP_MASTERDB, $arrForm);
		$arrPlugin = self::getPluginData();
		
		//データの補完
		if (!$arrValues['mfp_image_width']) {
			$arrValues['mfp_image_width'] =  SMALL_IMAGE_WIDTH;
		}
		if (!$arrValues['mfp_image_height']) {
			$arrValues['mfp_image_height'] =  SMALL_IMAGE_HEIGHT;
		}
		
		//現在の値を（あれば）取得
		$mfp_bloc_elementid = $arrValues['mfp_bloc_elementid'];
		$dataByElementId = $objQuery->getRow('*', PLG_MFP_MASTERDB, 'mfp_bloc_elementid=?', array($mfp_bloc_elementid));
		$device_type_id =  $arrValues['mfp_device_type_id'];
		
		//追加
		if (!$arrValues['mfp_id']) {
			$bloc_id = self::getNewBlockId($device_type_id);
			$mfp_id  = $objQuery->max('mfp_id', PLG_MFP_MASTERDB) + 1;
			
			//テンプレートを作成
			if ($dataByElementId) {
				return '入力されたID名はすでに使われています。';
			}
			$filename = "plg_MatrixFilterProducts_{$mfp_bloc_elementid}";
			$filepath = self::getTemplatePathByDevice($device_type_id) . "frontparts/bloc/{$filename}.tpl";
			copy(PLUGIN_UPLOAD_REALDIR . "MatrixFilterProducts/templates/plg_MatrixFilterProducts.tpl",	$filepath);
			// dtb_blocにブロックを追加する.
			$sqlval_bloc = array();
			$sqlval_bloc['device_type_id'] = $arrValues['mfp_device_type_id'];
			$sqlval_bloc['bloc_id'] = $bloc_id;
			$sqlval_bloc['bloc_name'] = $arrValues['mfp_bloc_name'];
			$sqlval_bloc['tpl_path'] = $filename.".tpl";
			$sqlval_bloc['filename'] = $filename;
			$sqlval_bloc['create_date'] = "CURRENT_TIMESTAMP";
			$sqlval_bloc['update_date'] = "CURRENT_TIMESTAMP";
			$sqlval_bloc['php_path'] = "frontparts/bloc/plg_MatrixFilterProducts.php";
			$sqlval_bloc['deletable_flg'] = 0;
			$sqlval_bloc['plugin_id'] = $arrPlugin['plugin_id'];
			$objQuery->insert("dtb_bloc", $sqlval_bloc);
			//マスターデータ追加
			$arrValues['mfp_id']      = $mfp_id;
			$arrValues['mfp_bloc_id'] = $bloc_id;
			$objQuery->insert(PLG_MFP_MASTERDB, $arrValues);
			
		//更新
		} else {
			$mfp_id = $arrForm['mfp_id'];
			$bloc_id = $arrForm['mfp_bloc_id'];
			
			$nowData = $objQuery->getRow('*', PLG_MFP_MASTERDB, 'mfp_id=?', array($mfp_id));
			
			$arrBlocVal = array(
				'bloc_name'=>$arrForm['mfp_bloc_name'],
				'device_type_id'=>$device_type_id,
			);
			
			if ($dataByElementId and $mfp_id != $dataByElementId['mfp_id']) {
				return '入力されたID名はすでに使われています。';
			//ID名が異なっているか、デバイスタイプが異なっていたらテンプレートファイル・ファイル情報を変更する。
			} else if (($nowData['mfp_bloc_elementid'] != $mfp_bloc_elementid) or ($nowData['mfp_device_type_id'] != $device_type_id)) {
				$filename = "plg_MatrixFilterProducts_{$mfp_bloc_elementid}";
				$new_filepath = self::getTemplatePathByDevice($device_type_id) . "frontparts/bloc/{$filename}.tpl";
				$old_filepath = self::getTemplatePathByDevice($nowData['mfp_device_type_id']) . "frontparts/bloc/plg_MatrixFilterProducts_".$nowData['mfp_bloc_elementid'].".tpl";
				rename($old_filepath, $new_filepath);
				$arrBlocVal['tpl_path'] = $filename.".tpl";
				$arrBlocVal['filename'] = $filename;
			}
			
			$where = "bloc_id = ? AND device_type_id = ?";
			$arrWhereVal = array($nowData['mfp_bloc_id'], $nowData['mfp_device_type_id']);
			
			//デバイスタイプが異なっていたら、配置されたレイアウト情報を削除し、新しいブロックIDを取得
			if ($nowData['mfp_device_type_id'] != $device_type_id) {
				$objQuery->delete("dtb_blocposition", $where, $arrWhereVal);
				$bloc_id = self::getNewBlockId($device_type_id);
				$arrBlocVal['bloc_id'] = $bloc_id;
				$arrValues['mfp_bloc_id'] = $bloc_id;
			}
			
			//ブロック更新
			$objQuery->update('dtb_bloc', $arrBlocVal, $where, $arrWhereVal);
			
			$sqlval = array();
			foreach($arrValues as $k=>$val) {
				$sqlval[$k] = $val;
			}
			$objQuery->update(PLG_MFP_MASTERDB, $sqlval, 'mfp_id = ?', array($mfp_id));
		}
    }

	/**
	 * ブロックをDBから削除
	 * 利用されているページレイアウトからも除去します
	 *
	 * @param array $arrForm フォームデータ
	 * @return string エラーメッセージ
	 */
	function deleteBloc($arrForm) {
		$mfp_id  = $arrForm['mfp_id'];
		$bloc = self::getBlocFromId($mfp_id);
		if (!$bloc) return 'データの削除に失敗しました。';
		
		$objQuery = SC_Query_Ex::getSingletonInstance();
		
		//関連のブロックを削除
        $where = "bloc_id = ? AND device_type_id = ?";
		$arrWhereVal = array($bloc['bloc_id'], $bloc['device_type_id']);
        $objQuery->delete("dtb_bloc", $where, $arrWhereVal);
        $objQuery->delete("dtb_blocposition", $where, $arrWhereVal);
		
		//マスターデータ、フィルターデータを削除
		$where = "mfp_id = ?";
		$arrWhereVal = array($mfp_id);
		$objQuery->delete(PLG_MFP_MASTERDB, $where, $arrWhereVal);
        $objQuery->delete(PLG_MFP_FILTERDB, $where, $arrWhereVal);
		
		//テンプレートファイルを削除
		SC_Helper_FileManager_Ex::deleteFile(self::getTemplatePathByDevice($bloc['device_type_id']) . "frontparts/bloc/".$bloc['tpl_path']);
		return '';
	}


	/**
	 * フィルターデータリストを返す
	 *
	 * @param integer $mfp_filter_id フィルターID
	 * @return array
	 */
	function getFilterList($mfp_filter_id) {
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		return $objQuery->select('*', PLG_MFP_FILTERDB, "mfp_id = ?", array($mfp_filter_id));
	}
	
	/**
	 * マスターIDをキーにした全フィルターリストを返す
	 *
	 * @return array
	 */
	function getAllFilterList() {
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$result = $objQuery->select('*', PLG_MFP_FILTERDB, "", array());
		$allFilterList = array();
		foreach($result as $arrFilter) {
			$mfp_id = $arrFilter['mfp_id'];
			if (!isset($allFilterList[$mfp_id])) {
				$allFilterList[$mfp_id] = array();
			}
			$allFilterList[$mfp_id][] = $arrFilter;
		}
		return $allFilterList;
	}
	
	/**
	 * フィルターデータを返す
	 *
	 * @param integer $mfp_filter_id フィルターID
	 * @return array フィルターデータ
	 */
	function getFilterFromId($mfp_filter_id) {
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$result = $objQuery->select('*', PLG_MFP_FILTERDB, 'mfp_filter_id = ?', array($mfp_filter_id));
		return count($result) ? $result[0] : array();
	}
	
	/**
	 * フィルターを追加
	 *
	 * @param array $arrForm フォームデータ
	 */
	function updateFilter($arrForm) {
		
        $objQuery = SC_Query_Ex::getSingletonInstance();
		$arrValues = $objQuery->extractOnlyColsOf(PLG_MFP_FILTERDB, $arrForm);
		
		//追加
		if (!$arrValues['mfp_filter_id']) {
			$arrValues['mfp_filter_id']  = $objQuery->max('mfp_filter_id', PLG_MFP_FILTERDB) + 1;
			$objQuery->insert(PLG_MFP_FILTERDB, $arrValues);
		//更新
		} else {
			$mfp_filter_id = $arrForm['mfp_filter_id'];
			$sqlval = array();
			foreach($arrValues as $k=>$val) {
				$sqlval[$k] = $val;
			}
			$objQuery->update(PLG_MFP_FILTERDB, $sqlval, 'mfp_filter_id = ?', array($mfp_filter_id));
		}
	}
	
	/**
	 * フィルターを削除
	 *
	 * @param array $arrForm フォームデータ
	 */
	function deleteFilter($arrForm) {
		$mfp_filter_id  = $arrForm['mfp_filter_id'];
		
		$objQuery = SC_Query_Ex::getSingletonInstance();
		
		//マスターデータ、フィルターデータを削除
		$where = "mfp_filter_id = ?";
		$arrWhereVal = array($mfp_filter_id);
        $objQuery->delete(PLG_MFP_FILTERDB, $where, $arrWhereVal);
		return '';
	}
	
	/**
	 * マスターデータを元に追加クエリを生成する
	 *
	 * @param array  $bloc マスターデータ
	 * @param array  $cols
	 * @param array  $tables
	 * @param string $where
	 * @param array  $arrWhereVal
	 * @param array  $groups
	 */
	function mergeQueryFromMaster($bloc, &$objQuery, &$cols, &$tables, &$where, &$arrWhereVal, &$groups) {
		//制限
		$objQuery->setOption("LIMIT ".intval($bloc['mfp_num']));	
		//ソート
		switch ($bloc['mfp_order_dimension']) {
			//売上
			case PLG_MFP_ORDER_DIMENSION_SALES:
				$cols[] = "SUM(dtb_order_detail.price * dtb_order_detail.quantity) AS sales";
				$tables[] = 'dtb_order';
				$tables[] = 'dtb_order_detail';
				$where .= " AND dtb_order.del_flg = 0 AND ";
				if (DB_TYPE != 'pgsql') { 
				          $where .= "DATE_ADD(dtb_order.create_date, INTERVAL ".PLG_MFP_NUM_SALESDAYS." DAY) > NOW() AND ";
				} else {
				          $where .= "dtb_order.create_date + INTERVAL '".PLG_MFP_NUM_SALESDAYS." DAY' > NOW() AND ";
				}
				          $where .= "dtb_order.order_id = dtb_order_detail.order_id AND " . 
						  "dtb_order.status != " . PLG_MFP_ORDER_CANCEL_STATUS ." AND ".
						  "dtb_order_detail.product_id = dtb_products.product_id"; 
				$order_str = 'sales';
				break;
			//購入数
			case PLG_MFP_ORDER_DIMENSION_SOLD:
				$cols[] = "COUNT(dtb_products.product_id) AS sold";
				$tables[] = 'dtb_order';
				$tables[] = 'dtb_order_detail';
				$where .= " AND dtb_order.del_flg = 0 AND ";
				if (DB_TYPE != 'pgsql') { 
				          $where .= "DATE_ADD(dtb_order.create_date, INTERVAL ".PLG_MFP_NUM_SOLDDAYS." DAY) > NOW() AND ";
				} else {
				          $where .= "dtb_order.create_date + INTERVAL '".PLG_MFP_NUM_SOLDDAYS." DAY' > NOW() AND ";
				}
				          $where .= "dtb_order.order_id = dtb_order_detail.order_id AND " . 
						  "dtb_order.status != " . PLG_MFP_ORDER_CANCEL_STATUS ." AND ".
						  "dtb_order_detail.product_id = dtb_products.product_id"; 
				$order_str = 'sold';
				break;
			//作成日
			case PLG_MFP_ORDER_DIMENSION_CREATE:
				$order_str = 'dtb_products.create_date';
				array_push($groups, 'dtb_products.create_date');
				break;
			//更新日
			case PLG_MFP_ORDER_DIMENSION_UPDATE:
				$order_str = 'dtb_products.update_date';
				array_push($groups, 'dtb_products.update_date');
				break;
			//ランダム
			case PLG_MFP_ORDER_DIMENSION_RANDOM:
				$order_str = (DB_TYPE == 'pgsql') ? 'RANDOM()' : 'RAND()';
				break;
			default:
				break;
		}
		if ($bloc['mfp_order_dimension'] != PLG_MFP_ORDER_DIMENSION_RANDOM) {
			$order_str .= ($bloc['mfp_order_direction'] == PLG_MFP_ORDER_DIRECTION_ASC) ? ' ASC' : ' DESC';
		}
		$objQuery->setOrder($order_str);
	}
	
	/**
	 * 正規表現用の評価文字列を取得
	 */
	function regexp_str() {
		return (DB_TYPE == 'mysql') ? 'REGEXP' : '~';
	}
	
	function regexp_not_str() {
		return (DB_TYPE == 'mysql') ? 'NOT REGEXP' : '!~';
	}
	
	/**
	 * フィルターデータを元に追加クエリを生成する
	 *
	 * @param array  $filter フィルターデータ
	 * @param array  $tables
	 * @param string $where
	 * @param array  $arrWhereVal
	 */
	function mergeQueryFromFilter($filter, &$tables, &$where, &$arrWhereVal, &$join_tables, &$join_where, &$filter_static_vars) {
				
		$target      = $filter['mfp_filter_target'];
		$condition   = $filter['mfp_filter_condition'];
		$valuetype   = $filter['mfp_filter_valuetype'];
		$value       = $filter['mfp_filter_value'];
		$except_self = $filter['mfp_filter_except_self'];
		$or_connect  = $filter['mfp_filter_or_connect'];
		
		$or_connect_str  = &$filter_static_vars['or_connect_str'];
		$last			 = $filter_static_vars['last'];

		//グループ化がチェックされている場合
		if ($or_connect) {
			if (!$or_connect_str) {
				$or_connect_str = ($last) ? '' : '┓';
			} else {
				if ($last) {
					$or_connect_str = ($or_connect_str != '┛') ? '┛' : '';
				} else {
					$or_connect_str = ($or_connect_str == '┛') ? '┓' : '┃';
				}
			}
			
		//グループ化がチェックされていない場合
		} else {
			if ($or_connect_str) {
				if ($last) {
					$or_connect_str = ($or_connect_str != '┛') ? '┛' : '';
				} else {
					$or_connect_str = '┛';
				}
			} else {
				$or_connect_str = '';
			}
		}
			
		//グルーピングSQL
		if ($or_connect_str == '┓') {
			$where .= '(';
		}
				
		//カテゴリーID指定
		if ($target == PLG_MFP_FILTER_TARGET_CATEGORY_ID) {
			$val = ($valuetype == PLG_MFP_FILTER_VALUETYPE_URL) ? $_GET[$value] : $value;
			
			if ($value != PLG_MFP_FILTER_VALUE_PRODUCT_ID) {
				$arrCatids = SC_Helper_DB_Ex::sfGetChildrenArray('dtb_category','parent_category_id','category_id', $val);
			//商品IDが指定されている場合は、商品IDが属するカテゴリーIDを元にカテゴリーIDリストを得る
			} else {
				$tmpArrCat = self::getProductCategories(array($val));
				$arrProductCat = $tmpArrCat[$val];
				$arrCatids = array_merge($arrProductCat, SC_Helper_DB_Ex::sfGetChildrenArraySub('dtb_category','parent_category_id','category_id', $arrProductCat));
			}
			
			$tblname = "dtb_product_categories";
			if (!in_array("dtb_product_categories", $tables)) {
				$tables[] = $tblname;
			}
			$where .= "(dtb_products.product_id = {$tblname}.product_id AND ";
			$where .= "{$tblname}.category_id IN (" . SC_Utils_Ex::repeatStrWithSeparator('?', count($arrCatids)) . '))';
			
			
			//ページの商品を除外
			if ($valuetype == PLG_MFP_FILTER_VALUETYPE_URL and $value == 'product_id' and $except_self) {
				$where .= " AND dtb_products.product_id != ?";
			}
		//カテゴリー名指定
		} else if ($target == PLG_MFP_FILTER_TARGET_CATEGORY_NAME) {
			//すでにテーブルが追加されていたら、別名テーブルにする
			if (in_array("dtb_product_categories", $tables)) {
				$tblname = "dpc".count($tables);
				$tables[] = "dtb_product_categories {$tblname}";
			} else {
				$tblname = "dtb_product_categories";
				$tables[] = $tblname;
			}
			$tables[] = "dtb_category";
			$where .= "dtb_products.product_id = {$tblname}.product_id";
			$where .= " AND {$tblname}.category_id = dtb_category.category_id";
			//含む
			if ($condition == PLG_MFP_FILTER_COND_LIKE) {
				$where .= " AND dtb_category.category_name LIKE ?";
			//含まない
			} else if ($condition == PLG_MFP_FILTER_COND_NOTLIKE) {
				$where .= " AND dtb_category.category_name LIKE ?";
			//正規表現
			} else if ($condition == PLG_MFP_FILTER_COND_REGEXP) {
				$where .= " AND dtb_category.category_name ".self::regexp_str()." ?";
			//正規表現（否定）
			} else if ($condition == PLG_MFP_FILTER_COND_NOTREGEXP) {
				$where .= " AND dtb_category.category_name ".self::regexp_not_str()." ?";
			//等しい
			} else {
				$where .= " AND dtb_category.category_name = ?";
			}
		//商品ステータスID指定
		} else if ($target == PLG_MFP_FILTER_TARGET_STATUS_ID) {
			
			if ($valuetype == PLG_MFP_FILTER_VALUETYPE_URL and $value == PLG_MFP_FILTER_VALUE_PRODUCT_ID) {
				$tables[] = "dtb_product_status s1";
				$tables[] = "dtb_product_status s2";
				$tables[] = "dtb_products p2";
				$where .= "p2.product_id = ?";
				$where .= " AND s1.product_id = p2.product_id";
				$where .= " AND s1.product_status_id = s2.product_status_id";
				$where .= " AND dtb_products.product_id = s2.product_id";
			} else {
				//すでにテーブルが追加されていたら、別名テーブルにする
				if (in_array("dtb_product_status", $tables)) {
					$tblname = "dpc".count($tables);
					$tables[] = "dtb_product_status {$tblname}";
				} else {
					$tblname = "dtb_product_status";
					$tables[] = $tblname;
				}
				$where .= "dtb_products.product_id = {$tblname}.product_id";
				$where .= " AND {$tblname}.product_status_id = ?";
				$where .= " AND {$tblname}.del_flg = 0";
			}
			//ページの商品を除外
			if ($valuetype == PLG_MFP_FILTER_VALUETYPE_URL and $value == PLG_MFP_FILTER_VALUE_PRODUCT_ID and $except_self) {
				$where .= " AND dtb_products.product_id != ?";
			}
			
		// 商品コード指定
		} else if ($target == PLG_MFP_FILTER_TARGET_PRODUCT_CODE) {
			$where .= "dtb_products.product_id = dtb_products_class.product_id";

			//含む
			if ($condition == PLG_MFP_FILTER_COND_LIKE) {
				$where .= " AND dtb_products_class.product_code LIKE ?";
			//含まない
			} else if ($condition == PLG_MFP_FILTER_COND_NOTLIKE) {
				$where .= " AND dtb_products_class.product_code NOT LIKE ?";
			//正規表現
			} else if ($condition == PLG_MFP_FILTER_COND_REGEXP) {
				$where .= " AND dtb_products_class.product_code ".self::regexp_str()." ?";
			//正規表現（否定）
			} else if ($condition == PLG_MFP_FILTER_COND_NOTREGEXP) {
				$where .= " AND dtb_products_class.product_code ".self::regexp_not_str()." ?";
			//等しい
			} else {
				$where .= " AND dtb_products_class.product_code = ?";
			}
			
		// メーカーURL,備考欄(SHOP専用)指定
		} else if ($target == PLG_MFP_FILTER_TARGET_MAKER_URL or $target == PLG_MFP_FILTER_TARGET_NOTE) {
			
			//カラムを特定
			if ($target == PLG_MFP_FILTER_TARGET_MAKER_URL) {
				$col = 'comment1';
			} else if ($target == PLG_MFP_FILTER_TARGET_NOTE) {
				$col = 'note';
			}
			
			//含む
			if ($condition == PLG_MFP_FILTER_COND_LIKE) {
				$where .= "dtb_products.{$col} LIKE CONCAT('%',#replace#,'%')";
			//含まない
			} else if ($condition == PLG_MFP_FILTER_COND_NOTLIKE) {
				$where .= "dtb_products.{$col} NOT LIKE CONCAT('%',#replace#,'%')";
			//正規表現
			} else if ($condition == PLG_MFP_FILTER_COND_REGEXP) {
				$where .= "dtb_products.{$col} ".self::regexp_str()." ?";
			//正規表現（否定）
			} else if ($condition == PLG_MFP_FILTER_COND_NOTREGEXP) {
				$where .= "dtb_products.{$col} ".self::regexp_not_str()." ?";
			//等しい
			} else {
				$where .= "dtb_products.{$col} = #replace#";
			}
			
			//URLパラメータの商品IDを対象にする場合は#replace#部分をサブクエリに置き換え
			if ($valuetype == PLG_MFP_FILTER_VALUETYPE_URL and $value == PLG_MFP_FILTER_VALUE_PRODUCT_ID) {
				$where = str_replace('#replace#', "(SELECT p2.{$col} FROM dtb_products p2 WHERE p2.product_id = ?)", $where);
				//ページの商品を除外
				if ($except_self) {
					$where .= " AND dtb_products.product_id != ?";
				}
			//データベースフィールドを対象にする場合は#replace#部分を対象のフィールドに置き換え
			} else if ($valuetype == PLG_MFP_FILTER_VALUETYPE_DBFIELD) {
				$where = str_replace('#replace#', $value, $where);
				//「等しい」かつ「NULL」の場合は「IS NULL」に置き換え
				$where = str_replace('= NULL', 'IS NULL', $where);
				
			//それ以外は通常のプレースホルダに置き換え
			} else {
				$where = str_replace('#replace#', '?', $where);
			}
		}
		
		//URLパラメータを参照
		if ($valuetype == PLG_MFP_FILTER_VALUETYPE_URL) {
			if ($target == PLG_MFP_FILTER_TARGET_CATEGORY_ID) {
				foreach($arrCatids as $catid) {
					$arrWhereVal[] = $catid;
				}
			} else {
				$arrWhereVal[] = $_GET[$value];
			}
			//ページの商品を除外
			if ($value == PLG_MFP_FILTER_VALUE_PRODUCT_ID and $except_self) {
				$arrWhereVal[] = $_GET[$value];
			}
		//それ以外は入力値を参照
		} else {
			//カテゴリID
			if ($target == PLG_MFP_FILTER_TARGET_CATEGORY_ID) {
				foreach($arrCatids as $catid) {
					$arrWhereVal[] = $catid;
				}
			//カテゴリ名、商品コード
			} else if (in_array($target, array(PLG_MFP_FILTER_TARGET_CATEGORY_NAME,PLG_MFP_FILTER_TARGET_PRODUCT_CODE))) {
				if ($condition == PLG_MFP_FILTER_COND_LIKE or $condition == PLG_MFP_FILTER_COND_NOTLIKE) {
					$arrWhereVal[] = "%{$value}%";
				} else {
					$arrWhereVal[] = $value;
				}
			//その他
			} else {
				$arrWhereVal[] = $value;
			}
		}
		
		if ($or_connect_str == '┓' or $or_connect_str == '┃') {
			$where .= ' OR ';
		} else if ($or_connect_str == '┛') {
			$where .= ') AND ';
		} else {
			$where .= ' AND ';
		}
		
		$where = str_replace(" AND  AND ", " AND ", $where);
	}
	
	/**
	 * 条件に一致する商品IDリストを取得
	 * 
	 * @param array $bloc ブロックマスターデータ
	 * @return array 商品IDリスト
	 */
	function getProductIds($bloc) {
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$cols        = array('dtb_products.product_id');
		$tables      = array('dtb_products,dtb_products_class');
		$join_tables = array();
		$join_where  = array();
		$where       = "dtb_products.del_flg = 0 AND dtb_products.status != 2 AND dtb_products.product_id = dtb_products_class.product_id AND (dtb_products_class.stock_unlimited = 1 OR dtb_products_class.stock != 0) AND ";
		$groups      = array("dtb_products.product_id");
		$arrWhereVal = array();
		
		self::mergeQueryFromMaster($bloc, $objQuery, $cols, $tables, $where, $arrWhereVal, $groups);
		$where .= ' AND ';
		$arrFilters = self::getFilterList($bloc['mfp_id']);
		
		//フィルターループ中に参照する値
		$filter_static_vars = array(
			'or_connect_str'	=> '',
			'last'				=> false,
		);
		$i = 0;
		$max = count($arrFilters);
		foreach($arrFilters as $filter) {
			if ($i+1 == $max) {
				$filter_static_vars['last'] = true;
			}
			self::mergeQueryFromFilter($filter, $tables, $where, $arrWhereVal, $join_tables, $join_where, $filter_static_vars);
			$i++;
		}
		$where = str_replace(" AND  AND ", " AND ", $where);
		
		$where .= '1';
		$tables = array_unique($tables);
		$tables_query = implode(",", $tables);
		if (($len = count($join_tables)) != 0) {
			for($i=0; $i<$len; $i++) {
				$t = $join_tables[$i];
				$w = $join_where[$i];
				$tables_query .= " INNER JOIN {$t} ON ({$w}) ";
			}
		}
		
		$groupby_query = implode(",", $groups);
		$objQuery->setGroupBy($groupby_query);
		$result = $objQuery->select(implode(",", $cols), $tables_query, $where, $arrWhereVal);
		
		//ランダム表示であればシャッフル
		if ($bloc['mfp_disp_random']) {
			shuffle($result);
		}
		
		return $result;
	}
	
	/**
     * 商品IDをキーにした, 所属カテゴリーIDの配列を取得する.
     *
     * @param array 商品ID の配列
     * @return array 商品IDをキーにした商品ステータスIDの配列
     */
    function getProductCategories($productIds) {
        if (empty($productIds)) {
            return array();
        }
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $cols = 'product_id, category_id';
        $from = 'dtb_product_categories';
        $where = 'product_id IN (' . SC_Utils_Ex::repeatStrWithSeparator('?', count($productIds)) . ')';
        $productCategory = $objQuery->select($cols, $from, $where, $productIds);
        $results = array();
        foreach ($productCategory as $category) {
            $results[$category['product_id']][] = $category['category_id'];
        }
        return $results;
    }
	
	/**
	 * 並び要素を取得
	 *
	 * @return array
	 */
	function getDimensionNames() {
		return self::$arrDimensionName_;
	}
	
	/**
	 * 並び方向を取得
	 *
	 * @return array
	 */
	function getDirectionNames() {
		return self::$arrDirectionName_;
	}
	
	/**
	 * ターゲットを取得
	 *
	 * @return array
	 */
	function getTargetNames() {
		return self::$arrTargetName_;
	}
	
	/**
	 * 絞り込み条件名を取得
	 *
	 * @return array
	 */
	function getConditionNames() {
		return self::$arrConditionName_;
	}
	
	/**
	 * フィルターの値タイプ名を取得
	 *
	 * @return array
	 */
	function getFilterValuetypeNames() {
		return self::$arrFilterValuetypeName_;
	}
	
	/**
	 * フィルターの値（URL）選択肢を取得
	 *
	 * @return array
	 */
	function getFilterValueUrlNames() {
		return self::$arrFilterValueUrlName_;
	}
	
	/**
	 * 対象のデータベーステーブルフィールドリストを返す
	 *
	 * @return array
	 */
	function getValueDbFields() {
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$result = array();
		$tables = array(
			'dtb_products',
			'dtb_products_class',
		);
		foreach ($tables as $tbl) {
			$fields = $objQuery->listTableFields($tbl);
			foreach ($fields as $fld) {
				$result[] = "{$tbl}.{$fld}";
			}
		}
		//最後にNULLを追加
		array_push($result, 'NULL');
		
		return $result;
	}
}
