<!--{*
 * AddSearchItem
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
 *}-->
    <!--詳細検索ここから-->
	<link rel="stylesheet" href="<!--{$smarty.const.PLUGIN_HTML_URLPATH}-->AddSearchItem/media/addsearchitem.css" type="text/css" media="all" />    
    <div id="searchdetailarea">
        <!--検索フォーム-->
<h2 class="title">詳細検索</h2>
        <form name="search_form" id="search_form" method="get" action="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php">
        <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
        <table>
            <tr>
            <td>
            <p><span>キーワードを入力</span>
            <input type="text" name="name" class="keywords" maxlength="50" value="<!--{$smarty.request.name|h}-->" /></p>
            <p><span>商品カテゴリから選ぶ</span>
            <input type="hidden" name="mode" value="search" />
            <select name="category_id" class="box200">
            <option label="すべての商品" value="">全ての商品</option>
            <!--{html_options options=$arrCatList selected=$smarty.request.category_id}-->
            </select></p>
            <!--{if $arrMakerList}-->
						<p><span>メーカーから選ぶ</span>
            <select name="maker_id" class="box200">
            <option label="すべてのメーカー" value="">すべてのメーカー</option>
                    <!--{html_options options=$arrMakerList selected=$smarty.request.maker_id}-->
            </select></p>
            <!--{/if}-->
            </td>
            <td>
            <div id="refine">
            <span class="title">絞り込み条件</span>
            <p>
            <span>価格帯</span>
            <input type="text" name="price_min" class="box80" maxlength="50" value="<!--{$smarty.request.price_min|h}-->" />&nbsp;円
            &nbsp;～&nbsp;
            <input type="text" name="price_max" class="box80" maxlength="50" value="<!--{$smarty.request.price_max|h}-->" />&nbsp;円
            </p>
            <!--{if $arrSTATUS|@count > 0}-->
            <p>
            <span>商品ステータス</span>
            <!--{html_checkboxes name="product_status_id" options=$arrSTATUS selected=$smarty.request.product_status_id separator="&nbsp;"}-->
            </p>
            <!--{/if}-->
            <p>
            <span>その他条件</span>
            <label><input type="checkbox" name="sf" value="1" <!--{if $smarty.request.sf == 1}-->checked<!--{/if}--> />在庫あり</label>&nbsp;
            <label><input type="checkbox" name="rf" value="1" <!--{if $smarty.request.rf == 1}-->checked<!--{/if}--> />レビューあり</label>&nbsp;
            <!--{if $fs_enable}-->
            <label><input type="checkbox" name="fs" value="1" <!--{if $smarty.request.fs == 1}-->checked<!--{/if}--> />送料無料</label>&nbsp;
            <!--{/if}-->
            </p>
            </div>
            </td>
            </tr>
            <tr>
            <td colspan="2" class="search-td"><p class="btn"><input type="submit" name="search" class="search-submit btn btn-success btn-lg" value="検索する" /></p></td>
            </tr>
        </table>
        </form>
    </div>
    <br>
    <!--詳細検索ここまで-->
