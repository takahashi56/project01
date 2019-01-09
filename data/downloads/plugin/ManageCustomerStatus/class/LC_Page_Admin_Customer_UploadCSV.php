<?php
/*
 * ManageCustomerStatus
 * Copyright (C) 2014 Bratech CO.,LTD. All Rights Reserved.
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

class LC_Page_Admin_Customer_UploadCSV extends LC_Page_Admin_Ex {

    // }}}
    // {{{ functions

    /** TAGエラーチェックフィールド情報 */
    var $arrTagCheckItem;

    /** 商品テーブルカラム情報 (登録処理用) **/
    var $arrProductColumn;

    /** 商品規格テーブルカラム情報 (登録処理用) **/
    var $arrProductClassColumn;

    /** 登録フォームカラム情報 **/
    var $arrFormKeyList;

    var $arrRowErr;

    var $arrRowResult;

    /**
     * Page を初期化する.
     *
     * @return void
     */
    function init() {
        parent::init();
        $this->tpl_mainpage = PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/templates/admin/customer/upload_csv.tpl';
        $this->tpl_subnavi = 'customer/subnavi.tpl';
        $this->tpl_mainno = 'customer';
        $this->tpl_subno = 'upload_csv';
        $this->tpl_subtitle = '会員ランクCSV登録';
        $this->csv_id = '2';

        $this->arrInfo = SC_Helper_DB_Ex::sfGetBasisData();
        $this->arrTagCheckItem = array();
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
        $this->objDb = new SC_Helper_DB_Ex();

        // CSV管理ヘルパー
        $objCSV = new SC_Helper_CSV_Ex();

        // CSVファイルアップロード情報の初期化
        $objUpFile = new SC_UploadFile_Ex(CSV_TEMP_REALDIR, CSV_TEMP_REALDIR);
        $this->lfInitFile($objUpFile);

        // パラメータ情報の初期化
        $objFormParam = new SC_FormParam_Ex();
        $this->lfInitParam($objFormParam);

        $objFormParam->setHtmlDispNameArray();
        $this->arrTitle = $objFormParam->getHtmlDispNameArray();

        switch($this->getMode()) {
        case 'csv_upload':
            $this->doUploadCsv($objFormParam, $objUpFile);
            break;
        default:
            break;
        }
    }

    /**
     * 登録/編集結果のメッセージをプロパティへ追加する
     *
     * @param integer $line_count 行数
     * @param stirng $message メッセージ
     * @return void
     */
    function addRowResult($line_count, $message) {
        $this->arrRowResult[] = $line_count . "行目：" . $message;
    }

    /**
     * 登録/編集結果のエラーメッセージをプロパティへ追加する
     *
     * @param integer $line_count 行数
     * @param stirng $message メッセージ
     * @return void
     */
    function addRowErr($line_count, $message) {
        $this->arrRowErr[] = $line_count . "行目：" . $message;
    }

    /**
     * CSVアップロードを実行します.
     *
     * @return void
     */
    function doUploadCsv(&$objFormParam, &$objUpFile) {
        // ファイルアップロードのチェック
        $objUpFile->makeTempFile('csv_file');
        $arrErr = $objUpFile->checkExists();
        if (count($arrErr) > 0) {
            $this->arrErr = $arrErr;
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
             SC_Utils_Ex::sfDispError("");
        }

        // 登録先テーブル カラム情報の初期化
        $this->lfInitTableInfo();

        // 登録フォーム カラム情報
        $this->arrFormKeyList = $objFormParam->getKeyList();

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
                $this->addRowErr($line_count, "※ 項目数が" . $col_count . "個検出されました。項目数は" . $col_max_count . "個になります。");
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
            $arrCSVErr = $this->lfCheckError($objFormParam);

            // 入力エラーチェック
            if (count($arrCSVErr) > 0) {
                foreach ($arrCSVErr as $err) {
                    $this->addRowErr($line_count, $err);
                }
                $errFlag = true;
                break;
            }

            if ($all_line_checked) {
                $this->lfRegist($objFormParam);
                $arrParam = $objFormParam->getHashArray();

                $this->addRowResult($line_count, "会員ID：".$arrParam['customer_id']);
            }
        }

        // 実行結果画面を表示
        $this->tpl_mainpage = PLUGIN_UPLOAD_REALDIR . 'ManageCustomerStatus/templates/admin/customer/upload_csv_complete.tpl';

        fclose($fp);
		
		// アップロードファイルを削除
		SC_Helper_FileManager_Ex::deleteFile($enc_filepath);
		SC_Helper_FileManager_Ex::deleteFile($filepath);

        if ($errFlag) {
            $objQuery->rollback();
            return;
        }

        $objQuery->commit();

        return;
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
     * ファイル情報の初期化を行う.
     *
     * @return void
     */
    function lfInitFile(&$objUpFile) {
        $objUpFile->addFile("CSVファイル", 'csv_file', array('csv'), CSV_SIZE, true, 0, 0, false);
    }

    /**
     * 入力情報の初期化を行う.
     *
     * @param array CSV構造設定配列
     * @return void
     */
    function lfInitParam(&$objFormParam) {		
		$objFormParam->addParam("会員ID",'customer_id',INT_LEN,'n',array('EXIST_CHECK','NUM_CHECK', 'MAX_LENGTH_CHECK'));
		$objFormParam->addParam("会員名(姓)",'name01',STEXT_LEN,'KVa',array());
		$objFormParam->addParam("会員名(名)",'name02',STEXT_LEN,'KVa',array());
		$objFormParam->addParam("会員ランク名",'customer_rank',STEXT_LEN,'KVa',array('EXIST_CHECK','SPTAB_CHECK', 'MAX_LENGTH_CHECK'));
    }
	
	function lfRegist(&$objFormParam){
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		
        // 登録データ対象取得
        $arrList = $objFormParam->getHashArray();
		
		if(strlen($arrList['customer_rank']) > 0){
			$status_id = $objQuery->get('status_id','plg_managecustomerstatus_dtb_customer_status','name = ?',array($arrList['customer_rank']));
			$arrList['plg_managecustomerstatus_status'] = $status_id;
			if($arrList['customer_rank'] == 'ランクなし')$arrList['plg_managecustomerstatus_status'] = 0;
		}
		
		$sqlval = SC_Utils_Ex::sfArrayIntersectKeys($arrList, $this->arrCustomerColumn);
        if ($sqlval['customer_id'] != '') {
            $where = 'customer_id = ?';
            $objQuery->update('dtb_customer', $sqlval, $where, array($sqlval['customer_id']));
        }
	}



    /**
     * 入力チェックを行う.
     *
     * @return void
     */
    function lfCheckError(&$objFormParam) {
        // 入力データを渡す。
		$arrErr = array();
        $arrRet =  $objFormParam->getHashArray();
        $objErr = new SC_CheckError_Ex($arrRet);
        $objErr->arrErr = $objFormParam->checkError(false);
		
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$customer_rank = $objFormParam->getValue('customer_rank');
		$status_id = $objQuery->get('status_id','plg_managecustomerstatus_dtb_customer_status','name = ?',array($customer_rank));
		if(empty($status_id) && $customer_rank != 'ランクなし')$arrErr['customer_rank'] = "※ 指定された会員ランクは存在しません<br>";
		
        return array_merge($objErr->arrErr,$arrErr);
    }	

    /**
     * 保存先テーブル情報の初期化を行う.
     *
     * @return void
     */
    function lfInitTableInfo() {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $this->arrCustomerColumn = $objQuery->listTableFields('dtb_customer');
    }

    // TODO: ここから下のルーチンは汎用ルーチンとして移動が望ましい

    /**
     * 指定された行番号をmicrotimeに付与してDB保存用の時間を生成する。
     * トランザクション内のnow()は全てcommit()時の時間に統一されてしまう為。
     *
     * @param string $line_no 行番号
     * @return string $time DB保存用の時間文字列
     */
    function lfGetDbFormatTimeWithLine($line_no = '') {
        $time = date("Y-m-d H:i:s");
        // 秒以下を生成
        if($line_no != '') {
            $microtime = sprintf("%06d", $line_no);
            $time .= ".$microtime";
        }
        return $time;
    }

    /**
     * 指定されたキーと複数値の有効性の配列内確認
     *
     * @param string $arr チェック対象配列
     * @param string $keyname フォームキー名
     * @param array  $item 入力データ配列
     * @param string $delimiter 分割文字
     * @return boolean true:有効なデータがある false:有効ではない
     */
    function lfIsArrayRecordMulti($arr, $keyname, $item, $delimiter = ',') {
        if(array_search($keyname, $this->arrFormKeyList) === FALSE) {
            return true;
        }
        if($item[$keyname] == "") {
            return true;
        }
        $arrItems = explode($delimiter, $item[$keyname]);
        //空項目のチェック 1つでも空指定があったら不正とする。
        if(array_search("", $arrItems) !== FALSE) {
            return false;
        }
        //キー項目への存在チェック
        foreach($arrItems as $item) {
            if(!array_key_exists($item, $arr)) {
                return false;
            }
        }
        return true;
    }

    /**
     * 指定されたキーと複数値の有効性のDB確認
     *
     * @param string $table テーブル名
     * @param string $tblkey テーブルキー名
     * @param string $keyname フォームキー名
     * @param array  $item 入力データ配列
     * @param string $delimiter 分割文字
     * @return boolean true:有効なデータがある false:有効ではない
     */
    function lfIsDbRecordMulti($table, $tblkey, $keyname, $item, $delimiter = ',') {
        if(array_search($keyname, $this->arrFormKeyList) === FALSE) {
            return true;
        }
        if($item[$keyname] == "") {
            return true;
        }
        $arrItems = explode($delimiter, $item[$keyname]);
        //空項目のチェック 1つでも空指定があったら不正とする。
        if(array_search("", $arrItems) !== FALSE) {
            return false;
        }
        $count = count($arrItems);
        $where = $tblkey ." IN (" . implode(",", array_fill(0, $count, "?")) . ")";

        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $db_count = $objQuery->count($table, $where, $arrItems);
        if($count != $db_count) {
            return false;
        }
        return true;
    }

    /**
     * 指定されたキーと値の有効性のDB確認
     *
     * @param string $table テーブル名
     * @param string $keyname キー名
     * @param array  $item 入力データ配列
     * @return boolean true:有効なデータがある false:有効ではない
     */
    function lfIsDbRecord($table, $keyname, $item) {
        if(array_search($keyname, $this->arrFormKeyList) !== FALSE  //入力対象である
                and $item[$keyname] != ""   // 空ではない
                and !$this->objDb->sfIsRecord($table, $keyname, (array)$item[$keyname]) //DBに存在するか
                ) {
            return false;
        }
        return true;
    }

    /**
     * 指定されたキーと値の有効性の配列内確認
     *
     * @param string $arr チェック対象配列
     * @param string $keyname キー名
     * @param array  $item 入力データ配列
     * @return boolean true:有効なデータがある false:有効ではない
     */
    function lfIsArrayRecord($arr, $keyname, $item) {
        if(array_search($keyname, $this->arrFormKeyList) !== FALSE //入力対象である
                and $item[$keyname] != "" // 空ではない
                and !array_key_exists($item[$keyname], $arr) //配列に存在するか
                ) {
            return false;
        }
        return true;
    }
	
}
?>