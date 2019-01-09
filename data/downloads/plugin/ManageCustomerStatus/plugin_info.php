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
 * プラグイン の情報クラス.
 *
 * @package ManageCustomerStatus
 * @author Bratech CO.,LTD.
 * @version $Id: $
 */
class plugin_info{
    /** プラグインコード(必須)：プラグインを識別する為キーで、他のプラグインと重複しない一意な値である必要がありま. */
    static $PLUGIN_CODE       = "ManageCustomerStatus";
    /** プラグイン名(必須)：EC-CUBE上で表示されるプラグイン名. */
    static $PLUGIN_NAME       = "会員ランク";
    /** クラス名(必須)：プラグインのクラス（拡張子は含まない） */
    static $CLASS_NAME        = "ManageCustomerStatus";
    /** プラグインバージョン(必須)：プラグインのバージョン. */
    static $PLUGIN_VERSION    = "1.6.3";
    /** 対応バージョン(必須)：対応するEC-CUBEバージョン. */
    static $COMPLIANT_VERSION = "2.12, 2.13";
    /** 作者(必須)：プラグイン作者. */
    static $AUTHOR            = "株式会社ブラテック";
    /** 説明(必須)：プラグインの説明. */
    static $DESCRIPTION       = "会員ランク機能を使用できるようにします。";
    /** プラグインURL：プラグイン毎に設定出来るURL（説明ページなど） */
    static $PLUGIN_SITE_URL   = "http://www.bratech.co.jp";
	static $AUTHOR_SITE_URL   = "http://www.bratech.co.jp";
	/** フックポイント **/
    static $HOOK_POINTS       = array(
			array('LC_Page_FrontParts_LoginCheck_action_login'),
			array('LC_Page_FrontParts_LoginCheck_action_logout'),
			array('LC_Page_FrontParts_Bloc_Recommend_action_after'),
			array('LC_Page_FrontParts_Bloc_Login_action_after'),
			array('LC_Page_FrontParts_Bloc_LoginFooter_action_after'),
			array('LC_Page_Entry_action_complete'),
			array('LC_Page_MyPage_action_before'),
			array('LC_Page_Mypage_Change_action_before'),			
			array('LC_Page_Mypage_ChangeComplete_action_before'),
			array('LC_Page_Mypage_Delivery_action_before'),
			array('LC_Page_MyPage_Favorite_action_before'),
			array('LC_Page_Mypage_History_action_before'),
			array('LC_Page_Mypage_History_action_after'),
			array('LC_Page_Mypage_Order_action_before'),
			array('LC_Page_Mypage_Refusal_action_before'),
			array('LC_Page_Shopping_Confirm_action_before'),
			array('LC_Page_Shopping_Confirm_action_after'),
			array('LC_Page_Admin_Customer_action_before'),
			array('LC_Page_Admin_Customer_Edit_action_after'),
			array('LC_Page_Admin_Products_Product_action_after'),
			array('LC_Page_Admin_Products_ProductClass_action_after'),
			array('LC_Page_Admin_Products_UploadCSV_action_before'),
			array('LC_Page_Admin_Products_UploadCSV_action_after'),
			array('LC_Page_Admin_Order_Edit_action_before'),
			array('LC_Page_Admin_Order_Edit_action_after'),
			array('LC_Page_Admin_Mail_action_before')
									);
    /** ライセンス */
    static $LICENSE        = "独自ライセンス";
}
?>