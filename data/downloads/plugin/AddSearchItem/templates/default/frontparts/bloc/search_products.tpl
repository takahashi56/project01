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
            <!--{if $use_price}-->
            <dl class="formlist">
            <dt>価格帯</dt>
            <dd><input type="text" name="price_min" class="box120" maxlength="50" value="<!--{$smarty.request.price_min|h}-->" />&nbsp;円
            &nbsp;～&nbsp;<br>
            <input type="text" name="price_max" class="box120" maxlength="50" value="<!--{$smarty.request.price_max|h}-->" />&nbsp;円</dd>
            </dl>
            <!--{/if}-->
            <dl class="formlist">
            <!--{if $arrSTATUS|@count > 0}-->
            <dt>商品ステータス</dt>
            <dd><!--{html_checkboxes name="product_status_id" options=$arrSTATUS selected=$smarty.request.product_status_id separator="<br />"}--></dd>
            <!--{/if}-->
            <dt>その他の条件</dt>
            <!--{if $use_stock}-->
            <dd><input type="checkbox" name="sf" value="1" <!--{if $smarty.request.sf == 1}-->checked<!--{/if}--> />
            在庫あり</dd>
            <!--{/if}-->
            <!--{if $use_review}-->
            <dd><input type="checkbox" name="rf" value="1" <!--{if $smarty.request.rf == 1}-->checked<!--{/if}--> />
            レビューあり</dd>
            <!--{/if}-->
            <!--{if $use_fs && $fs_enable}-->
            <dd><input type="checkbox" name="fs" value="1" <!--{if $smarty.request.fs == 1}-->checked<!--{/if}--> />
            送料無料</dd>
            <!--{/if}-->
            </dl>