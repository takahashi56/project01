<?php
/*
 *
 * OperateProductSTrial
 * Copyright(c) 2015 DAISY Inc. All Rights Reserved.
 *
 * http://www.daisy.link/
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

require_once PLUGIN_UPLOAD_REALDIR . 'OperateProductSTrial/class_ex/util_ex/plg_OperateProductSTrial_SC_Utils_Ex.php';

/**
 * プラグインのメインクラス
 *
 * @package 
 * @author DAISY CO.,LTD.
 * @version $
 */
class OperateProductSTrial extends SC_Plugin_Base {
    
    /**
     * インストール時に実行される処理を記述します.
     * 
     * @param array $arrPlugin dtb_pluginの情報配列
     * @return void
     */
    function install($arrPlugin) {
        
        self::copyFiles($arrPlugin);
    }

    /**
     * 削除時に実行される処理を記述します.
     * 
     * @param array $arrPlugin dtb_pluginの情報配列
     * @return void
     */
    function uninstall($arrPlugin) {
        
        self::deleteFiles($arrPlugin);
    }
    
    /**
     * 有効にした際に実行される処理を記述します.
     * 
     * @param array $arrPlugin dtb_pluginの情報配列
     * @return void
     */
    function enable($arrPlugin) {
    }

    /**
     * 無効にした際に実行される処理を記述します.
     * 
     * @param array $arrPlugin dtb_pluginの情報配列
     * @return void
     */
    function disable($arrPlugin) {
    }
    
    /**
     * プラグイン用ファイルをコピー 
     * 
     * @param array $arrPlugin dtb_pluginの情報配列
     * @return void
     */
    static function copyFiles($arrPlugin){
        
        //html
        plg_OperateProductSTrial_SC_Utils_Ex::copy_recursive(PLUGIN_UPLOAD_REALDIR . 'OperateProductSTrial/html/', PLUGIN_HTML_REALDIR . 'OperateProductSTrial/');
        //アイコン
        copy(PLUGIN_UPLOAD_REALDIR . $arrPlugin['plugin_code'] . '/logo.png', PLUGIN_HTML_REALDIR . $arrPlugin['plugin_code'] . '/logo.png');
    }
    
    /**
     * 本体を含むすべてのプラグイン用ファイルを削除
     * 
     * @param array $arrPlugin dtb_pluginの情報配列
     * @return void 
     */
    static function deleteFiles($arrPlugin){
        
        //html配下
        SC_Helper_FileManager_Ex::deleteFile(PLUGIN_HTML_REALDIR . 'OperateProductSTrial/');
        //プラグイン本体
        SC_Helper_FileManager_Ex::deleteFile(PLUGIN_UPLOAD_REALDIR . 'OperateProductSTrial/');
    }

    /**
     * プレフィルタコールバック関数
     *
     * @param string &$source テンプレートのHTMLソース
     * @param LC_Page_Ex $objPage ページオブジェクト
     * @param string $filename テンプレートのファイル名
     * @return void
     */
    static function prefilterTransform(&$source, LC_Page_Ex $objPage, $filename) {
        
        $objTransform = new SC_Helper_Transform($source);
        $template_dir = sprintf(PLUGIN_UPLOAD_REALDIR . 'OperateProductSTrial/templates/');
        
        switch($objPage->arrPageLayout['device_type_id']){
            case DEVICE_TYPE_MOBILE:
            case DEVICE_TYPE_SMARTPHONE:
            case DEVICE_TYPE_PC:
                break;
            case DEVICE_TYPE_ADMIN:
            default:
                if (strpos($filename, 'products/index.tpl') !== false) {
                    $objTransform->select('#products-search-result')->appendFirst(file_get_contents($template_dir . 'admin/products/plg_OperateProductSTrial_snippet_index_col.tpl'));
                    $objTransform->select('#products-search-result tr', 0)->appendFirst(file_get_contents($template_dir . 'admin/products/plg_OperateProductSTrial_snippet_index_th.tpl'));
                    $objTransform->select('#products-search-result .id')->insertBefore(file_get_contents($template_dir . 'admin/products/plg_OperateProductSTrial_snippet_index_td.tpl'));
                    $objTransform->select('#form .btn')->appendChild(file_get_contents($template_dir . 'admin/products/plg_OperateProductSTrial_snippet_index_button.tpl'));
                }
                break;
        }
        $source = $objTransform->getHTML();
    }
}