<?php
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2014 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
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

require_once CLASS_REALDIR . 'util/SC_Utils.php';

/**
 * 各種ユーティリティクラス(拡張).
 *
 * SC_Utils をカスタマイズする場合はこのクラスを使用する.
 *
 * @package Util
 * @author LOCKON CO.,LTD.
 * @version $Id$
 */
class SC_Utils_Ex extends SC_Utils
{
  function getRootUrl() {
    if(empty($_SERVER['HTTPS'])) {
      return HTTP_URL;
    } else {
      return HTTPS_URL;
    }
  }

	//指定した親カテゴリーの直下の子カテゴリーを取得 20170727 kikuzawa
	function sfGetChildCategory($parent_category_id, $product_id = false) {
	    $objQuery =& SC_Query_Ex::getSingletonInstance();
	    if($product_id){
	        $table = 'dtb_category c INNER JOIN dtb_product_categories p ON c.category_id = p.category_id';
		    $where = 'del_flg = 0 AND parent_category_id = ? AND product_id = ?';
	    }else{
	        $table = 'dtb_category c';
		    $where = 'del_flg = 0 AND parent_category_id = ?';
	    }

	    return $objQuery->select('c.category_id,category_name', $table, $where, array($parent_category_id, $product_id));
	}
}
