<?php
/*
 * AutoMetaKeyword
 * Copyright(c) C-Rowl Co., Ltd. All Rights Reserved.
 * http://www.c-rowl.com/
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
 * @package AutoMetaKeyword
 * @author  C-Rowl Co., Ltd.
 * @version $Id: $
 */
class plugin_info {
    /** プラグインコード(必須)：システム上でのキーとなります。プラグインコードは一意である必要があります。 */
    static $PLUGIN_CODE        = "AutoMetaKeyword";
    /** プラグイン名(必須)：プラグイン管理・画面出力（エラーメッセージetc）にはこの値が出力されます。 */
    static $PLUGIN_NAME        = "メタタグKeyword自動設定";
    /** プラグインメインクラス名(必須)：本体がプラグインを実行する際に呼ばれるクラス。拡張子は不要です。 */
    static $CLASS_NAME         = "AutoMetaKeyword";
    /** プラグインバージョン(必須) */
    static $PLUGIN_VERSION     = "0.1";
    /** 本体対応バージョン(必須) */
    static $COMPLIANT_VERSION  = "2.12.2";
    /** 作者(必須) */
    static $AUTHOR             = "株式会社 C-Rowl";
    /** 説明(必須) */
    static $DESCRIPTION        = "メタタグ（Keyword）の内容を自動で設定します。商品一覧ではカテゴリ名、商品詳細では商品名を設定します。すでに「基本情報管理＞SEO管理」で設定されているKeywordがある場合には、末尾に追記します。";
    /** 作者用のサイトURL：設定されている場合はプラグイン管理画面の作者名がリンクになります。 */
    static $AUTHOR_SITE_URL    = "http://www.c-rowl.com/";
    /** プラグインのサイトURL : 設定されている場合はプラグイン管理画面の作者名がリンクになります。 */
    static $PLUGIN_SITE_URL   = "";
    /** 使用するフックポイント：使用するフックポイントを設定すると、フックポイントが競合した際にアラートが出ます。 */
    static $HOOK_POINTS       = array(
        array("LC_Page_Products_List_action_after",   'setKeywordForList'),
        array("LC_Page_Products_Detail_action_after", 'setKeywordForDetail'),
        );
    /** ライセンス */
    static $LICENSE        = "LGPL";
}
?>