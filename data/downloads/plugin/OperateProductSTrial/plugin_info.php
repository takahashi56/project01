<?php
/*
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

/**
 * プラグイン の情報クラス.
 *
 * @package OperateProductSTrial
 * @author DAISY Inc.
 * @version $Id: $
 */
class plugin_info{
    
    static $PLUGIN_CODE       = 'OperateProductSTrial';
    static $PLUGIN_NAME       = '商品一括操作プラグイン (体験版)';
    static $CLASS_NAME        = 'OperateProductSTrial';
    static $PLUGIN_VERSION    = '1.0.fix1';
    static $COMPLIANT_VERSION = '2.12.0-2.12.6, 2.13.0';
    static $AUTHOR            = 'DAISY inc.';
    static $DESCRIPTION       = '商品の一括操作を可能にするプラグインです。';
    static $PLUGIN_SITE_URL    = 'http://www.ec-cube.net/owners/index.php';
    static $AUTHOR_SITE_URL    = 'http://www.daisy.link/ec-cube/products/about.php';
    static $HOOK_POINTS       = array(
        array('prefilterTransform', 'prefilterTransform')
    );
}