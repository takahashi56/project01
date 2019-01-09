<?php
/*
 * MemberCategory
 * Copyright (C) 2012 UAssist CO.,LTD. All Rights Reserved.
 * http://www.uassist.co.jp/
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

class MemberCategory extends SC_Plugin_Base {


    public function __construct(array $arrSelfInfo) {
        parent::__construct($arrSelfInfo);
        $this->error_message = '会員様限定ページです';
    }


    function install($arrPlugin) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objQuery->query("ALTER TABLE dtb_category ADD plg_membercategory_member_flg INT");
        if(copy(PLUGIN_UPLOAD_REALDIR . "MemberCategory/logo.png", PLUGIN_HTML_REALDIR . "MemberCategory/logo.png") === false);
    }


    function uninstall($arrPlugin) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objQuery->query("ALTER TABLE dtb_category DROP plg_membercategory_member_flg");
    }


    function enable($arrPlugin) {
    }

    function disable($arrPlugin) {
    }

    function member_flg_set($objPage) {
        $post = $_POST;
        switch ($post['mode']) {
        case 'pre_edit':
            $category_id = $objPage->arrForm['category_id'];
            $member_flg = $this->get_member_flg($category_id);
            $objPage->arrForm['plg_membercategory_member_flg'] = $member_flg;
            break;
        case 'edit':
            $category_id = $post['category_id'];
            $member_flg = (isset($post['plg_membercategory_member_flg']) ? 1 : '0');
            if(empty($category_id)){
                $category_name = $post['category_name'];
                $parent_category_id = $post['parent_category_id'];
                $category = $this->get_category($category_name, $parent_category_id);
                $category_id = $category['category_id'];
            }
            $this->update_member_flg($category_id,$member_flg);
            break;
        default:
            break;
        }
    }


    function prefilterTransform(&$source, LC_Page_Ex $objPage, $filename) {
        $objTransform = new SC_Helper_Transform($source);
        $template_dir = PLUGIN_UPLOAD_REALDIR . 'MemberCategory/templates/';
        switch($objPage->arrPageLayout['device_type_id']){
            case DEVICE_TYPE_MOBILE:
            case DEVICE_TYPE_SMARTPHONE:
            case DEVICE_TYPE_PC:
                break;
            case DEVICE_TYPE_ADMIN:
            default:
                // カテゴリ登録画面
                if (strpos($filename, 'products/category.tpl') !== false) {
                    $objTransform->select('div.now_dir')->replaceElement(file_get_contents($template_dir . 'membercategory_admin_category.tpl'));
                }
                break;
        }
        $source = $objTransform->getHTML();
    }

    function auth_product_detail($objPage) {
        if($_GET['product_id']) {
            if(!$this->is_login() && $this->belong_to_member_caegory($_GET['product_id'])) {
              header('Location: '.HTTPS_URL.'mypage/login.php');
              exit;

                SC_Utils_Ex::sfDispSiteError(FREE_ERROR_MSG, '', false, $this->error_message);
            }
        }
    }

    function auth_product_list($objPage) {
        if($_GET['category_id']) {
            if(!$this->is_login() && $this->is_member_caegory($_GET['category_id'])) {
              header('Location: '.HTTPS_URL.'mypage/login.php');
              exit;

                SC_Utils_Ex::sfDispSiteError(FREE_ERROR_MSG, '', false, $this->error_message);
            }
        }
    }

    function is_login() {
        $objCustomer = new SC_Customer_Ex();
        return $objCustomer->isLoginSuccess();
    }

    function belong_to_member_caegory($product_id) {
        $arrRelativeCategoryId = $this->get_relative_category_id($product_id);
        return $this->member_category_exist($arrRelativeCategoryId);
    }

    function get_relative_category_id($product_id) {
        $arrCateTree = SC_Helper_DB_Ex::sfGetMultiCatTree($product_id);
        $ret = array();
        foreach($arrCateTree as $path) {
            foreach($path as $category) {
                $ret[] = $category['category_id'];
            }
        }
        return $ret;
    }

    function member_category_exist($arrCategoryId) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $where = "del_flg = 0 AND plg_membercategory_member_flg = 1 AND category_id IN (" . implode(',', $arrCategoryId) . ")";
        $count = $objQuery->count('dtb_category', $where);
        return ($count > 0);
    }

    function is_member_caegory($category_id) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        return $this->member_category($objQuery, $category_id);
    }

    function member_category($objQuery, $category_id) {
        $category = $objQuery->select('*', 'dtb_category', 'category_id = ? AND del_flg = 0', array($category_id));
        if($category[0]['plg_membercategory_member_flg'] == 1) {
            return true;
        } elseif($category[0]['parent_category_id'] == 0) {
            return false;
        } else {
            return $this->member_category($objQuery, $category[0]['parent_category_id']);
        }
    }

    function get_member_flg($category_id) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $ret = $objQuery->select('plg_membercategory_member_flg', 'dtb_category', 'category_id = ? AND del_flg = 0', array($category_id));
        return $ret[0]['plg_membercategory_member_flg'];
    }

    function get_category($category_name, $parent_category_id) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $ret = $objQuery->select('*',
            'dtb_category',
            'del_flg = 0 AND category_name = ? AND parent_category_id = ?',
            array($category_name, $parent_category_id));
        return $ret[0];
    }

    function update_member_flg($category_id, $member_flg) {
        $objQuery =& SC_Query_Ex::getSingletonInstance();
        $objQuery->update('dtb_category',
            array('plg_membercategory_member_flg' => $member_flg, 'update_date' => 'now()'),
            'category_id = ?',
            array($category_id));
    }

}

?>
