<?php
/*
 * 条件指定商品リスト・ブロック作成プラグイン
 * Copyright (C) 2013 colori
 * 
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
require_once PLUGIN_UPLOAD_REALDIR .  'MatrixFilterProducts/class_extends/page_extends/LC_Page_Plugin_MatrixFilterProducts_Config_Ex.php';

// }}}
// {{{ generate page
$objPage = new LC_Page_Plugin_MatrixFilterProducts_Config_Ex();
$objPage->init();
$objPage->process();
