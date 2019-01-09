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

// {{{ requires
require_once CLASS_EX_REALDIR . 'page_extends/admin/LC_Page_Admin_Ex.php';

/**
 * プラグインファイル自動生成のクラス
 *
 * @package MatrixFilterProducts
 * @author colori
 * @version $Id: $
 */
class LC_Page_Plugin_MatrixFilterProducts_Config extends LC_Page_Admin_Ex {

    /**
     * 初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();
        $this->tpl_mainpage = PLUGIN_UPLOAD_REALDIR ."MatrixFilterProducts/templates/config.tpl";
        $this->tpl_subtitle = "条件指定商品リスト・ブロック作成プラグイン 設定";
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
	
		$plugin = MatrixFilterProducts::getPluginData();

        //かならずPOST値のチェックを行う
        $objFormParam = new SC_FormParam_Ex();
        $this->lfInitParam($objFormParam);
        $objFormParam->setParam($_POST);
        $objFormParam->convParam();

        switch ($this->getMode()) {
        case 'edit':
            $arrForm = $objFormParam->getHashArray();
            $this->arrErr = $objFormParam->checkError();
            // エラーなしの場合にはデータを更新
            if (count($this->arrErr) == 0) {
			
                // データ更新
				if (!$this->isFilterMode()) {
					$this->arrErr = MatrixFilterProducts::updateBloc($arrForm);
					if (count($this->arrErr) == 0) {
						header('Location:'.$_SERVER['PHP_SELF'].'?plugin_id='.$plugin['plugin_id']);
						exit;
					}
				// フィルターデータ更新
				} else {
					$this->arrErr = MatrixFilterProducts::updateFilter($arrForm);
					if (count($this->arrErr) == 0) {
						$url = $_SERVER['PHP_SELF'].'?plugin_id='.$plugin['plugin_id'].'&mfp_id='.$arrForm['mfp_id'].'&filters';
						header("Location:{$url}");
						exit;
					}
				}
            }
            break;
		case 'delete':
			$arrForm = $objFormParam->getHashArray();
			if (!$this->isFilterMode()) {
				$this->arrErr = MatrixFilterProducts::deleteBloc($arrForm);
			} else {
				$this->arrErr = MatrixFilterProducts::deleteFilter($arrForm);
			}
			$arrForm = array();
			break;
        default:
			if (!$this->isFilterMode()) {
				if (isset($_GET['mfp_id'])) {
					$arrForm = MatrixFilterProducts::getBlocFromId($_GET['mfp_id']);
					$this->edited = true;
				}
			} else {
				//フィルターIDが指定されていればフォームデータを取得
				if (isset($_GET['mfp_filter_id'])) {
					$arrForm = MatrixFilterProducts::getFilterFromId($_GET['mfp_filter_id']);
					$this->edited = true;
				}
			}
            $this->tpl_is_init = true;
            break;
        }
		
		//画面モードに応じたテンプレートファイルの変更
		if ($this->isFilterMode()) {
		
			if ($arrForm['mfp_id']) {
				$mfp_id = $arrForm['mfp_id'];
			} else if (isset($_GET['mfp_id'])) {
				$mfp_id = $_GET['mfp_id'];
			}
			
			$this->tpl_mainpage = PLUGIN_UPLOAD_REALDIR ."MatrixFilterProducts/templates/config_filter.tpl";
			$this->tpl_subtitle = "フィルター設定";
			$this->arrBloc    = MatrixFilterProducts::getBlocFromId($mfp_id);
			$this->arrFilters = MatrixFilterProducts::getFilterList($mfp_id);
			
			//必要な定義データをアサイン
			$this->arrFilterValuetypeName = MatrixFilterProducts::getFilterValuetypeNames();
		} else {
			$this->arrBlocs   = MatrixFilterProducts::getBlocList();
			$this->arrAllFilters = MatrixFilterProducts::getAllFilterList();
		}
		
		//必要な定義データをアサイン
		$masterData                 = new SC_DB_MasterData_Ex();
		$this->arrSTATUS            = $masterData->getMasterData('mtb_status');
		$this->arrDEVICETYPE		= array_reverse($masterData->getMasterData('mtb_device_type'), true);
		
		unset($this->arrDEVICETYPE[99]);
		$this->arrDimensionName     = MatrixFilterProducts::getDimensionNames();
		$this->arrDirectionName     = MatrixFilterProducts::getDirectionNames();
		$this->arrTargetName		= MatrixFilterProducts::getTargetNames();
		$this->arrConditionName		= MatrixFilterProducts::getConditionNames();
		$this->arrDbFields          = MatrixFilterProducts::getValueDbFields();
		
		$objDb = new SC_Helper_DB_Ex();
        $this->arrCATTREE = array();
        list($arrCatVal, $arrCatOut) = $objDb->sfGetLevelCatList(false);
		for ($i = 0; $i < count($arrCatVal); $i++) {
            $this->arrCATTREE[$arrCatVal[$i]] = $arrCatOut[$i];
        }
		$this->arrURLPARAM          = MatrixFilterProducts::getFilterValueUrlNames();
        $this->arrForm = $arrForm;
        // ポップアップ用の画面は管理画面のナビゲーションを使わない
        $this->setTemplate($this->tpl_mainpage);
    }

    /**
     * パラメーター情報の初期化
     *
     * @param object $objFormParam SC_FormParamインスタンス
     *
     * コンバートオプション	意味
     *   r	 「全角」英字を「半角」に変換します。
     *   R	 「半角」英字を「全角」に変換します。
     *   n	 「全角」数字を「半角」に変換します。
     *   N	 「半角」数字を「全角」に変換します。
     *   a	 「全角」英数字を「半角」に変換します。
     *   A	 「半角」英数字を「全角」に変換します （"a", "A" オプションに含まれる文字は、U+0022, U+0027, U+005C, U+007Eを除く U+0021 - U+007E の範囲です）。
     *   s	 「全角」スペースを「半角」に変換します（U+3000 -> U+0020）。
     *   S	 「半角」スペースを「全角」に変換します（U+0020 -> U+3000）。
     *   k	 「全角カタカナ」を「半角カタカナ」に変換します。
     *   K	 「半角カタカナ」を「全角カタカナ」に変換します。
     *   h	 「全角ひらがな」を「半角カタカナ」に変換します。
     *   H	 「半角カタカナ」を「全角ひらがな」に変換します。
     *   c	 「全角カタカナ」を「全角ひらがな」に変換します。
     *   C	 「全角ひらがな」を「全角カタカナ」に変換します。
     *   V	 濁点付きの文字を一文字に変換します。"K", "H" と共に使用します。
     *
     *   //チェックオプション
     *   See class => data/class/SC_CheckError.php
     *
     * @return void
     */
    function lfInitParam(&$objFormParam) {
		//初期画面用
		if (!$this->isFilterMode()) {
			$objFormParam->addParam('マスターID',	'mfp_id',				INT_LEN,	'n',	array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('ブロックID',	'mfp_bloc_id',			INT_LEN,	'n',	array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('デバイス',		'mfp_device_type_id',	INT_LEN,	'n',	array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('ブロック名',	'mfp_bloc_name',		STEXT_LEN,	'KVa',	array('EXIST_CHECK', 'SPTAB_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('ID名',			'mfp_bloc_elementid',	STEXT_LEN,	'KVa',	array('EXIST_CHECK', 'GRAPH_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('タイトル',		'mfp_bloc_title',		STEXT_LEN,	'KVa',	array('SPTAB_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('説明文',		'mfp_bloc_exp',		MLTEXT_LEN,	'KVa',	array('SPTAB_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('表示数',		'mfp_num',				INT_LEN,	'n',	array('EXIST_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('ピックアップ順',		'mfp_order_dimension',	INT_LEN,	'n',	array('EXIST_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('ピックアップ順',		'mfp_order_direction',	INT_LEN,	'n',	array('EXIST_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('並び順',		'mfp_disp_random',		INT_LEN,	'n',	array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('商品画像の幅',	'mfp_image_width',		INT_LEN,	'n',	array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('商品画像の高さ','mfp_image_height',	INT_LEN,	'n',	array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
		//フィルター画面用
		} else {
			$objFormParam->addParam('フィルターID',	'mfp_filter_id',		INT_LEN,	'n',	array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('マスターID',	'mfp_id',				INT_LEN,	'n',	array('EXIST_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('ターゲット',	'mfp_filter_target',	INT_LEN,	'n',	array('EXIST_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('条件',			'mfp_filter_condition',	INT_LEN,	'n',	array('EXIST_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('値(タイプ)',	'mfp_filter_valuetype',	INT_LEN,	'n',	array('EXIST_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('値',			'mfp_filter_value',		STEXT_LEN,	'KVa',	array('EXIST_CHECK', 'SPTAB_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('ページの商品は除外',			'mfp_filter_except_self',		INT_LEN,	'n',	array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
			$objFormParam->addParam('グループ化',	'mfp_filter_or_connect',INT_LEN,	'n',	array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
		}
    }

    /**
     * プラグイン設定値をDBに書き込み.
     *
     * @return void
     */
    function registData($arrData) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objQuery->begin();
        // UPDATEする値を作成する。
        $sqlval = array();
        $sqlval['free_field1'] = serialize($arrData);
        $sqlval['free_field2'] = '';
        $sqlval['update_date'] = 'CURRENT_TIMESTAMP';
        $where = "plugin_code = 'MatrixFilterProducts'";
        // UPDATEの実行
        $objQuery->update('dtb_plugin', $sqlval, $where);
        $objQuery->commit();
    }
	
	/**
	 * フィルター画面モードかどうか
	 *
	 * @return boolean
	 */
	function isFilterMode() {
		return isset($_GET['filters']);
	}

}
