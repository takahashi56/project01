<?php
require_once CLASS_EX_REALDIR . 'page_extends/frontparts/bloc/LC_Page_FrontParts_Bloc_Ex.php';
require_once PLUGIN_UPLOAD_REALDIR ."MatrixFilterProducts/MatrixFilterProducts.php";

class LC_Page_FrontParts_Bloc_Plg_MatrixFilterProducts extends LC_Page_FrontParts_Bloc_Ex {

    function init() {
        parent::init();
    }
	
    function process() {
		$this->tpl_mainpage = 'frontparts/bloc/plg_MatrixFilterProducts.tpl';
        $this->action();
        $this->sendResponse();
    }
	
    function action() {
        $objSiteInfo = SC_Helper_DB_Ex::sfGetBasisData();
        $this->arrSiteInfo = $objSiteInfo->data;
		//メインページオブジェクトの商品リストを取得
		$mainObjPage = $GLOBALS['objPage'];
		$this->mainObjPage = $mainObjPage;

		$bloc_id        = $this->blocItems['bloc_id'];
		$device_type_id = $this->blocItems['device_type_id'];
		
		//マスターデータを含むブロックデータと、フィルターリストを取得
		$this->bloc     = MatrixFilterProducts::getBlocFromBlocInfo($bloc_id, $device_type_id);
			
		// キャッシュ確認
		if (PLG_MFP_CACHE_ENABLE and ($arrProducts = $this->readCache($bloc_id)) !== false) {
			$this->arrProducts = $arrProducts;
			//ランダム表示
			if ($this->bloc['mfp_disp_random']) {
				$keys = array_keys($this->arrProducts);
				shuffle($keys);
				$tmpArrProducts = array();
				foreach ($keys as $key) {
					$tmpArrProducts[$key] = $this->arrProducts[$key];
				}
				$this->arrProducts = $tmpArrProducts;
			}
		} else {			
			//ランキング取得
			$result = MatrixFilterProducts::getProductIds($this->bloc);
			$arrResult = SC_Utils_Ex::sfSwapArray($result);
			$arrProductId = $arrResult['product_id'];
			$objProduct = new SC_Product_Ex();
			$objQuery   =& SC_Query_Ex::getSingletonInstance();
			$this->arrProducts = $objProduct->getListByProductIds($objQuery, $arrProductId);

			//キャッシュ保存
			if (PLG_MFP_CACHE_ENABLE) {
				$this->writeCache($bloc_id, $this->arrProducts);
			}
		}
    }
	
	/**
	 * キャッシュファイル名を返す
	 *
	 */
	function getCachefilePath($bloc_id) {
		//ブロックIDとURLから、キーを作成
		$file = md5($_SERVER['REQUEST_URI'])."-{$bloc_id}.cache";
		return PLG_MFP_CACHE_DIR . $file;
	}
	
	/**
	 * キャッシュを読み込んで返す
	 *
	 */
	function readCache($bloc_id) {
		$path =  $this->getCachefilePath($bloc_id);
		if (file_exists($path) and (time() < filemtime($path) + PLG_MFP_CACHE_LIFETIME)) {
			return unserialize(file_get_contents($path));
		} else {
			return false;
		}
	}
	
	/**
	 * キャッシュを書き込む
	 *
	 */
	function writeCache($bloc_id, $arrProducts) {
		$path =  $this->getCachefilePath($bloc_id);
		file_put_contents($path, serialize($arrProducts));
	}
}
