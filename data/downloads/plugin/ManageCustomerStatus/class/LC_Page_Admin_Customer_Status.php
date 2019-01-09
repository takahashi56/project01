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

class LC_Page_Admin_Customer_Status extends LC_Page_Admin_Ex {

    // }}}
    // {{{ functions

    /**
     * Page を初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();

		$this->tpl_mainpage = PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/templates/admin/customer/status.tpl";
        $this->tpl_subnavi = 'customer/subnavi.tpl';
        $this->tpl_mainno = 'customer';
        $this->tpl_subno = 'status';
        $this->tpl_maintitle = '会員管理';
        $this->tpl_subtitle = '会員ランク管理';
    }

    /**
     * Page のプロセス.
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
		// パラメーター初期化, 取得
		$this->lfInitParam($objFormParam);
		$objFormParam->setParam($_POST);
		$objFormParam->convParam();
		$arrForm = $objFormParam->getHashArray();
 
        switch ($this->getMode()) {
            case 'pre_edit':
				$arrItem = $this->getStatusData($arrForm['status_id']);
				$this->arrForm = $arrItem;

                break;
            case 'edit':
                // エラーチェック
				$this->arrErr = $this->lfCheckError($objFormParam);
                if (count($this->arrErr) == 0) {
					if($arrForm['status_id'] > 0){
						$status_id = $this->updateData($arrForm);
						$this->updateCSV($status_id,$arrForm['name']);
					}else{
						$status_id = $this->insertData($arrForm);
						$this->insertCSV($status_id,$arrForm['name']);
					}
					
					SC_Response_Ex::reload();
                } else {
                    $this->arrForm = $arrForm;
                }
                break;
			case 'delete':
				$this->deleteCSV($arrForm['status_id']);
				$this->deleteData($arrForm['status_id']);

				SC_Response_Ex::reload();
				break;
			default:
				break;
		}
		
		$this->arrItems = $this->getStatusData();
				
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
        $objFormParam->addParam('status_id', 'status_id', INT_LEN, 'n', array('NUM_CHECK','MAX_LENGTH_CHECK'));
        $objFormParam->addParam('名称', 'name', MTEXT_LEN, 'KVa', array('EXIST_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('ランク', 'priority', MTEXT_LEN, 'n', array('EXIST_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('割引率', 'discount_rate', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('値引き値', 'discount_value', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('ポイント率', 'point_rate', INT_LEN, 'n', array('MAX_LENGTH_CHECK'));
        $objFormParam->addParam('ポイント値', 'point_value', INT_LEN, 'n', array('MAX_LENGTH_CHECK'));
        $objFormParam->addParam('送料値引き', 'discount_fee', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('送料無料', 'free_fee', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('購入金額', 'total_amount', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('購入回数', 'buy_times', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('保有ポイント', 'total_point', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('初期ランク', 'initial_rank', INT_LEN, 'n', array('NUM_CHECK'));
        $objFormParam->addParam('固定ランク', 'fixed_rank', INT_LEN, 'n', array('NUM_CHECK'));
   }
   
	function lfCheckError($objFormParam){
		$arrErr = $objFormParam->checkError();
		$where = "initial_rank = ?";
		$arrWhere = array(1);
		$status_id = $objFormParam->getValue('status_id');
		if($status_id > 0){
			$where .= " AND status_id <> ?";
			$arrWhere[] = $status_id;
		}
		
		if($objFormParam->getValue('initial_rank') == 1){
			$objQuery =& SC_Query_Ex::getSingletonInstance();
			$cnt = $objQuery->get("count(status_id)","plg_managecustomerstatus_dtb_customer_status",$where,$arrWhere);
			if($cnt > 0)$arrErr['initial_rank'] = "すでに別のランクで初期ランク設定が行われています<br>";
		}
		
		if(strlen($objFormParam->getValue('point_rate')) > 1){
			if(!is_numeric($objFormParam->getValue('point_rate')))$arrErr['point_rate'] = "数字を入力してください。<br>";
		}
		if(strlen($objFormParam->getValue('point_value')) > 1){
			if(!is_numeric($objFormParam->getValue('point_value')))$arrErr['point_value'] = "数字を入力してください。<br>";
		}
		return $arrErr;
	}   

    /**
     * 会員種別情報を取得する
     *
     * @access private
     * @return array データの連想配列
     */
    function getStatusData($status_id = NULL) {
		$where = "";
		$arrWhere = array();
        $col = '*';
        $from = 'plg_managecustomerstatus_dtb_customer_status';
		if($status_id > 0){
			$where = "status_id = ?";
			$arrWhere[] = $status_id;
		}
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objQuery->setOrder('priority DESC');
        $arrData = $objQuery->select($col, $from,$where,$arrWhere);
		if($status_id > 0){
			return $arrData[0];
		}else{
        	return $arrData;
		}
    }
	
    /**
     * UPDATE
     */
    function updateData($arrData) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
		$status_id = $arrData['status_id'];
        $objQuery->begin();

