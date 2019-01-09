<?php
/*
 * ManageCustomerStatus
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
require_once PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/plg_ManageCustomerStatus_Utils.php";

/**
 * 会員種別設定
 *
 * @package ManageCustomerStatus
 * @author Bratech CO.,LTD.
 * @version $Id: $
 */
class LC_Page_Plugin_ManageCustomerStatus_Config extends LC_Page_Admin_Ex {
    
    var $arrForm = array();

    /**
     * 初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();
        $this->tpl_mainpage = PLUGIN_UPLOAD_REALDIR ."ManageCustomerStatus/templates/config.tpl";
        $this->tpl_subtitle = "会員ランクプラグイン設定";
		
		$this->arrMode = array( '1'=>'つける','0' => 'つけない');
		$this->arrLoginDisp = array('0' => '常に表示', '1'=>'ログイン中のみ表示');
		$this->arrTerm = array("0" => '設定なし',1 => '１ヶ月',3 => '３ヶ月', 6 => '半年', 12 => '１年', 24 => '２年',99 => '無期限');
		$this->arrMethod = array(0 => '使用しない',1 => '最終購入日更新方式',2 => '前期間削除方式');
		
        $masterData = new SC_DB_MasterData_Ex();
        $this->arrORDERSTATUS = $masterData->getMasterData('mtb_order_status');		
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
		case 'rank_check':
			$term = plg_ManageCustomerStatus_Utils::getConfig("term");
			if($term==99 || $term == 0){
				list($start_date,$end_date) = plg_ManageCustomerStatus_Utils::getTerm($term);
				
				$objQuery =& SC_Query_Ex::getSingletonInstance();
				$arrCustomerId = $objQuery->getCol("customer_id","dtb_customer","del_flg = ?",array(0));
				
				foreach($arrCustomerId as $customer_id){
					plg_ManageCustomerStatus_Utils::checkRank($customer_id,$start_date,$end_date);
				}
			}elseif($term > 0){
				list($start_date,$end_date) = plg_ManageCustomerStatus_Utils::getTerm($term);
		
				$objQuery =& SC_Query_Ex::getSingletonInstance();
				$arrCustomerId = $objQuery->getCol("customer_id","dtb_customer","plg_managecustomerstatus_check_date IS NULL OR plg_managecustomerstatus_check_date <= ? AND del_flg = ?",array($end_date,0));
				
				foreach($arrCustomerId as $customer_id){
					plg_ManageCustomerStatus_Utils::checkRank($customer_id,$start_date,$end_date);
				}
			}
            $this->tpl_onload = "alert('全会員のランクチェックが完了しました。');";
			break;
		case 'rank_reset':
			$objQuery =& SC_Query_Ex::getSingletonInstance();
			$objQuery->update("dtb_customer",array("plg_managecustomerstatus_check_date"=>NULL));
            $this->tpl_onload = "alert('全会員のチェックフラグをリセットしました。');";
			break;
        default:
            break;
        }
		if(empty($arrForm)){
			$objQuery =& SC_Query_Ex::getSingletonInstance();
			$ret = $objQuery->select("*","plg_managecustomerstatus_config");
			foreach($ret as $item){
				if($item['name'] == "target_id"){
					$arrForm[$item['name']] = explode(',',$item['value']);
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
        $objFormParam->addParam('会員価格タイトル', 'member_rank_price_title', STEXT_LEN, 'KVa', array('EXIST_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('会員価格タイトル', 'member_rank_price_title_mode', INT_LEN, 'n', array('EXIST_CHECK','NUM_CHECK','MAX_LENGTH_CHECK'));
		$objFormParam->addParam('会員価格の表示設定', 'login_disp', INT_LEN, 'n', array('EXIST_CHECK','NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('更新期間', 'term', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
//        $objFormParam->addParam('方式', 'point_method', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
		$objFormParam->addParam('対象受注ステータス', 'target_id', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('ポイント有効期間', 'point_term', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
    }
    
	
	function updateData($arrData){
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		foreach($arrData as $key => $value){
			$objQuery->delete("plg_managecustomerstatus_config","name = ?",array($key));
			$sqlval=array();
			$sqlval['name'] = $key;
			if(is_array($value))$value = implode(',',$value);
			$sqlval['value'] = $value;
			$objQuery->insert("plg_managecustomerstatus_config",$sqlval);
		}
	}

}
?>
