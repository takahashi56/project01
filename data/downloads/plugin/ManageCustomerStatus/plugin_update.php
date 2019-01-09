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

/**
 * プラグイン のアップデート用クラス.
 *
 * @package ManageCustomerStatus
 * @author Bratech CO.,LTD.
 * @version $Id: $
 */
class plugin_update{
   /**
     * アップデート
     * updateはアップデート時に実行されます.
     * 引数にはdtb_pluginのプラグイン情報が渡されます.
     * 
     * @param array $arrPlugin プラグイン情報の連想配列(dtb_plugin)
     * @return void
     */
    function update($arrPlugin) {
		$version = floor(str_replace('.','',$arrPlugin['plugin_version']));
		$plugin_dir_path = PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . '/';
		SC_Utils_Ex::copyDirectory(DOWNLOADS_TEMP_PLUGIN_UPDATE_DIR, $plugin_dir_path);
		
		require_once PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/plg_ManageCustomerStatus_Utils.php";
		
		$objQuery =& SC_Query_Ex::getSingletonInstance();
		$objQuery->begin();
		
        $sqlval_plugin = array();
        $sqlval_plugin['plugin_version'] = "1.6.3";
        $sqlval_plugin['update_date'] = 'CURRENT_TIMESTAMP';
	
		$objQuery->update('dtb_plugin', $sqlval_plugin, "plugin_code = ?", array($arrPlugin['plugin_code']));
		$objQuery->commit();
		
		if($version <= 101){
			plg_ManageCustomerStatus_Utils::insertBloc($arrPlugin);
		}
		
		if($version <= 113){
			$objQuery->query("CREATE TABLE plg_managecustomerstatus_dtb_product_disp (product_id int,status_id int)");
			
			if($arrPlugin['enable'] == 1){
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
				$sqlval_dtb_csv['col'] = "(SELECT ARRAY_TO_STRING(ARRAY(SELECT status_id FROM plg_managecustomerstatus_dtb_product_disp WHERE plg_managecustomerstatus_dtb_product_disp.product_id = prdcls.product_id ORDER BY plg_managecustomerstatus_dtb_product_disp.status_id), ',')) as plg_managecustomerstatus_product_disp";
				$sqlval_dtb_csv['disp_name'] = '会員ランク別購入不可設定';
				$sqlval_dtb_csv['rw_flg'] = 1;
				$sqlval_dtb_csv['status'] = 0;
				$sqlval_dtb_csv['create_date'] = 'CURRENT_TIMESTAMP';
				$sqlval_dtb_csv['update_date'] = 'CURRENT_TIMESTAMP';
				$sqlval_dtb_csv['mb_convert_kana_option'] = "KVa";
				$sqlval_dtb_csv['size_const_type'] = "LTEXT_LEN";
				$sqlval_dtb_csv['error_check_types'] = "SPTAB_CHECK,MAX_LENGTH_CHECK";
				$objQuery->insert("dtb_csv", $sqlval_dtb_csv);
			}
		}
		
		if($version <= 138){
			if($arrPlugin['enable'] == 1){
				copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . "/html/admin/customer/plg_managecustomerstatus_status.php", HTML_REALDIR . ADMIN_DIR."customer/plg_managecustomerstatus_status.php");
				copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . "/html/admin/customer/plg_managecustomerstatus_upload_csv.php", HTML_REALDIR . ADMIN_DIR."customer/plg_managecustomerstatus_upload_csv.php");
			}
			copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code']. "/html/default/plg_ManageCustomerStatus_info.php", HTML_REALDIR . "frontparts/bloc/plg_ManageCustomerStatus_info.php");
		}
		
		if($version <= 141){
			$objQuery->query("ALTER TABLE plg_managecustomerstatus_dtb_customer_status ADD COLUMN fixed_rank smallint DEFAULT 0");
			$objQuery->update("plg_managecustomerstatus_dtb_customer_status",array("fixed_rank" => 1),"total_amount IS NULL AND buy_times IS NULL AND total_point IS NULL");
		}
		
		if($version <= 152){
			$objQuery->insert("plg_managecustomerstatus_config",array('name' => 'target_id', 'value' => ORDER_NEW .','. ORDER_PAY_WAIT .','. ORDER_PRE_END .','. ORDER_BACK_ORDER. ',' . ORDER_DELIV));
		}
    }
}
?>