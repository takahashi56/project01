<?php
/*
 * SEO管理プラグイン
 * Copyright (C) 2013 BLUE STYLE
 * http://bluestyle.jp/
 */

/**
 * プラグイン の情報クラス.
 *
 * @package Seo
 * @author BLUE STYLE
 */
class plugin_info {
    /** プラグインコード(必須)：プラグインを識別する為キーで、他のプラグインと重複しない一意な値である必要がありま. */
    static $PLUGIN_CODE         = 'Seo';
    /** プラグイン名(必須)：EC-CUBE上で表示されるプラグイン名. */
    static $PLUGIN_NAME         = 'SEO管理プラグイン';
    /** プラグインURL：プラグイン毎に設定出来るURL（説明ページなど） */
    static $PLUGIN_SITE_URL     = 'http://bluestyle.jp/';
    /** クラス名(必須)：プラグインのクラス（拡張子は含まない） */
    static $CLASS_NAME          = 'Seo';
    /** プラグインバージョン(必須)：プラグインのバージョン. */
    static $PLUGIN_VERSION      = '0.1.0';
    /** 対応バージョン(必須)：対応するEC-CUBEバージョン. */
    static $COMPLIANT_VERSION   = '2.13.0 - 2.13.1';
    /** 作者(必須)：プラグイン作者. */
    static $AUTHOR              = 'BLUE STYLE';
    /** 作者用のサイトURL **/
    static $AUTHOR_SITE_URL     = 'http://bluestyle.jp/';
    /** 説明(必須)：プラグインの説明. */
    static $DESCRIPTION         = 'SEO関連を管理するプラグインです。';
    static $LICENSE             = 'LGPL';
    static $HOOK_POINTS = array(
//        array('outputfilterTransform', 'outputfilterTransform')
   );
}
