<!--{*
 * EC-CUBE on Bootstrap3. This file is part of EC-CUBE
 *
 * Copyright(c) 2014 clicktx. All Rights Reserved.
 *
 * http://perl.no-tubo.net/
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
 *}-->

<!--{strip}-->
    <!--{* 検索該当0件 *}-->
    <div id="undercolumn_error">
        <div class="message_area">
            <!--★エラーメッセージ-->
            <p class="alert alert-danger">
                <!--{if $smarty.get.mode == "search"}-->
                    該当件数<strong>0件</strong>です。<br />
                    他の検索キーワードより再度検索をしてください。
                <!--{else}-->
                    現在、商品を準備中です。
                <!--{/if}-->
            </p>
        </div>
    </div>
<!--{/strip}-->