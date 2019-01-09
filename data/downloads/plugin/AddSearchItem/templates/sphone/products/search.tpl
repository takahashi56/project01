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

<section id="undercolumn">
	<h2 class="title">詳細検索</h2>
    <form method="get" action="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php">
            <input type="hidden" name="mode" value="search">
            <dl class="form_entry">
            <dt>キーワード入力</dt>
            <dd><input type="text" name="name" class="boxHarf text data-role-none" maxlength="50" value="<!--{$smarty.get.name|h}-->"></dd>
            <dt>商品カテゴリから選ぶ</dt>
            <dd>
            <select name="category_id" class="boxLong data-role-none">
            <option label="すべての商品" value="">全ての商品</option>
            <!--{html_options options=$arrCatList selected=$smarty.get.category_id}-->
            </select></dd>
            <!--{if $arrMakerList}-->
			<dt>メーカーから選ぶ</dt>
            <dd>
            <select name="maker_id" class="boxLong data-role-none">
            <option label="すべてのメーカー" value="">すべてのメーカー</option>
                    <!--{html_options options=$arrMakerList selected=$smarty.get.maker_id}-->
            </select></dd>
            <!--{/if}-->
   			<dt>絞り込み条件</dt>
            <dd>
            <input type="checkbox" name="sf" value="1" class="data-role-none" <!--{if $smarty.get.sf == 1}-->checked<!--{/if}--> />&nbsp;<label>在庫あり</label><br>
            <input type="checkbox" name="rf" value="1" class="data-role-none" <!--{if $smarty.get.rf == 1}-->checked<!--{/if}--> />&nbsp;<label>レビューあり</label><br>
            <!--{if $fs_enable}-->
            <input type="checkbox" name="fs" value="1" class="data-role-none" <!--{if $smarty.get.fs == 1}-->checked<!--{/if}--> />&nbsp;<label>送料無料</label><br>
            <!--{/if}-->
            </dd>
             <!--{if $arrSTATUS|@count > 0}-->
            <dt>商品ステータス</dt>
            <dd><!--{html_checkboxes name="product_status_id" options=$arrSTATUS selected=$smarty.request.product_status_id separator="<br />" class="data-role-none"}--></dd>
            <!--{/if}-->
            <dt>価格帯</dt>
            <dd>
            <input type="text" name="price_min" class="boxHarf text data-role-none" maxlength="50" value="<!--{$smarty.get.price_min|h}-->" />&nbsp;円<br>
            &nbsp;～&nbsp;<br>
            <input type="text" name="price_max" class="boxHarf text data-role-none" maxlength="50" value="<!--{$smarty.get.price_max|h}-->" />&nbsp;円</dd>
            </dl>
            <div class="btn_area">
            <p><input type="submit" name="search" value="検索" class="btn data-role-none"></p>
            </div>
    </form>
</section>