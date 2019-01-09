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
 
class plugin_info{
    /** プラグインコード(必須)：プラグインを識別する為キーで、他のプラグインと重複しない一意な値である必要がありま. */
    static $PLUGIN_CODE       = "MemberCategory";
    /** プラグイン名(必須)：EC-CUBE上で表示されるプラグイン名. */
    static $PLUGIN_NAME       = "会員限定カテゴリ";
    /** プラグインバージョン(必須)：プラグインのバージョン. */
    static $PLUGIN_VERSION    = "0.2";
    /** 対応バージョン(必須)：対応するEC-CUBEバージョン. */
    static $COMPLIANT_VERSION = "2.12.0";
    /** 作者(必須)：プラグイン作者. */
    static $AUTHOR            = "株式会社ユアシスト";
    /** 説明(必須)：プラグインの説明. */
    static $DESCRIPTION       = "会員限定のカテゴリを作ることができます。そのカテゴリ配下の商品も会員限定になります。";
    /** プラグインURL：プラグイン毎に設定出来るURL（説明ページなど） */
    static $PLUGIN_SITE_URL   = "http://www.uassist.co.jp/";
    /** プラグイン作者URL：プラグイン毎に設定出来るURL（説明ページなど） */
    static $AUTHOR_SITE_URL   = "http://www.uassist.co.jp/";
    /** クラス名(必須)：プラグインのクラス（拡張子は含まない） */
    static $CLASS_NAME       = "MemberCategory";
    /** フックポイント：フックポイントとコールバック関数を定義します */
    static $HOOK_POINTS       = array(
        array("LC_Page_Admin_Products_Category_action_after", 'member_flg_set'),
        array("LC_Page_Products_List_action_before", 'auth_product_list'),
        array("LC_Page_Products_Detail_action_before", 'auth_product_detail'),
        array("prefilterTransform", 'prefilterTransform'));
    static $LICENSE = "LGPL";
}
?>
