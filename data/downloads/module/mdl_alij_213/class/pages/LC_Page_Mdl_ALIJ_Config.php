<?php
// {{{ requires
require_once(CLASS_EX_REALDIR . "page_extends/admin/LC_Page_Admin_Ex.php");
require_once(MDL_ALIJ_CLASS_PATH . "LC_Mdl_ALIJ.php");


define ("SITEPASS_LEN", 20);
define ("SITEID_LEN", 20);

/**
 * ALIJ決済モジュールの管理画面設定のページクラス.
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id: LC_Page_Mdl_ALIJ_Config.php 1254 2008-04-02 10:45:16Z adachi $
 */
class LC_Page_Mdl_ALIJ_Config extends LC_Page_Admin_Ex {

		// }}}
		// {{{ functions

		/**
		 * Page を初期化する.
		 *
		 * @return void
		 */
		function init() {
				parent::init();
				$objALIJ =& LC_Mdl_ALIJ::getInstance();
				$this->tpl_mainpage = MDL_ALIJ_TEMPLATE_PATH.'config.tpl';
				$this->tpl_subtitle = $objALIJ->getName();
		}

		/**
		 * Page のプロセス.
		 *
		 * @return void
		 */
		function process() {
				$objALIJ =& LC_Mdl_ALIJ::getInstance();
				$objALIJ->install();

				$objView = new SC_AdminView;

				$mode = isset($_POST['mode']) ? $_POST['mode'] : '';

				switch($mode) {
				case 'edit':
						$this->registerMode();
						break;
				default:
						$this->defaultMode();
						break;
				}

				$objView->assignObj($this);
				$objView->display($this->tpl_mainpage);
		}

		/**
		 * デストラクタ.
		 *
		 * @return void
		 */
		function destroy() {
				parent::destroy();
		}

		/**
		 * 初回表示処理
		 *
		 */
		function defaultMode() {
				$objALIJ =& LC_Mdl_ALIJ::getInstance();
				$subData = $objALIJ->getUserSettings();
				$objForm = $this->initParam($subData);
				$this->arrForm = $objForm->getFormParamList();
		}

		/**
		 * 登録ボタン押下時の処理
		 *
		 */
		function registerMode() {
			$objForm = $this->initParam();
			if ($arrErr = $this->checkError($objForm)) {
				$this->arrErr  = $arrErr;
				$this->arrForm = $objForm->getFormParamList();
				return;
			}

			$arrForm = $objForm->getHashArray();

			$objALIJ =& LC_Mdl_ALIJ::getInstance();
			// ファイルのコピー
			$objALIJ->updateFile();
			$arrFailedFile = $objALIJ->getFailedCopyFile();
			if (count($arrFailedFile) > 0) {
				$this->arrForm = $objForm->getFormParamList();
				foreach($arrFailedFile as $file) {
					$alert = $file . 'に書き込み権限を与えてください。';
					$this->tpl_onload .= "alert('" . $alert . "');";
				}
				return;
			}

			$objALIJ->registerUserSettings($arrForm);

				// del_flgを削除にしておく
		    $del_sql = "UPDATE dtb_payment SET del_flg = 1 WHERE module_id = ? ";
		    $arrDel = array(MDL_ALIJ_ID);
				$objQuery = new SC_Query();
		    $objQuery->query($del_sql, $arrDel);


		    // 認証確認
			$objSess = new SC_Session();

			// PC用データ登録
					$arrData["payment_method"] = $objALIJ->getPaymentName();
					$arrData["fix"] = 3;
					$arrData["charge"] = "0";
					$arrData["creator_id"] = $objSess->member_id;
					$arrData["update_date"] = "now()";
					$arrData["module_id"] = MDL_ALIJ_ID;
					$arrData["module_code"] = $objALIJ->getCode( true );
					$arrData["module_path"] = MODULE_REALDIR . "mdl_alij_213/card.php";
					$arrData["memo01"] = $_POST["siteid"];
					$arrData["memo02"] = $_POST["sitepass"];
					$arrData["memo03"] = ALIJ_CREDIT_ID;
					if(isset($_POST["quickcharge"]) && $_POST["quickcharge"]==true){
						$arrData["memo04"] = "true";
					}else{
						$_POST["quickcharge"]=false;
						$arrData["memo04"] = "false";
					}
					$arrData["del_flg"] = "0";

			    // 更新データがあれば更新する。
			    // ランクの最大値を取得する
			    $max_rank = $objQuery->getone("SELECT max(rank) FROM dtb_payment");

			    // 支払方法データを取得
			    //取得にはmodule_idを使用
			    $arrPaymentData = $this->lfGetPaymentDB();


			    // データが存在していればUPDATE、無ければINSERT
			    if(count($arrPaymentData) > 0){
		            $objQuery->update("dtb_payment", array("memo01"=>"","memo02"=>"","memo03"=>"","memo04"=>"","memo05"=>""), " module_id = '" . MDL_ALIJ_ID . "'");
			        $objQuery->update("dtb_payment", $arrData, " module_id = '" . MDL_ALIJ_ID . "'");
			    }else{
					//使用可能なpayment_idを取得
					$arrData["payment_id"] = $objQuery->nextVal('dtb_payment_payment_id');
					$arrData["rank"] = $max_rank+1;
			        $objQuery->insert("dtb_payment", $arrData);
			    }

			$this->tpl_onload = 'alert("登録完了しました。\n基本情報＞支払方法設定より詳細設定をしてください。"); window.close();';
			$this->arrForm = $objForm->getFormParamList();
		}

