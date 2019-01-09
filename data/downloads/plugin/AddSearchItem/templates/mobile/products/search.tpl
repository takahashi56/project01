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
<!--{strip}-->
    
    <form method="get" action="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php">
            <input type="hidden" name="mode" value="search">
            キーワードを入力してください。<br>
            <input type="text" name="name" size="18" maxlength="50" value="<!--{$smarty.get.name|h}-->"><br><br>
            商品カテゴリから選ぶ<br />
            <select name="category_id">
            <option label="すべての商品" value="">全ての商品</option>
            <!--{html_options options=$arrCatList selected=$smarty.get.category_id}-->
            </select><br><br>
            <!--{if $arrMakerList}-->
			メーカーから選ぶ<br>
            <select name="maker_id">
            <option label="すべてのメーカー" value="">すべてのメーカー</option>
                    <!--{html_options options=$arrMakerList selected=$smarty.get.maker_id}-->
            </select><br><br>
            <!--{/if}-->
            <input type="checkbox" name="sf" value="1" <!--{if $smarty.get.sf == 1}-->checked<!--{/if}--> />
            在庫あり<br>
            <input type="checkbox" name="rf" value="1" <!--{if $smarty.get.rf == 1}-->checked<!--{/if}--> />
            レビューあり<br>
            <!--{if $fs_enable}-->
            <input type="checkbox" name="fs" value="1" <!--{if $smarty.get.fs == 1}-->checked<!--{/if}--> />
            送料無料<br>
            <!--{/if}-->
            <br>
            <!--{if $arrSTATUS|@count > 0}-->
            商品ステータス：<br>
            <!--{html_checkboxes name="product_status_id" options=$arrSTATUS selected=$smarty.request.product_status_id separator="<br />"}-->
            <br>
            <!--{/if}-->
            価格帯：<br>
            <input type="text" name="price_min" size="18" maxlength="50" value="<!--{$smarty.get.price_min|h}-->" />&nbsp;円<br>
            &nbsp;～&nbsp;<br>
            <input type="text" name="price_max" size="18" maxlength="50" value="<!--{$smarty.get.price_max|h}-->" />&nbsp;円<br />
        <center>
            <input type="submit" name="search" value="検索">
        </center>
    </form>
<!--{/strip}-->