<?php
/*
 * ManageCustomerStatus
 * Copyright (C) 2012 Bratech CO.,LTD. All Rights Reserved.
 * http://wwww.bratech.co.jp/
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

require_once PLUGIN_UPLOAD_REALDIR . "ManageCustomerStatus/plg_ManageCustomerStatus_Utils.php";

class plg_ManageCustomerStatus_LC_Page{
	function before($objPage){
	}
	
	function after($objPage){
	}

    /**
     * アプリケーション内でリダイレクトする
     *
     * 内部で生成する URL の searchpart は、下記の順で上書きしていく。(後勝ち)
     * 1. 引数 $inheritQueryString が true の場合、$_SERVER['QUERY_STRING']
     * 2. $location に含まれる searchpart
     * 3. 引数 $arrQueryString
     * @param  string    $location           「url-path」「現在のURLからのパス」「URL」のいずれか。「../」の解釈は行なわない。
     * @param  array     $arrQueryString     URL に付加する searchpart
     * @param  bool      $inheritQueryString 現在のリクエストの searchpart を継承するか
     * @param  bool|null $useSsl             true:HTTPSを強制, false:HTTPを強制, null:継承
     * @return void
     * @static
     */
    public function sendRedirect($location, $arrQueryString = array(), $inheritQueryString = false, $useSsl = null)
    {

        // url-path → URL 変換
        if ($location[0] === '/') {
            $netUrl = new Net_URL($location);
            $location = $netUrl->getUrl();
        }

        // URL の場合
        if (preg_match('/^https?:/', $location)) {
            $url = $location;
            if (is_bool($useSsl)) {
                if ($useSsl) {
                    $pattern = '/^' . preg_quote(HTTP_URL, '/') . '(.*)/';
                    $replacement = HTTPS_URL . '\1';
                    $url = preg_replace($pattern, $replacement, $url);
                } else {
                    $pattern = '/^' . preg_quote(HTTPS_URL, '/') . '(.*)/';
                    $replacement = HTTP_URL . '\1';
                    $url = preg_replace($pattern, $replacement, $url);
                }
            }
        }
        // 現在のURLからのパス
        else {
            if (!is_bool($useSsl)) {
                $useSsl = SC_Utils_Ex::sfIsHTTPS();
            }
            $netUrl = new Net_URL($useSsl ? HTTPS_URL : HTTP_URL);
            $netUrl->path = dirname($_SERVER['SCRIPT_NAME']) . '/' . $location;
            $url = $netUrl->getUrl();
        }

        $pattern = '/^(' . preg_quote(HTTP_URL, '/') . '|' . preg_quote(HTTPS_URL, '/') . ')/';

        // アプリケーション外へのリダイレクトは扱わない
        if (preg_match($pattern, $url) === 0) {
            trigger_error('', E_USER_ERROR);
        }

        $netUrl = new Net_URL($url);

        if ($inheritQueryString && !empty($_SERVER['QUERY_STRING'])) {
            $arrQueryStringBackup = $netUrl->querystring;
            // XXX メソッド名は add で始まるが、実際には置換を行う
            $netUrl->addRawQueryString($_SERVER['QUERY_STRING']);
            $netUrl->querystring = array_merge($netUrl->querystring, $arrQueryStringBackup);
        }

        $netUrl->querystring = array_merge($netUrl->querystring, $arrQueryString);

        $session = SC_SessionFactory_Ex::getInstance();
        if ((SC_Display_Ex::detectDevice() == DEVICE_TYPE_MOBILE)
            || ($session->useCookie() == false)
        ) {
            $netUrl->addQueryString(session_name(), session_id());
        }

        $netUrl->addQueryString(TRANSACTION_ID_NAME, SC_Helper_Session_Ex::getToken());
        $url = $netUrl->getURL();

        header("Location: $url");
        exit;
    }
}