		/**
		 * フォームパラメータ初期化
		 *
		 * @param array $arrData
		 * @return SC_FormParam
		 */
		function initParam($arrData = null) {
			if (is_null($arrData)) $arrData = $_POST;

			$objForm = new SC_FormParam();

			$objForm->addParam("SiteID", "siteid"    , SITEID_LEN    , "KVa", array("EXIST_CHECK", "MAX_LENGTH_CHECK", "SPTAB_CHECK" ,"ALNUM_CHECK"));
			$objForm->addParam("SitePASS" , "sitepass", SITEPASS_LEN, "KVa", array("EXIST_CHECK", "MAX_LENGTH_CHECK", "SPTAB_CHECK" ,"ALNUM_CHECK"));
			$objForm->addParam("Quickcharge" , "quickcharge", 10, "KVa", array());

			$objForm->setParam($arrData);
			$objForm->convParam();
			return $objForm;
		}

		/**
		 * 入力パラメータの検証
		 *
		 * @param SC_FormParam $objForm
		 * @return array|null
		 */
		function checkError($objForm) {
			if ($arrErr = $objForm->checkError()) {
				return $arrErr;
			}
			$arrForm = $objForm->getHashArray();
			if (!empty($arrForm['use_idnet'])) {

				$objIdNetForm = new SC_FormParam;

				$objIdNetForm->addParam("SiteID", "idnet_siteid"    , SITEID_LEN    , "KVa", array("EXIST_CHECK", "MAX_LENGTH_CHECK", "SPTAB_CHECK" ,"ALNUM_CHECK"));
				$objIdNetForm->addParam("SitePASS" , "idnet_sitepass", SITEPASS_LEN, "KVa", array("EXIST_CHECK", "MAX_LENGTH_CHECK", "SPTAB_CHECK" ,"ALNUM_CHECK"));

				$objIdNetForm->setParam($arrForm);
				$objIdNetForm->convParam();
				return $objIdNetForm->checkError();
			}
			return null;
		}


		// DBからデータを取得する
		function lfGetPaymentDB($where = "", $arrWhereVal = array()){
		    global $objQuery;

		    $arrVal = array(MDL_ALIJ_ID);
		    $arrVal = array_merge($arrVal, $arrWhereVal);

		    $arrRet = array();
		    $sql = "SELECT
		                module_id,
		                memo01 as siteid,
		                memo02 as sitepass,
		                memo04 as quickcharge
		            FROM dtb_payment WHERE module_id = ? " . $where;
		    $arrRet = $objQuery->getall($sql, $arrVal);

		    return $arrRet;
		}

}
/*
 * Local variables:
 * coding: utf-8
 * End:
 */
?>
