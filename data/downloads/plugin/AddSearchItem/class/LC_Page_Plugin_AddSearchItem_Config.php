<?php
/*
 * AddSearchItem
 * Copyright (C) 2012 Bratech CO.,LTD. All Rights Reserved.
 * http://www.bratech.co.jp/
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
require_once CLASS_EX_REALDIR . 'page_extends/admin/LC_Page_Admin_Ex.php';
require_once PLUGIN_UPLOAD_REALDIR . "AddSearchItem/plg_AddSearchItem_Util.php";

/**
 * 検索項目追加設定
 *
 * @package AddSearchItem
 * @author Bratech CO.,LTD.
 * @version $Id: $
 */
class LC_Page_Plugin_AddSearchItem_Config extends LC_Page_Admin_Ex {
    
    var $arrForm = array();

    /**
     * 初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();
        $this->tpl_mainpage = PLUGIN_UPLOAD_REALDIR ."AddSearchItem/templates/config.tpl";
        $this->tpl_subtitle = "検索項目追加設定";
		
		$this->arrUse = array(0 => '使用しない', 1 => '使用する');
		$this->arrSearchInc = array(0 => '含めない', 1 => '含める');
		$this->arrAndOr = array(0 => 'OR検索', 1 => 'AND検索');
		
		// 商品ステータスリスト
        $masterData = new SC_DB_MasterData_Ex();
        $this->arrSTATUS = $masterData->getMasterData('mtb_status');
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
        $objFormParam = new SC_FormParam_Ex();
        $this->lfInitParam($objFormParam);
        $objFormParam->setParam($_POST);
        $objFormParam->convParam();
        
        $arrForm = array();
        
        switch ($this->getMode()) {
        case 'edit':
            $arrForm = $objFormParam->getHashArray();
            $this->arrErr = $objFormParam->checkError();
            // エラーなしの場合にはデータを更新
            if (count($this->arrErr) == 0) {
                // データ更新
				$this->updateData($arrForm);
                if (count($this->arrErr) == 0) {
                    $this->tpl_onload = "alert('登録が完了しました。');";
					$this->tpl_onload .= 'window.close();';
                }
            }
            break;
        default:
            break;
        }
		if(empty($arrForm)){
			$objQuery =& SC_Query_Ex::getSingletonInstance();
			$ret = $objQuery->select("*","plg_addsearchitem_config");
			foreach($ret as $item){
				if($item['name'] == 'product_status'){
					$arrForm[$item['name']] = unserialize($item['value']);
				}else{
					$arrForm[$item['name']] = $item['value'];
				}
			}
		}
        $this->arrForm = $arrForm;
        $this->setTemplate($this->tpl_mainpage);
    }

    /**
     * デストラクタ.
     *
     * @return void
     */
    function destroy() {
		if(method_exists('LC_Page_Admin_Ex','destroy')){
        	parent::destroy();
		}
    }
    
    /**
     * パラメーター情報の初期化
     *
     * @param object $objFormParam SC_FormParamインスタンス
     * @return void
     */
    function lfInitParam(&$objFormParam) {
        $objFormParam->addParam('在庫の有無', 'stock', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('レビューの有無', 'review', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('送料無料の有無', 'freeshipping', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('価格帯', 'price', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('商品ステータス', 'product_status', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('商品ステータスの絞り込み条件', 'product_status_condition', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('商品コード', 'search_product_code', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('一覧コメント', 'search_list_comment', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('メインコメント', 'search_main_comment', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('サブコメント', 'search_sub_comment', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('規格名・規格分類名', 'search_classcategory', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('大文字・小文字ゆらぎ検索', 'search_fluctuation', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('価格順（低い順）', 'sort_price_asc', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('価格順（高い順）', 'sort_price_desc', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('新着順', 'sort_date', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('評価順', 'sort_recommend', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('レビュー数順', 'sort_review', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('割引率順', 'sort_discount', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
		$objFormParam->addParam('売れ筋順', 'sort_quantity', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
		$objFormParam->addParam('売上順', 'sort_sales', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
		$objFormParam->addParam('価格順（低い順）(文言)', 'text_price_asc', STEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
		$objFormParam->addParam('価格順（高い順）(文言)', 'text_price_desc', STEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
		$objFormParam->addParam('新着順(文言)', 'text_date', STEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
		$objFormParam->addParam('評価順(文言)', 'text_recommend', STEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
		$objFormParam->addParam('レビュー数順(文言)', 'text_review', STEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
		$objFormParam->addParam('割引率順(文言)', 'text_discount', STEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
		$objFormParam->addParam('売れ筋順(文言)', 'text_quantity', STEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
		$objFormParam->addParam('売上順(文言)', 'text_sales', STEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
    }
    
	
	function updateData($arrData){
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		foreach($arrData as $key => $value){
			$objQuery->delete("plg_addsearchitem_config","name = ?",array($key));
			$sqlval=array();
			$sqlval['name'] = $key;
			if($key == 'product_status'){
				$sqlval['value'] = serialize($value);
			}else{
				$sqlval['value'] = $value;
			}
			$objQuery->insert("plg_addsearchitem_config",$sqlval);
		}
	}

}
?>
