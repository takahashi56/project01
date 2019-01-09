<?php
/*
 * OperateProductSTrial
 * Copyright(c) 2015 DAISY Inc. All Rights Reserved.
 *
 * http://www.daisy.link/
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

// {{{ requires
require_once CLASS_EX_REALDIR . 'page_extends/admin/LC_Page_Admin_Ex.php';
require_once PLUGIN_UPLOAD_REALDIR . 'OperateProductSTrial/OperateProductSTrial.php';

/**
 * OperateProductSTrial プラグインの管理ページクラス.
 *
 * @package Page
 * @author DAISY CO.,LTD.
 * @version $
 */
 
class plg_OperateProductSTrial_LC_Page_Admin_Products_EditProducts extends LC_Page_Admin_Ex{

    /**
     * Page を初期化する
     * 
     * @return void
     */
    function init(){
        
        parent::init();
        $this->tpl_mainpage = PLUGIN_UPLOAD_REALDIR . 'OperateProductSTrial/templates/admin/products/plg_OperateProductSTrial_edit_products.tpl';
        $this->setTemplate($this->tpl_mainpage);
        
        $objMasterData = new SC_DB_MasterData_Ex();
        $this->arrStatuses = $objMasterData->getMasterData('mtb_status');
        $this->arrStatusImages = $objMasterData->getMasterData('mtb_status_image');
        $this->arrDisplayStatuses = $objMasterData->getMasterData('mtb_disp');
    }

    /**
     * Page のプロセス
     * 
     * @return void
     */
    function process(){
        $this->action();
        $this->sendResponse();
    }
    
    /**
     * Page のアクション
     * 
     * @return void 
     */
    function action(){
        
        $objFormParam = new SC_FormParam_Ex();
        $post = $_POST;
        $this->initFormParam($objFormParam);
        $this->setFormParam($objFormParam, $post);
        
        $arrProductIds = $objFormParam->getValue('product_ids');
        $this->arrProducts = $this->getProducts($arrProductIds);
        
        //選択した商品がなければリダイレクト
        if(empty($this->arrProducts)){
            SC_Response_Ex::sendRedirect( ADMIN_PRODUCTS_URLPATH );
            SC_Response_Ex::actionExit();
        }
        
        $mode = $this->getMode();
        switch($mode){
            
            case 'edit_products':
                
                $this->arrErr = $this->checkError($objFormParam);
                //エラーがなければ
                if(empty($this->arrErr)){
                    
                    $this->updateProducts($objFormParam);
                    $this->tpl_onload = <<< EOSCRIPT
                        if(confirm('選択した商品の編集が完了しました。\\nOKを押すとこのウィンドウを閉じて\\n元のウィンドウを更新します。')){
                            window.opener.location.reload();
                            window.close();
                        }
EOSCRIPT;
                }
                break;
                
            case 'pre_edit':
                
                $this->setAllProductsAsEdit($objFormParam);
                break;
        }
        
        $this->arrForm = $objFormParam->getFormParamList();
    }
    
    /**
     * パラメータ初期化
     * 
     * @param SC_FormParam_Ex $objFormParam
     * @param array $arrParam 
     */
    function initFormParam(SC_FormParam_Ex &$objFormParam){
        
        $objFormParam->addParam('商品ID', 'product_ids', INT_LEN, 'n', array('MAX_LENGTH_CHECK', 'NUM_CHECK'));
        $objFormParam->addParam('編集商品ID', 'edit_product_ids', INT_LEN, 'n', array('MAX_LENGTH_CHECK', 'NUM_CHECK'));
        $objFormParam->addParam('公開・非公開', 'status', INT_LEN, 'n', array('MAX_LENGTH_CHECK', 'NUM_CHECK'));
    }
    
    /**
     * パラメータセット
     * 
     * @param SC_FormParam_Ex $objFormParam
     * @param array $arrParam 
     */
    function setFormParam(SC_FormParam_Ex &$objFormParam, $arrParam){
        
        $objFormParam->setParam($arrParam);
        $objFormParam->convParam();
    }
    
    /**
     * 
     * 
     * @param SC_FormParam_Ex $objFormParam 
     */
    function setAllProductsAsEdit(SC_FormParam_Ex &$objFormParam){
        
        $arrProductIds = $objFormParam->getValue('product_ids');
        if(!empty($arrProductIds) && is_array($arrProductIds)){
            
            $objFormParam->setValue('edit_product_ids', $arrProductIds);
        }
    }
    
    /**
     * 商品を取得する
     * 
     * @param array $arrProductIds 商品IDの配列
     * @return array 商品データの配列
     */
    function getProducts($arrProductIds){
        
        $arrProducts = array();
        
        if(is_array($arrProductIds) && !empty($arrProductIds)){
            
            $objQuery = SC_Query_Ex::getSingletonInstance();
            $objQuery->setOrder('product_id ASC');
            $table = 'dtb_products';
            $where = sprintf('product_id in (%s)', SC_Utils_Ex::repeatStrWithSeparator('?', count($arrProductIds)));
            $arrWhereValues = $arrProductIds;
            $arrProducts = $objQuery->select('*', $table, $where, $arrWhereValues);
        }
        
        return $arrProducts;
    }
    
    /**
     * フォーム情報を元にデータを更新する
     * 
     * @param array $arrParam フォーム情報
     */
    function updateProducts(SC_FormParam_Ex &$objFormParam){
        
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $arrValues = array();
        $arrParam = $objFormParam->getHashArray();
        $arrEditProductIds = $objFormParam->getValue('edit_product_ids');
        
        //公開・非公開
        if(is_numeric($arrParam['status'])){
            
            $arrValues['status'] = $arrParam['status'];
        }
        
        $objQuery->begin();
        
        //編集する商品カラムがあるなら
        if(!empty($arrValues)){
            
            //商品を編集
            $table = 'dtb_products';
            $where = sprintf('product_id in (%s)', SC_Utils_Ex::repeatStrWithSeparator('?', count($arrEditProductIds)));
            $arrWhereValues = $arrEditProductIds;
            $arrValues['update_date'] = 'CURRENT_TIMESTAMP';
            $objQuery->update($table, $arrValues, $where, $arrWhereValues);
        }
        
        $objDb = new SC_Helper_DB_Ex();
        $objDb->sfCountCategory($objQuery);
        $objDb->sfCountMaker($objQuery);
        
        $objQuery->commit();
    }
    
    /**
     * エラー情報を取得する
     * 
     * @param SC_FormParam_Ex $objFormParam 
     */
    function checkError(SC_FormParam_Ex &$objFormParam){
        
        $objError = new SC_CheckError_Ex($objFormParam->getHashArray());
        $arrErr = $objFormParam->checkError();
        
        $arrEditProductIds = $objFormParam->getValue('edit_product_ids');
        if(empty($arrEditProductIds) || !is_array($arrEditProductIds)){
            
            $objError->arrErr['edit_product_ids'] = '※ 編集する商品が選択されていません。';
        }
        
        $arrErr = array_merge($arrErr, $objError->arrErr);
        return $arrErr;
    }
}