        $sqlval = array();
        $sqlval['name']  = $arrData['name'];
        $sqlval['discount_rate']  = $arrData['discount_rate'];
        $sqlval['discount_value']  = $arrData['discount_value'];
		$sqlval['point_rate']  = $arrData['point_rate'];
        $sqlval['point_value']  = $arrData['point_value'];
        $sqlval['discount_fee']  = $arrData['discount_fee'];
        $sqlval['total_amount']  = $arrData['total_amount'];
        $sqlval['buy_times']  = $arrData['buy_times'];
        $sqlval['free_fee']  = $arrData['free_fee'];
        $sqlval['priority']  = $arrData['priority'];
        $sqlval['total_point']  = $arrData['total_point'];
        $sqlval['initial_rank']  = $arrData['initial_rank'];
        $sqlval['fixed_rank']  = $arrData['fixed_rank'];

        $objQuery->update('plg_managecustomerstatus_dtb_customer_status', $sqlval,"status_id = ?",array($status_id));

        $objQuery->commit();
		return $status_id;
    }

    /**
     * INSERT
     */
    function insertData($arrData) {		        
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objQuery->begin();
		
		$status_id = $objQuery->max("status_id","plg_managecustomerstatus_dtb_customer_status") + 1;

        $sqlval = array();
        $sqlval['status_id']  = $status_id;
        $sqlval['name']  = $arrData['name'];
        $sqlval['discount_rate']  = $arrData['discount_rate'];
        $sqlval['discount_value']  = $arrData['discount_value'];
		$sqlval['point_rate']  = $arrData['point_rate'];
        $sqlval['point_value']  = $arrData['point_value'];
        $sqlval['discount_fee']  = $arrData['discount_fee'];
        $sqlval['total_amount']  = $arrData['total_amount'];
        $sqlval['buy_times']  = $arrData['buy_times'];
        $sqlval['free_fee']  = $arrData['free_fee'];
		$sqlval['priority']  = $arrData['priority'];
		$sqlval['total_point']  = $arrData['total_point'];
        $sqlval['initial_rank']  = $arrData['initial_rank'];
        $sqlval['fixed_rank']  = $arrData['fixed_rank'];

        $objQuery->insert('plg_managecustomerstatus_dtb_customer_status', $sqlval);

        $objQuery->commit();
		return $status_id;
    }
	
    /**
     * DELETE
     */	
	function deleteData($status_id){
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objQuery->begin();
		
		$objQuery->update("dtb_customer",array("plg_managecustomerstatus_status" => NULL,"plg_managecustomerstatus_check_date" => NULL),"plg_managecustomerstatus_status=?",array($status_id));
		$objQuery->delete("plg_managecustomerstatus_dtb_customer_status","status_id = ?",array($status_id));
		$objQuery->delete("plg_managecustomerstatus_dtb_price","status_id = ?",array($status_id));
		
        $objQuery->commit();
	}
	
	function insertCSV($status_id,$title){
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		// dtb_csvテーブルにレコードを追加
		$sqlval_dtb_csv = array();
		$max = $objQuery->max('no','dtb_csv')+1;
		$next = $objQuery->nextVal('dtb_csv_no');
		if($max > $next){
			$no = $max;
		}else{
			$no = $next;
		}
		$sqlval_dtb_csv['no'] = $no;
		$sqlval_dtb_csv['csv_id'] = 1;
		$sqlval_dtb_csv['col'] = '(SELECT price FROM plg_managecustomerstatus_dtb_price WHERE prdcls.product_class_id = plg_managecustomerstatus_dtb_price.product_class_id AND plg_managecustomerstatus_dtb_price.status_id = '.$status_id.' LIMIT 1) AS plg_managecustomerstatus_price'.$status_id;
		$sqlval_dtb_csv['disp_name'] = $title. "価格";
		$sqlval_dtb_csv['rw_flg'] = 1;
		$sqlval_dtb_csv['status'] = 2;
		$sqlval_dtb_csv['create_date'] = "CURRENT_TIMESTAMP";
		$sqlval_dtb_csv['update_date'] = "CURRENT_TIMESTAMP";
		$sqlval_dtb_csv['mb_convert_kana_option'] = "n";
		$sqlval_dtb_csv['size_const_type'] = "PRICE_LEN";
		$sqlval_dtb_csv['error_check_types'] = "NUM_CHECK,MAX_LENGTH_CHECK";
		$objQuery->insert("dtb_csv", $sqlval_dtb_csv);
		$objQuery->insert('plg_managecustomerstatus_dtb_csv_no',array('status_id' => $status_id, 'csv_no' => $sqlval_dtb_csv['no']));
	}
	
	function updateCSV($status_id,$title){
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$csv_no = $objQuery->get('csv_no','plg_managecustomerstatus_dtb_csv_no','status_id = ?',array($status_id));
		$sqlval_dtb_csv = array();
		$sqlval_dtb_csv['disp_name'] = $title. "価格";
		$sqlval_dtb_csv['update_date'] = "CURRENT_TIMESTAMP";
		$objQuery->update('dtb_csv',$sqlval_dtb_csv,'no = ?',array($csv_no));
	}
	
	function deleteCSV($status_id){
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$csv_no = $objQuery->get("csv_no","plg_managecustomerstatus_dtb_csv_no","status_id = ?",array($status_id));
		$objQuery->delete("dtb_csv","no = ?",array($csv_no));
		$objQuery->delete("plg_managecustomerstatus_dtb_csv_no","csv_no = ?",array($csv_no));
	}
}
