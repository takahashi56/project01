<?php
/*
 * SEO管理プラグイン
 * Copyright (C) 2013 BLUE STYLE
 * http://bluestyle.jp/
 */

require_once CLASS_EX_REALDIR . 'page_extends/admin/LC_Page_Admin_Ex.php';

/**
 * SEO管理 のページクラス.
 */
class LC_Page_Admin_Design_Seo extends LC_Page_Admin_Ex 
{
    var $arrApplyOtherSite = array();

    /**
     * Page を初期化する.
     *
     * @return void
     */
    function init()
    {
        parent::init();
        $this->tpl_seo = true;
        $this->tpl_mainpage = 'design/main_edit.tpl';
        $this->tpl_subno = 'seo';
        $this->tpl_mainno = 'design';
        $this->tpl_maintitle = 'デザイン管理';
        $this->tpl_subtitle = 'SEO管理';
        $masterData = new SC_DB_MasterData_Ex();
        $this->arrDeviceType = $masterData->getMasterData('mtb_device_type');
        $this->arrMetaRobotsIndex = array(
            '1' => 'index',
            '0' => 'noindex',
        );
        $this->arrMetaRobotsIndexView = array(
            '' => '',
            '1' => '○ index',
            '0' => '☓ noindex',
        );
        $this->arrMetaRobotsFollow = array(
            '1' => 'follow',
            '0' => 'nofollow',
        );
        $this->arrMetaRobotsFollowView = array(
            '' => '',
            '1' => '○ follow',
            '0' => '☓ nofollow',
        );
    }

    /**
     * Page のプロセス.
     *
     * @return void
     */
    function process()
    {
        $this->action();
        $this->sendResponse();
    }

    /**
     * Page のアクション.
     *
     * @return void
     */
    function action()
    {

        $objLayout = new SC_Helper_PageLayout_Ex();
        $objFormParam = new SC_FormParam_Ex();
        $this->lfInitParam($objFormParam);
        $objFormParam->setParam($_REQUEST);
        $objFormParam->convParam();

        $this->device_type_id = $objFormParam->getValue('device_type_id', DEVICE_TYPE_PC);
        $this->arrPageList = $objLayout->getPageProperties($this->device_type_id, null);
        array_walk($this->arrPageList, array($this, 'extractRobots'));
        $arrFormValueMetaRobotsIndex = $objFormParam->getValue('meta_robots_index');
        $arrFormValueMetaRobotsFollow = $objFormParam->getValue('meta_robots_follow');
        $arrFormValueMetaRobotsOther = $objFormParam->getValue('meta_robots_other');
        $arrMetaRobotsForParam = array();
        foreach ($this->arrPageList as $index => &$arrRow) {
            // ▼一覧表用
            if (strlen($arrRow['keyword']) === 0) {
                $arrRow['keyword_count'] = 0;
            } else {
                $arrRow['keyword_count'] = preg_match_all('/,/', $arrRow['keyword']) + 1;
            }
            // ▲一覧表用
            $arrMetaRobots = array();
            if (isset($this->arrMetaRobotsIndex[$arrFormValueMetaRobotsIndex[$index]])) {
                $arrMetaRobots[] = $this->arrMetaRobotsIndex[$arrFormValueMetaRobotsIndex[$index]];
            }
            if (isset($this->arrMetaRobotsFollow[$arrFormValueMetaRobotsFollow[$index]])) {
                $arrMetaRobots[] = $this->arrMetaRobotsFollow[$arrFormValueMetaRobotsFollow[$index]];
            }
            if (strlen($arrFormValueMetaRobotsOther[$index]) >= 1) {
                $arrMetaRobots[] = $arrFormValueMetaRobotsOther[$index];
            }
            $arrMetaRobotsForParam[$index] = implode(',', $arrMetaRobots);
        }
        $objFormParam->setValue('meta_robots', $arrMetaRobotsForParam);

        $objFormParam->convParam();
        $this->arrErr = $objFormParam->checkError();
        $is_error = (!SC_Utils_Ex::isBlank($this->arrErr));

        $this->page_id = $objFormParam->getValue('page_id');

        switch ($this->getMode()) {
            // 登録/編集
            case 'confirm':
                if (!$is_error) {
                    $this->arrErr = $this->lfCheckError($objFormParam, $this->arrErr);
                    if (SC_Utils_Ex::isBlank($this->arrErr)) {
                        $result = $this->doRegister($objFormParam, $objLayout);
                        if ($result !== false) {
                            $arrQueryString = array(
                                'device_type_id' => $this->device_type_id,
                                'page_id' => $result,
                                'msg' => 'on',
                            );
                            $arrQueryString['seo'] = '1';
                            SC_Response_Ex::reload($arrQueryString, true);
                            SC_Response_Ex::actionExit();
                        }
                    }
                }
                break;

            default:
                if (isset($_GET['msg']) && $_GET['msg'] == 'on') {
                    $this->tpl_onload = "alert('登録が完了しました。');";
                }
                // データの取得
                $arrPageData = $this->getTplMainpage($this->device_type_id, $objLayout);
                $objFormParam->setParam(SC_Utils_Ex::sfSwapArray($arrPageData));
                break;
        }

        if (!$is_error) {
        } else {
            // 画面にエラー表示しないため, ログ出力
            GC_Utils_Ex::gfPrintLog('Error: ' . print_r($this->arrErr, true));
        }
        $this->tpl_subtitle = $this->arrDeviceType[$this->device_type_id] . '＞' . $this->tpl_subtitle;
        $this->arrForm = $objFormParam->getFormParamList();

        foreach ($this->arrDeviceType as $device_type_id => $val) {
            // 管理画面と編集中の端末種別サイトは除外する
            if ($device_type_id == DEVICE_TYPE_ADMIN || $device_type_id == $this->device_type_id) {
                continue 1;
            }
            $this->arrApplyOtherSite[$device_type_id] = $val . 'サイトにも適用する';
        }
    }

