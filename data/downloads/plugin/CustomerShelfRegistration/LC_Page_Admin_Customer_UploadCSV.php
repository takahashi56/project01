<?php
/*
 * Copyright (C) 2014 Nobuhiko Kimoto
 * info@nob-log.info
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
 * CSV登録のページクラス.
 *
 * @package Page
 * @author Nobuhiko Kimoto
 * @version $Id:$
 *
 */
class LC_Page_Admin_Customer_UploadCSV extends LC_Page_Admin_Ex
{
    // }}}
    // {{{ functions

    /** TAGエラーチェックフィールド情報 */
    public $arrTagCheckItem;

    /** テーブルカラム情報 (登録処理用) **/
    public $arrCustomerColumn;

    /** 登録フォームカラム情報 **/
    public $arrFormKeyList;

    public $arrRowErr;

    public $arrRowResult;

    /**
     * Page を初期化する.
     *
     * @return void
     */
    public function init()
    {
        parent::init();
        //$this->tpl_mainpage = PLUGIN_UPLOAD_REALDIR .'CustomerShelfRegistration/templates/admin/upload_csv_customer.tpl';
        $this->tpl_mainpage = 'products/upload_csv.tpl';
        $this->tpl_mainno = 'customer';
        $this->tpl_subno = 'upload_csv';
        $this->tpl_maintitle = '会員管理';
        $this->tpl_subtitle = '会員登録CSV';
        $this->csv_id = '2';

        $masterData = new SC_DB_MasterData_Ex();
        $this->arrDISP = $masterData->getMasterData('mtb_disp');
        $this->arrSTATUS = $masterData->getMasterData('mtb_status');
        //$this->arrDELIVERYDATE = $masterData->getMasterData('mtb_delivery_date');
        //$this->arrProductType = $masterData->getMasterData('mtb_product_type');
        //$this->arrMaker = SC_Helper_DB_Ex::sfGetIDValueList('dtb_maker', 'maker_id', 'name');
        //$this->arrPayments = SC_Helper_DB_Ex::sfGetIDValueList('dtb_payment', 'payment_id', 'payment_method');
        $this->arrInfo = SC_Helper_DB_Ex::sfGetBasisData();
        $this->arrAllowedTag = $masterData->getMasterData('mtb_allowed_tag');
        $this->arrTagCheckItem = array();

        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $col = "name, id";
        $objQuery->setOrder("rank DESC");
        $arrList = $objQuery->select($col, 'mtb_pref');
        $count = count($arrList);
        for($cnt = 0; $cnt < $count; $cnt++) {
            $key = $arrList[$cnt]['name'];
            $val = $arrList[$cnt]['id'];
            $arrRet[$key] = $val;
        }
        $this->arrPref = $arrRet;

        $arrList = $objQuery->select($col, 'mtb_sex');
        $count = count($arrList);
        for($cnt = 0; $cnt < $count; $cnt++) {
            $key = $arrList[$cnt]['name'];
            $val = $arrList[$cnt]['id'];
            $arrRet[$key] = $val;
        }
        $this->arrSex = $arrRet;

        $arrList = $objQuery->select($col, 'mtb_job');
        $count = count($arrList);
        for($cnt = 0; $cnt < $count; $cnt++) {
            $key = $arrList[$cnt]['name'];
            $val = $arrList[$cnt]['id'];
            $arrRet[$key] = $val;
        }
        $this->arrJob = $arrRet;
    }

    /**
     * Page のプロセス.
     *
     * @return void
     */
    public function process()
    {
        $this->action();
        $this->sendResponse();
    }

