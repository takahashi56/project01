<?php
/*
 * ManageCustomerStatus
 * Copyright (C) 2012 Bratech CO.,LTD. All Rights Reserved.
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

require_once PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/plg_ManageCustomerStatus_Utils.php";
require_once PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/class/plg_ManageCustomerStatus_LC_Page.php";

class plg_ManageCustomerStatus_LC_Page_Admin_Products_UploadCSV extends plg_ManageCustomerStatus_LC_Page{
    /**
     * @param LC_Page_Admin_Products_UploadCSV $objPage 商品CSV登録のページクラス
     * @return void
     */
    function before($objPage) {
        $objPage->csv_id = '1';

        $masterData = new SC_DB_MasterData_Ex();
        $objPage->arrDISP = $masterData->getMasterData('mtb_disp');
        $objPage->arrSTATUS = $masterData->getMasterData('mtb_status');
        $objPage->arrDELIVERYDATE = $masterData->getMasterData('mtb_delivery_date');
        $objPage->arrProductType = $masterData->getMasterData('mtb_product_type');
        $objPage->arrMaker = SC_Helper_DB_Ex::sfGetIDValueList('dtb_maker', 'maker_id', 'name');
        $objPage->arrPayments = SC_Helper_DB_Ex::sfGetIDValueList('dtb_payment', 'payment_id', 'payment_method');
        $objPage->arrInfo = SC_Helper_DB_Ex::sfGetBasisData();
        $objPage->arrAllowedTag = $masterData->getMasterData('mtb_allowed_tag');
        $objPage->arrTagCheckItem = array();
		
        $objPage->objDb = new SC_Helper_DB_Ex();
		
        // CSV管理ヘルパー
        $objCSV = new SC_Helper_CSV_Ex();
        // CSV構造読み込み
        $arrCSVFrame = $objCSV->sfGetCsvOutput($objPage->csv_id);

        // CSV構造がインポート可能かのチェック
        if (!$objCSV->sfIsImportCSVFrame($arrCSVFrame)) {
            // 無効なフォーマットなので初期状態に強制変更
            $arrCSVFrame = $objCSV->sfGetCsvOutput($objPage->csv_id, '', array(), 'no');
			$objPage->tpl_is_format_default = true;
        }
        // CSV構造は更新可能なフォーマットかのフラグ取得
        $objPage->tpl_is_update = $objCSV->sfIsUpdateCSVFrame($arrCSVFrame);

        // CSVファイルアップロード情報の初期化
       	$objUpFile = new SC_UploadFile_Ex(CSV_TEMP_REALDIR, CSV_TEMP_REALDIR);
        $objPage->lfInitFile($objUpFile);

        // パラメーター情報の初期化
        $objFormParam = new SC_FormParam_Ex();
        $objPage->lfInitParam($objFormParam, $arrCSVFrame);
		
		if(plg_ManageCustomerStatus_Utils::getECCUBEVer() >= 2130){
			$objPage->max_upload_csv_size = SC_Utils_Ex::getUnitDataSize(CSV_SIZE);
		}

        $objFormParam->setHtmlDispNameArray();

        switch ($objPage->getMode()) {
            case 'csv_upload':
                self::doUploadCsv($objFormParam, $objUpFile,$objPage);
				if(count($objPage->arrErr) < 2 && strlen($objPage->arrErr['csv_file']) == 0){
					$_GET['mode'] = $_POST['mode'] = $_REQUEST['mode'] = "complete";
				}
                break;
            default:
                break;
        }
    }
	
    /**
     * @param LC_Page_Admin_Products_UploadCSV $objPage 商品CSV登録のページクラス
     * @return void
     */
    function after($objPage) {
		if($objPage->getMode() == "complete"){
        	// 実行結果画面を表示
        	$objPage->tpl_mainpage = 'products/upload_csv_complete.tpl';
		}
	}
	
    /**
     * CSVアップロードを実行します.
     *
     * @return void
     */
    function doUploadCsv(&$objFormParam, &$objUpFile, &$objPage) {
        // ファイルアップロードのチェック
        $objPage->arrErr['csv_file'] = $objUpFile->makeTempFile('csv_file');
        if (strlen($objPage->arrErr['csv_file']) >= 1) {
            return;
        }
        $arrErr = $objUpFile->checkExists();
        if (count($arrErr) > 0) {
            $objPage->arrErr = $arrErr;
            return;
        }
        // 一時ファイル名の取得
        $filepath = $objUpFile->getTempFilePath('csv_file');
        // CSVファイルの文字コード変換
        $enc_filepath = SC_Utils_Ex::sfEncodeFile($filepath, CHAR_CODE, CSV_TEMP_REALDIR);
        // CSVファイルのオープン
        $fp = fopen($enc_filepath, 'r');
        // 失敗した場合はエラー表示
        if (!$fp) {
            SC_Utils_Ex::sfDispError('');
        }

        // 登録先テーブル カラム情報の初期化
        $objPage->lfInitTableInfo();

        // 登録フォーム カラム情報
        $objPage->arrFormKeyList = $objFormParam->getKeyList();

        // 登録対象の列数
        $col_max_count = $objFormParam->getCount();
        // 行数
        $line_count = 0;

        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objQuery->begin();

        $errFlag = false;
        $all_line_checked = false;

        while (!feof($fp)) {
            $arrCSV = fgetcsv($fp, CSV_LINE_MAX);

            // 全行入力チェック後に、ファイルポインターを先頭に戻す
            if (feof($fp) && !$all_line_checked) {
                rewind($fp);
                $line_count = 0;
                $all_line_checked = true;
                continue;
            }

            // 行カウント
            $line_count++;
            // ヘッダ行はスキップ
            if ($line_count == 1) {
                continue;
            }
            // 空行はスキップ
            if (empty($arrCSV)) {
                continue;
            }
            // 列数が異なる場合はエラー
            $col_count = count($arrCSV);
            if ($col_max_count != $col_count) {
                $objPage->addRowErr($line_count, '※ 項目数が' . $col_count . '個検出されました。項目数は' . $col_max_count . '個になります。');
                $errFlag = true;				
                break;
            }
            // シーケンス配列を格納する。
            $objFormParam->setParam($arrCSV, true);
            $arrRet = $objFormParam->getHashArray();
            $objFormParam->setParam($arrRet);
            // 入力値の変換
            $objFormParam->convParam();
            // <br>なしでエラー取得する。
            $arrCSVErr = $objPage->lfCheckError($objFormParam);

            // 入力エラーチェック
            if (count($arrCSVErr) > 0) {
                foreach ($arrCSVErr as $err) {
                    $objPage->addRowErr($line_count, $err);
                }
                $errFlag = true;
                break;
            }

            if ($all_line_checked) {
                self::lfRegistProduct($objQuery, $line_count, $objFormParam, $objPage);
                $arrParam = $objFormParam->getHashArray();

                $objPage->addRowResult($line_count, '商品ID：'.$arrParam['product_id'] . ' / 商品名：' . $arrParam['name']);
            }
            SC_Utils_Ex::extendTimeOut();
        }

        fclose($fp);

        if ($errFlag) {
            $objQuery->rollback();
            return;
        }

        $objQuery->commit();

        // 商品件数カウント関数の実行
        $objPage->objDb->sfCountCategory($objQuery);
        $objPage->objDb->sfCountMaker($objQuery);
    }
	
    /**
     * 商品登録を行う.
     *
     * FIXME: 商品登録の実処理自体は、LC_Page_Admin_Products_Productと共通化して欲しい。
     *
     * @param SC_Query $objQuery SC_Queryインスタンス
     * @param string|integer $line 処理中の行数
     * @return void
     */
    function lfRegistProduct($objQuery, $line = '', &$objFormParam, &$objPage) {
        $objProduct = new SC_Product_Ex();
        // 登録データ対象取得
       	$arrList = $objFormParam->getDbArray();
        // 登録時間を生成(DBのCURRENT_TIMESTAMPだとcommitした際、すべて同一の時間になってしまう)
        $arrList['update_date'] = $objPage->lfGetDbFormatTimeWithLine($line);

        // 商品登録情報を生成する。
        // 商品テーブルのカラムに存在しているもののうち、Form投入設定されていないデータは上書きしない。
        $sqlval = SC_Utils_Ex::sfArrayIntersectKeys($arrList, $objPage->arrProductColumn);

        // 必須入力では無い項目だが、空文字では問題のある特殊なカラム値の初期値設定
        $sqlval = $objPage->lfSetProductDefaultData($sqlval);

        if ($sqlval['product_id'] != '') {
            // 同じidが存在すればupdate存在しなければinsert
            $where = 'product_id = ?';
            $product_exists = $objQuery->exists('dtb_products', $where, array($sqlval['product_id']));
            if ($product_exists) {
                $objQuery->update('dtb_products', $sqlval, $where, array($sqlval['product_id']));
            } else {
                $sqlval['create_date'] = $arrList['update_date'];
                // INSERTの実行
                $objQuery->insert('dtb_products', $sqlval);
                // シーケンスの調整
                $seq_count = $objQuery->currVal('dtb_products_product_id');
                if ($seq_count < $sqlval['product_id']) {
                    $objQuery->setVal('dtb_products_product_id', $sqlval['product_id'] + 1);
                }
            }
            $product_id = $sqlval['product_id'];
        } else {
            // 新規登録
            $sqlval['product_id'] = $objQuery->nextVal('dtb_products_product_id');
            $product_id = $sqlval['product_id'];
            $sqlval['create_date'] = $arrList['update_date'];
            // INSERTの実行
            $objQuery->insert('dtb_products', $sqlval);
        }

        // カテゴリ登録
        if (isset($arrList['category_ids'])) {
            $arrCategory_id = explode(',', $arrList['category_ids']);
            $objPage->objDb->updateProductCategories($arrCategory_id, $product_id);
        }
        // 商品ステータス登録
        if (isset($arrList['product_statuses'])) {
            $arrStatus_id = explode(',', $arrList['product_statuses']);
            $objProduct->setProductStatus($product_id, $arrStatus_id);
        }

        // 商品規格情報を登録する
        $objPage->lfRegistProductClass($objQuery, $arrList, $product_id, $arrList['product_class_id']);

        // 関連商品登録
        $objPage->lfRegistReccomendProducts($objQuery, $arrList, $product_id);
		
        // 会員価格登録
        self::lfRegistRankPrices($objQuery, $arrList, $product_id, $arrList['product_class_id']);
		
        // 会員別非表示設定
		if (isset($arrList['plg_managecustomerstatus_product_disp'])) {
        	self::lfRegistRankDisp($objQuery, $arrList, $product_id);
		}
    }
	
    /**
     * 会員価格の登録を行う.
     *
     * @param SC_Query $objQuery SC_Queryインスタンス
     * @param array $arrList 商品規格情報配列
     * @param integer $product_id 商品ID
     * @param integer $product_class_id 商品規格ID
     * @return void
     */
    function lfRegistRankPrices($objQuery, $arrList, $product_id, $product_class_id) {
        if ($product_class_id == '') {
			$objQuery->delete('plg_managecustomerstatus_dtb_price', 'product_id = ?', array($product_id));
			$product_class_id = $objQuery->get("product_class_id","dtb_products_class","product_id=? AND classcategory_id1=? AND classcategory_id2=?",array($product_id,0,0));
		}else{
			$objQuery->delete('plg_managecustomerstatus_dtb_price', 'product_class_id = ?', array($product_class_id));
		}
		$arrStatus = plg_ManageCustomerStatus_Utils::getStatusRankList();
        foreach ($arrStatus as $key => $name) {
            $keyname = 'plg_managecustomerstatus_price' . $key;

            if ($arrList[$keyname] != '') {
				$arrWhereVal = array();
				$arrWhereVal['product_id'] = $product_id;
				$arrWhereVal['product_class_id'] = $product_class_id;
				$arrWhereVal['status_id'] = $key;
				$arrWhereVal['price'] = $arrList[$keyname];
				$objQuery->insert('plg_managecustomerstatus_dtb_price', $arrWhereVal);
            }
        }
    }
	
    /**
     * 会員別非表示設定の登録を行う.
     *
     * @param SC_Query $objQuery SC_Queryインスタンス
     * @param array $arrList 商品規格情報配列
     * @param integer $product_id 商品ID
     * @return void
     */
    function lfRegistRankDisp($objQuery, $arrList, $product_id) {
        $objQuery->delete('plg_managecustomerstatus_dtb_product_disp', 'product_id = ?', array($product_id));

		$arrStatus_id = explode(',',$arrList['plg_managecustomerstatus_product_disp']);
        foreach ($arrStatus_id as $status_id) {
			if($status_id > 0){
				$arrWhereVal = array();
				$arrWhereVal['product_id'] = $product_id;
				$arrWhereVal['status_id'] = $status_id;
				$objQuery->insert('plg_managecustomerstatus_dtb_product_disp', $arrWhereVal);
			}
        }
    }
}