    /**
     * デストラクタ.
     *
     * @return void
     */
    function destroy()
    {
        parent::destroy();
    }

    /**
     * パラメーター情報の初期化
     *
     * XXX URL のフィールドは, 実際は filename なので注意
     *
     * @param object $objFormParam SC_FormParamインスタンス
     * @return void
     */
    function lfInitParam(&$objFormParam)
    {
        $objFormParam->addParam('ページID', 'page_id', INT_LEN, 'n', array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('端末種別ID', 'device_type_id', INT_LEN, 'n', array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('名称', 'page_name', STEXT_LEN, 'KVa', array('SPTAB_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('URL', 'filename');
        $objFormParam->addParam('修正フラグ', 'edit_flg');
        $objFormParam->addParam('meta タグ:author', 'author', MTEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
        $objFormParam->addParam('meta タグ:description', 'description', MTEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
        $objFormParam->addParam('meta タグ:keyword', 'keyword', MTEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
        $objFormParam->addParam('meta タグ:robots', 'meta_robots', MTEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
        $objFormParam->addParam('meta タグ:robots - index', 'meta_robots_index', INT_LEN, 'n', array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('meta タグ:robots - follow', 'meta_robots_follow', INT_LEN, 'n', array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('meta タグ:robots - 他', 'meta_robots_other', MTEXT_LEN, 'KVa', array('MAX_LENGTH_CHECK'));
        $objFormParam->addParam('他端末種別サイトへの反映', 'apply_other_site', INT_LEN, 'n', array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
    }

    /**
     * ページデータを取得する.
     *
     * @param integer $device_type_id 端末種別ID
     * @param integer $page_id ページID
     * @param SC_Helper_PageLayout $objLayout SC_Helper_PageLayout インスタンス
     * @return array ページデータの配列
     */
    function getTplMainpage($device_type_id, $objLayout)
    {
        $arrPageData = $objLayout->getPageProperties($device_type_id);
        $arrReturn = array();

        foreach ($arrPageData as &$arrRow) {
            $this->extractRobots($arrRow);
        }

        return $arrPageData;
    }

    function extractRobots(&$arrRow) {
        $arrRow['meta_robots_index'] = '';
        $arrRow['meta_robots_follow'] = '';
        $arrOther = array();
        foreach (explode(',', $arrRow['meta_robots']) as $val) {
            $val = SC_Utils_Ex::trim($val);
            if ($val === 'index') {
                $arrRow['meta_robots_index'] = 1;
            } else if ($val === 'noindex') {
                $arrRow['meta_robots_index'] = 0;
            } else if ($val === 'follow') {
                $arrRow['meta_robots_follow'] = 1;
            } else if ($val === 'nofollow') {
                $arrRow['meta_robots_follow'] = 0;
            } else {
                $arrOther[] = $val;
            }
        }
        $arrRow['meta_robots_other'] = implode(',', $arrOther);
    }

    /**
     * 登録を実行する.
     *
     * ファイルの作成に失敗した場合は, エラーメッセージを出力し,
     * データベースをロールバックする.
     *
     * @param SC_FormParam $objFormParam SC_FormParam インスタンス
     * @param SC_Helper_PageLayout $objLayout SC_Helper_PageLayout インスタンス
     * @return integer|boolean 登録が成功した場合, 登録したページID;
     *                         失敗した場合 false
     */
    function doRegister(&$objFormParam, &$objLayout)
    {
        $objQuery =& SC_Query_Ex::getSingletonInstance();

        $objQuery->begin();

        $arrApplyOtherSite = $objFormParam->getValue('apply_other_site');
        $arrInputData = $objFormParam->getSwapArray();
        foreach ($arrInputData as $index => $arrRow) {
            $arrParams = array();
            $arrParams['device_type_id'] = $objFormParam->getValue('device_type_id');
            $arrParams['page_id']       = $arrRow['page_id'];
            $arrParams['description']   = $arrRow['description'];
            $arrParams['keyword']       = $arrRow['keyword'];
            $arrParams['meta_robots']   = $arrRow['meta_robots'];
            if ($this->arrPageList[$index]['edit_flg'] != 2) {
                $arrParams['page_name'] = $arrRow['page_name'];
            }

            $this->registerPage($arrParams);

            // 他端末種別サイトへの反映
            foreach ($arrApplyOtherSite as $dst_device_type_id) {
                $cols = 'page_id, edit_flg';
                $arrWhereVal = array($dst_device_type_id, $this->arrPageList[$index]['url']);
                $arrDst = $objQuery->getCol($cols, 'dtb_pagelayout', 'device_type_id = ? AND url = ?', $arrWhereVal);
                if (!empty($arrDst) && strlen($arrDst['page_id']) >= 1) {
                    $arrParams['device_type_id']    = $dst_device_type_id;
                    $arrParams['page_id']           = $arrDst['page_id'];
                    if ($arrDst['edit_flg'] == 2) {
                        unset($arrParams['page_name']);
                    } else {
                        $arrParams['page_name'] = $arrRow['page_name'];
                    }
                    $this->registerPage($arrParams);
                }
            }
        }

        $objQuery->commit();
        return $arrParams['page_id'];
    }

    /**
     * 入力内容をデータベースに登録する.
     *
     * @param array $arrParams フォームパラメーターの配列
     * @param SC_Helper_PageLayout $objLayout SC_Helper_PageLayout インスタンス
     * @return integer ページID
     */
    function registerPage($arrParams, &$objLayout)
    {
        $objQuery =& SC_Query_Ex::getSingletonInstance();

        $table = 'dtb_pagelayout';
        $arrValues = $objQuery->extractOnlyColsOf($table, $arrParams);
        $arrValues['update_url'] = $_SERVER['HTTP_REFERER'];
        $arrValues['update_date'] = 'CURRENT_TIMESTAMP';

        $objQuery->update($table, $arrValues, 'page_id = ? AND device_type_id = ?',
                          array($arrValues['page_id'], $arrValues['device_type_id']));

        return $arrValues['page_id'];
    }

    /**
     * エラーチェックを行う.
     *
     * @param SC_FormParam $objFormParam SC_FormParam インスタンス
     * @return array エラーメッセージの配列
     */
    function lfCheckError(&$objFormParam, &$arrErr)
    {
        $arrParams = $objFormParam->getHashArray();
        $objErr = new SC_CheckError_Ex($arrParams);
        $objErr->arrErr =& $arrErr;

        foreach ($this->arrPageList as $index => $arrRow) {
            if ($arrRow['edit_flg'] != 2) {
                $arr = array('page_name' => $arrParams['page_name'][$index]);
                $objErrTmp = new SC_CheckError_Ex($arr);
                $objErrTmp->doFunc(array('名称', 'page_name'), array('EXIST_CHECK'));
                if (strlen($objErrTmp->arrErr['page_name']) >= 1) {
                    $objErr->arrErr['page_name'][$index] .= $objErrTmp->arrErr['page_name'];
                }
            }
        }

        return $objErr->arrErr;
    }
}