    /**
     * Page のアクション.
     *
     * @return void
     */
    public function action()
    {
        $this->objDb = new SC_Helper_DB_Ex();

        // CSV管理ヘルパー
        $objCSV = new SC_Helper_CSV_Ex();
        // CSV構造読み込み
        $arrCSVFrame = $objCSV->sfGetCsvOutput($this->csv_id);

        // CSV構造がインポート可能かのチェック
        if (!$objCSV->sfIsImportCSVFrame($arrCSVFrame)) {
            // 無効なフォーマットなので初期状態に強制変更
            $arrCSVFrame = $objCSV->sfGetCsvOutput($this->csv_id, '', array(), 'no');
            $this->tpl_is_format_default = true;
        }
        // CSV構造は更新可能なフォーマットかのフラグ取得
        $this->tpl_is_update = $objCSV->sfIsUpdateCSVFrame($arrCSVFrame);

        // CSVファイルアップロード情報の初期化
        $objUpFile = new SC_UploadFile_Ex(CSV_TEMP_REALDIR, CSV_TEMP_REALDIR);
        $this->lfInitFile($objUpFile);

        // パラメーター情報の初期化
        $objFormParam = new SC_FormParam_Ex();
        $this->lfInitParam($objFormParam, $arrCSVFrame);

        $objFormParam->setHtmlDispNameArray();
        $this->arrTitle = $objFormParam->getHtmlDispNameArray();

        switch ($this->getMode()) {
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
     * @param  integer $line_count 行数
     * @param  stirng  $message    メッセージ
     * @return void
     */
    public function addRowResult($line_count, $message)
    {
        $this->arrRowResult[] = $line_count . '行目：' . $message;
    }

    /**
     * 登録/編集結果のエラーメッセージをプロパティへ追加する
     *
     * @param  integer $line_count 行数
     * @param  stirng  $message    メッセージ
     * @return void
     */
    public function addRowErr($line_count, $message)
    {
        $this->arrRowErr[] = $line_count . '行目：' . $message;
    }

    /**
     * CSVアップロードを実行します.
     *
     * @return void
     */
    public function doUploadCsv(&$objFormParam, &$objUpFile)
    {
        // ファイルアップロードのチェック
        $this->arrErr['csv_file'] = $objUpFile->makeTempFile('csv_file');
        if (strlen($this->arrErr['csv_file']) >= 1) {
            return;
        }
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
            SC_Utils_Ex::sfDispError('');
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
                $headerLine = $arrCSV;
                continue;
            }
            // 空行はスキップ
            if (empty($arrCSV)) {
                continue;
            }
            // 列数が異なる場合はエラー
            $col_count = count($arrCSV);
            if ($col_max_count != $col_count) {
                $this->addRowErr($line_count, '※ 項目数が' . $col_count . '個検出されました。項目数は' . $col_max_count . '個になります。');
                $errFlag = true;
                break;
            }
            // シーケンス配列を格納する。
            // fixme $headerLineの順番で登録するので処理が重くなる
            // fixme 2.12系と処理が違う？
            $objFormParam->setParam($arrCSV, true);
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
                $arrList = $objFormParam->getHashArray();
                // 登録時間を生成(DBのCURRENT_TIMESTAMPだとcommitした際、すべて同一の時間になってしまう)
                $arrList['update_date'] = $this->lfGetDbFormatTimeWithLine($line);

                // 登録情報を生成する。
                // テーブルのカラムに存在しているもののうち、Form投入設定されていないデータは上書きしない。
                $sqlval = SC_Utils_Ex::sfArrayIntersectKeys($arrList, $this->arrCustomerColumn);

                // 必須入力では無い項目だが、空文字では問題のある特殊なカラム値の初期値設定
                $sqlval = $this->lfSetDefaultData($sqlval);
                // todo すでにあるcustomer_idを指定された場合は上書き、という仕様にしないと…
                SC_Helper_Customer_Ex::sfEditCustomerData($sqlval, $sqlval['customer_id']);

                $this->addRowResult($line_count, '会員ID：'.$arrList['customer_id'] . ' / 会員名：' . $arrList['name01']);
            }
            SC_Utils_Ex::extendTimeOut();
        }

        // 実行結果画面を表示
        $this->tpl_mainpage = 'products/upload_csv_complete.tpl';

        fclose($fp);

        if ($errFlag) {
            $objQuery->rollback();

            return;
        }
        $objQuery->commit();
    }


    /**
     * データ登録前に特殊な値の持ち方をする部分のデータ部分の初期値補正を行う
     *
     * @param array $sqlval 商品登録情報配列
     * @return $sqlval 登録情報配列
     */
    public function lfSetDefaultData($sqlval)
    {
        //新規登録時のみ設定する項目
        if ($sqlval['customer_id'] == '') {
            if ($sqlval['status'] == '') {
                $sqlval['status'] = (CUSTOMER_CONFIRM_MAIL == true) ? '1' : '2'; // デフォルト
            }
            //共通で空欄時に上書きする項目
            if ($sqlval['password'] == '') {
                unset($sqlval['password']);
            }
            if ($sqlval['reminder_answer'] == '') {
                unset($sqlval['reminder_answer']);
            }
        }

        // 不要だがユニークで引っかかるので
        if ($sqlval['secret_key'] == '') {
            $sqlval['secret_key'] = SC_Helper_Customer_Ex::sfGetUniqSecretKey();
        }

        //共通で空欄時に上書きする項目
        if ($sqlval['del_flg'] == '') {
            $sqlval['del_flg'] = '0'; //有効
        }

        //共通で空欄時に上書きする項目
        if ($sqlval['point'] == '') {
            $sqlval['point'] = '0';
        }
        //共通で空欄時に上書きする項目
        if ($sqlval['create_date'] == '') {
            $sqlval['create_date'] = 'CURRENT_TIMESTAMP';
        }

        return $sqlval;
    }

    /**
     * ファイル情報の初期化を行う.
     *
     * @return void
     */
    public function lfInitFile(&$objUpFile)
    {
        $objUpFile->addFile('CSVファイル', 'csv_file', array('csv'), CSV_SIZE, true, 0, 0, false);
    }

    /**
     * 入力情報の初期化を行う.
     *
     * @param array CSV構造設定配列
     * @return void
     */
    public function lfInitParam($objFormParam, $arrCSVFrame)
    {
        // 固有の初期値調整
        $arrCSVFrame = $this->lfSetParamDefaultValue($arrCSVFrame);
        // CSV項目毎の処理
        foreach ($arrCSVFrame as $item) {
            if ($item['status'] != CSV_COLUMN_STATUS_FLG_ENABLE) continue;
            //サブクエリ構造の場合は AS名 を使用
            if (preg_match_all('/\(.+\)\s+as\s+(.+)$/i', $item['col'], $match, PREG_SET_ORDER)) {
                $col = $match[0][1];
            } else {
                $col = $item['col'];
            }
            // HTML_TAG_CHECKは別途実行なので除去し、別保存しておく
            if (strpos(strtoupper($item['error_check_types']), 'HTML_TAG_CHECK') !== FALSE) {
                $this->arrTagCheckItem[] = $item;
                $error_check_types = str_replace('HTML_TAG_CHECK', '', $item['error_check_types']);
            } else {
                $error_check_types = $item['error_check_types'];
            }
            $arrErrorCheckTypes = explode(',', $error_check_types);
            foreach ($arrErrorCheckTypes as $key => $val) {
                if (trim($val) == '') {
                    unset($arrErrorCheckTypes[$key]);
                } else {
                    $arrErrorCheckTypes[$key] = trim($val);
                }
            }
            // パラメーター登録
            $objFormParam->addParam(
                $item['disp_name']
                , $col
                , constant($item['size_const_type'])
                , $item['mb_convert_kana_option']
                , $arrErrorCheckTypes
                , $item['default']
                , ($item['rw_flg'] != CSV_COLUMN_RW_FLG_READ_ONLY) ? true : false
            );
        }
    }

    /**
     * 入力チェックを行う.
     *
     * @return void
     */
    public function lfCheckError(&$objFormParam)
    {
        // 入力データを渡す。
        $arrRet =  $objFormParam->getHashArray();
        $objErr = new SC_CheckError_Ex($arrRet);
        $objErr->arrErr = $objFormParam->checkError(false);
        // HTMLタグチェックの実行
        foreach ($this->arrTagCheckItem as $item) {
            $objErr->doFunc(array($item['disp_name'], $item['col'], $this->arrAllowedTag), array('HTML_TAG_CHECK'));
        }
        // このフォーム特有の複雑系のエラーチェックを行う
        if (count($objErr->arrErr) == 0) {
            $objErr->arrErr = $this->lfCheckErrorDetail($arrRet, $objErr->arrErr, $objFormParam);
        }

        return $objErr->arrErr;
    }

    /**
     * 保存先テーブル情報の初期化を行う.
     *
     * @return void
     */
    public function lfInitTableInfo()
    {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $this->arrCustomerColumn = $objQuery->listTableFields('dtb_customer');
    }

    /**
     * 初期値の設定
     *
     * @param  array $arrCSVFrame CSV構造配列
     * @return array $arrCSVFrame CSV構造配列
     */
    public function lfSetParamDefaultValue(&$arrCSVFrame)
    {
        foreach ($arrCSVFrame as $key => $val) {
            switch ($val['col']) {
            case 'status':
                $arrCSVFrame[$key]['default'] = '1';
                break;
            case 'del_flg':
                $arrCSVFrame[$key]['default'] = '0';
                break;
            default:
                break;
            }
        }

        return $arrCSVFrame;
    }

    /**
     * このフォーム特有の複雑な入力チェックを行う.
     *
     * @param array 確認対象データ
     * @param array エラー配列
     * @return array エラー配列
     */
    public function lfCheckErrorDetail($item, $arrErr, $objFormParam)
    {
        $masterData = new SC_DB_MasterData_Ex();

        // 表示ステータスの存在チェック
        if (!$this->lfIsArrayRecord($this->arrDISP, 'status', $item)) {
            $arrErr['status'] = '※ 指定の表示ステータスは、登録されていません。';
        }

        // 都道府県チェック
        if (array_search('pref', $this->arrFormKeyList) !== FALSE
            && $item['pref'] != ''
        ) {

            if (!is_numeric($item['pref'])) {
                $arrErr['pref'] = '※ 都道府県は、数字で入力してください。';
            } else {
                $arrPref = $masterData->getMasterData('mtb_pref');
                if (!$this->lfIsArrayRecord($arrPref, 'pref', $item)) {
                    $arrErr['pref'] = '※ 指定の都道府県は、登録されていません。';
                }
            }
        }


        // 性別チェック
        if (array_search('sex', $this->arrFormKeyList) !== FALSE
            && $item['sex'] != ''
        ) {

            if (!is_numeric($item['sex'])) {
                $arrErr['sex'] = '※ 性別は、数字で入力してください。';
            } else {
                $arrSex = $masterData->getMasterData('mtb_sex');
                if (!$this->lfIsArrayRecord($arrSex, 'sex', $item)) {
                    $arrErr['sex'] = '※ 指定の性別は、登録されていません。';
                }
            }
        }

        // 職業チェック
        if (array_search('job', $this->arrFormKeyList) !== FALSE
            && $item['job'] != ''
        ) {
            if (!is_numeric($item['job'])) {
                $arrErr['job'] = '※ 職業は、数字で入力してください。';
            } else {
                $arrJob = $masterData->getMasterData('mtb_job');
                if (!$this->lfIsArrayRecord($arrJob, 'job', $item)) {
                    $arrErr['job'] = '※ 指定の職業は、登録されていません。';
                }
            }
        }


        // 誕生日
        if (array_search('birth', $this->arrFormKeyList) !== FALSE
            && $item['birth'] != ''
        ) {
            /*
            if (version_compare(PHP_VERSION, '5.3.0') >= 0) {
                DateTime::createFromFormat('Y-m-d', $item['birth']);
                $info = DateTime::getLastErrors();
                if ( $info['errors'] || $info['warnings']) {
                    $arrErr['birth'] = '※ 誕生日が正しくありません。';
                }
            }*/
        }

        // 削除フラグのチェック
        if (array_search('del_flg', $this->arrFormKeyList) !== FALSE
            && $item['del_flg'] != ''
        ) {
            if (!($item['del_flg'] == '0' || $item['del_flg'] == '1')) {
                $arrErr['del_flg'] = '※ 削除フラグは「0」(有効)、「1」(削除)のみが有効な値です。';
            }
        }

        if (SC_Utils_Ex::isBlank($item['email'])) {
            $arrErr['email'] = '※ メールアドレスは必須項目です。';
        }
        // 削除フラグのチェック
        // メアド重複チェック(共通ルーチンは使えない)
        $objQuery   =& SC_Query_Ex::getSingletonInstance();
        $col = 'email, email_mobile, customer_id';
        $table = 'dtb_customer';
        $where = 'del_flg <> 1 AND (email Like ? OR email_mobile Like ?)';
        $arrVal = array($objFormParam->getValue('email'), $objFormParam->getValue('email_mobile'));
        if ($objFormParam->getValue('customer_id')) {

            $arrData = $objQuery->getRow($col, $table, 'del_flg <> 1 AND customer_id = ?', array($objFormParam->getValue('customer_id')));

            if (SC_Utils_Ex::isBlank($arrData['customer_id'])) {
                $arrErr['customer_id'] = '※ 指定の会員IDは、登録されていません。新規登録の場合は未入力で登録してください。';
            }

            $where .= ' AND customer_id <> ?';
            $arrVal[] = $objFormParam->getValue('customer_id');
        }
        $arrData = $objQuery->getRow($col, $table, $where, $arrVal);
        if (!SC_Utils_Ex::isBlank($arrData['email'])) {
            if ($arrData['email'] == $objFormParam->getValue('email')) {
                $arrErr['email'] = '※ すでに他の会員(ID:' . $arrData['customer_id'] . ')が使用しているアドレスです。';
            } elseif ($arrData['email'] == $objFormParam->getValue('email_mobile')) {
                $arrErr['email_mobile'] = '※ すでに他の会員(ID:' . $arrData['customer_id'] . ')が使用しているアドレスです。';
            }
        }
        if (!SC_Utils_Ex::isBlank($arrData['email_mobile'])) {
            if ($arrData['email_mobile'] == $objFormParam->getValue('email_mobile')) {
                $arrErr['email_mobile'] = '※ すでに他の会員(ID:' . $arrData['customer_id'] . ')が使用している携帯アドレスです。';
            } elseif ($arrData['email_mobile'] == $objFormParam->getValue('email')) {
                if ($arrErr['email'] == '') {
                    $arrErr['email'] = '※ すでに他の会員(ID:' . $arrData['customer_id'] . ')が使用している携帯アドレスです。';
                }
            }
        }

        return $arrErr;
    }

    // TODO: ここから下のルーチンは汎用ルーチンとして移動が望ましい

    /**
     * 指定された行番号をmicrotimeに付与してDB保存用の時間を生成する。
     * トランザクション内のCURRENT_TIMESTAMPは全てcommit()時の時間に統一されてしまう為。
     *
     * @param  string $line_no 行番号
     * @return string $time DB保存用の時間文字列
     */
    public function lfGetDbFormatTimeWithLine($line_no = '')
    {
        $time = date('Y-m-d H:i:s');
        // 秒以下を生成
        if ($line_no != '') {
            $microtime = sprintf('%06d', $line_no);
            $time .= ".$microtime";
        }

        return $time;
    }

    /**
     * 指定されたキーと複数値の有効性の配列内確認
     *
     * @param  string  $arr       チェック対象配列
     * @param  string  $keyname   フォームキー名
     * @param  array   $item      入力データ配列
     * @param  string  $delimiter 分割文字
     * @return boolean true:有効なデータがある false:有効ではない
     */
    public function lfIsArrayRecordMulti($arr, $keyname, $item, $delimiter = ',')
    {
        if (array_search($keyname, $this->arrFormKeyList) === FALSE) {
            return true;
        }
        if ($item[$keyname] == '') {
            return true;
        }
        $arrItems = explode($delimiter, $item[$keyname]);
        //空項目のチェック 1つでも空指定があったら不正とする。
        if (array_search('', $arrItems) !== FALSE) {
            return false;
        }
        //キー項目への存在チェック
        foreach ($arrItems as $item) {
            if (!array_key_exists($item, $arr)) {
                return false;
            }
        }

        return true;
    }

    /**
     * 指定されたキーと複数値の有効性のDB確認
     *
     * @param  string  $table     テーブル名
     * @param  string  $tblkey    テーブルキー名
     * @param  string  $keyname   フォームキー名
     * @param  array   $item      入力データ配列
     * @param  string  $delimiter 分割文字
     * @return boolean true:有効なデータがある false:有効ではない
     */
    public function lfIsDbRecordMulti($table, $tblkey, $keyname, $item, $delimiter = ',')
    {
        if (array_search($keyname, $this->arrFormKeyList) === FALSE) {
            return true;
        }
        if ($item[$keyname] == '') {
            return true;
        }
        $arrItems = explode($delimiter, $item[$keyname]);
        //空項目のチェック 1つでも空指定があったら不正とする。
        if (array_search('', $arrItems) !== FALSE) {
            return false;
        }
        $count = count($arrItems);
        $where = $tblkey .' IN (' . SC_Utils_Ex::repeatStrWithSeparator('?', $count) . ')';

        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $db_count = $objQuery->count($table, $where, $arrItems);
        if ($count != $db_count) {
            return false;
        }

        return true;
    }

    /**
     * 指定されたキーと値の有効性のDB確認
     *
     * @param  string  $table   テーブル名
     * @param  string  $keyname キー名
     * @param  array   $item    入力データ配列
     * @return boolean true:有効なデータがある false:有効ではない
     */
    public function lfIsDbRecord($table, $keyname, $item)
    {
        if (array_search($keyname, $this->arrFormKeyList) !== FALSE  //入力対象である
            && $item[$keyname] != ''   // 空ではない
            && !$this->objDb->sfIsRecord($table, $keyname, (array) $item[$keyname]) //DBに存在するか
        ) {
        return false;
        }

        return true;
    }

    /**
     * 指定されたキーと値の有効性の配列内確認
     *
     * @param  string  $arr     チェック対象配列
     * @param  string  $keyname キー名
     * @param  array   $item    入力データ配列
     * @return boolean true:有効なデータがある false:有効ではない
     */
    public function lfIsArrayRecord($arr, $keyname, $item)
    {
        if (array_search($keyname, $this->arrFormKeyList) !== FALSE //入力対象である
            && $item[$keyname] != '' // 空ではない
            && !array_key_exists($item[$keyname], $arr) //配列に存在するか
        ) {
        return false;
        }

        return true;
    }
}
