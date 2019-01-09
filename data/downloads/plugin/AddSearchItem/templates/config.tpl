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

<!--{include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`admin_popup_header.tpl"}-->
<script type="text/javascript">
</script>

<h2><!--{$tpl_subtitle}--></h2>
<form name="form1" id="form1" method="post" action="<!--{$smarty.server.REQUEST_URI|h}-->">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="edit">

<h3>商品検索ブロックへの条件追加</h3>
<p>商品追加ブロックへ追加したい項目を設定できます。<br>詳細検索ブロックはこの設定に関わらず全て表示されます。</p>
<table border="0" cellspacing="1" cellpadding="8" summary=" ">
        <col width="30%" />
        <col width="70%" />        
    <tr >
        <td bgcolor="#f3f3f3">在庫</td>
        <td>
        	<!--{assign var=key value="stock"}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
			<!--{html_radios name=$key options=$arrUse selected=$arrForm[$key]|default:0}-->
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">レビュー</td>
        <td>
        	<!--{assign var=key value="review"}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
			<!--{html_radios name=$key options=$arrUse selected=$arrForm[$key]|default:0}-->
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">送料無料</td>
        <td>
         	<span class="attention">※この機能は弊社プラグイン「送料無料対象商品設定」プラグインをご利用頂いている場合のみ使用できます。</span><br>
        	<!--{assign var=key value="freeshipping"}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
			<!--{html_radios name=$key options=$arrUse selected=$arrForm[$key]|default:0}-->
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">価格帯</td>
        <td>
        	<!--{assign var=key value="price"}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
			<!--{html_radios name=$key options=$arrUse selected=$arrForm[$key]|default:0}-->
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">商品ステータス</td>
        <td>
	        <span style="color:#00F;">絞り込み条件の対象ステータスを設定して下さい。設定されていないステータスは検索項目に表示されません。</span><br>
        	<!--{assign var=key value="product_status"}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
			<!--{html_checkboxes name=$key options=$arrSTATUS selected=$arrForm[$key]}-->
            <br><br>
			<span style="color:#00F;">商品ステータスの絞り込みを行う際に、選択されたステータスのAND検索を行うかOR検索を行うかを設定してください。</span><br>
        	<!--{assign var=key value="product_status_condition"}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
			<!--{html_radios name=$key options=$arrAndOr selected=$arrForm[$key]|default:0}-->            
        </td>
    </tr>

</table>

<h3>キーワード検索対象項目設定</h3>
<p>従来の「商品名」、「検索キーワード」に加え検索対象にする項目を追加できます。<br>
<span class="attention">※こちらの設定は検索の処理速度に影響を及ぼします。設定の際にはご注意ください。</span></p>
<table border="0" cellspacing="1" cellpadding="8" summary=" ">
        <col width="30%" />
        <col width="70%" />
    <tr >
        <td bgcolor="#f3f3f3">商品コード</td>
        <td>
        	<!--{assign var=key value="search_product_code"}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
			<!--{html_radios name=$key options=$arrSearchInc selected=$arrForm[$key]|default:0}-->
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">一覧コメント</td>
        <td>
        	<!--{assign var=key value="search_list_comment"}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
			<!--{html_radios name=$key options=$arrSearchInc selected=$arrForm[$key]|default:0}-->
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">メインコメント</td>
        <td>
        	<!--{assign var=key value="search_main_comment"}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
			<!--{html_radios name=$key options=$arrSearchInc selected=$arrForm[$key]|default:0}-->
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">サブコメント</td>
        <td>
        	<!--{assign var=key value="search_sub_comment"}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
			<!--{html_radios name=$key options=$arrSearchInc selected=$arrForm[$key]|default:0}-->
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">規格名・規格分類名</td>
        <td>
        	<!--{assign var=key value="search_classcategory"}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
			<!--{html_radios name=$key options=$arrSearchInc selected=$arrForm[$key]|default:0}-->
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">全角・半角ゆらぎ検索</td>
        <td>
        	<span class="attention">簡易的なゆらぎ検索機能です。「ｱｲス」のように部分的に全角・半角を含むような場合の一致は行えません。「アイス」と「ｱｲｽ」での検索を行う事になります。</span><br>
        	<!--{assign var=key value="search_fluctuation"}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
			<!--{html_radios name=$key options=$arrUse selected=$arrForm[$key]|default:0}-->
        </td>
    </tr>
</table>

<h3>商品並び替え条件設定</h3>
<p>商品一覧画面での並び替え順の条件を追加します。<br>「文言」に入力された内容は実際の一覧画面の並び替え表記に反映されます。未入力の場合はタイトルの表記が使用されます。</p>
<table border="0" cellspacing="1" cellpadding="8" summary=" ">
        <col width="30%" />
        <col width="70%" />        
    <tr >
        <td bgcolor="#f3f3f3">価格順（低い順）</td>
        <td>
        	販売価格の低い順に並び替えます。<br>
        	<!--{assign var=key value="sort_price_asc"}-->
        	<!--{assign var=key2 value="text_price_asc"}-->
            <span class="attention"><!--{$arrErr[$key]}--><!--{$arrErr[$key2]}--></span>
			<!--{html_radios name=$key options=$arrUse selected=$arrForm[$key]|default:0}--><br>
            文言：<input type="text" name="<!--{$key2}-->" value="<!--{$arrForm[$key2]}-->" />
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">価格順（高い順）</td>
        <td>
        	販売価格の高い順に並び替えます。<br>
        	<!--{assign var=key value="sort_price_desc"}-->
        	<!--{assign var=key2 value="text_price_desc"}-->
            <span class="attention"><!--{$arrErr[$key]}--><!--{$arrErr[$key2]}--></span>
			<!--{html_radios name=$key options=$arrUse selected=$arrForm[$key]|default:0}--><br>
            文言：<input type="text" name="<!--{$key2}-->" value="<!--{$arrForm[$key2]}-->" />
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">新着順</td>
        <td>
        	登録日の新しい順に並び替えます。<br>
        	<!--{assign var=key value="sort_date"}-->
        	<!--{assign var=key2 value="text_date"}-->
            <span class="attention"><!--{$arrErr[$key]}--><!--{$arrErr[$key2]}--></span>
			<!--{html_radios name=$key options=$arrUse selected=$arrForm[$key]|default:0}--><br>
            文言：<input type="text" name="<!--{$key2}-->" value="<!--{$arrForm[$key2]}-->" />
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">評価順</td>
        <td>
        	レビュー時の評価平均の高い順に並び替えます。<br>
        	<!--{assign var=key value="sort_recommend"}-->
        	<!--{assign var=key2 value="text_recommend"}-->
            <span class="attention"><!--{$arrErr[$key]}--><!--{$arrErr[$key2]}--></span>
			<!--{html_radios name=$key options=$arrUse selected=$arrForm[$key]|default:0}--><br>
            文言：<input type="text" name="<!--{$key2}-->" value="<!--{$arrForm[$key2]}-->" />
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">レビュー数順</td>
        <td>
        	レビュー数の多い順に並び替えます。<br>
        	<!--{assign var=key value="sort_review"}-->
        	<!--{assign var=key2 value="text_review"}-->
            <span class="attention"><!--{$arrErr[$key]}--><!--{$arrErr[$key2]}--></span>
			<!--{html_radios name=$key options=$arrUse selected=$arrForm[$key]|default:0}--><br>
            文言：<input type="text" name="<!--{$key2}-->" value="<!--{$arrForm[$key2]}-->" />
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">割引率順</td>
        <td>
        	割引率[(<!--{$smarty.const.NORMAL_PRICE_TITLE}-->-<!--{$smarty.const.SALE_PRICE_TITLE}-->)/<!--{$smarty.const.NORMAL_PRICE_TITLE}-->]の高い順に並び替えます。<br>
        	<!--{assign var=key value="sort_discount"}-->
        	<!--{assign var=key2 value="text_discount"}-->
            <span class="attention"><!--{$arrErr[$key]}--><!--{$arrErr[$key2]}--></span>
			<!--{html_radios name=$key options=$arrUse selected=$arrForm[$key]|default:0}--><br>
            文言：<input type="text" name="<!--{$key2}-->" value="<!--{$arrForm[$key2]}-->" />
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">売れ筋順</td>
        <td>
        	販売個数の多い順に並び替えます。<br>
        	<!--{assign var=key value="sort_quantity"}-->
        	<!--{assign var=key2 value="text_quantity"}-->
            <span class="attention"><!--{$arrErr[$key]}--><!--{$arrErr[$key2]}--></span>
			<!--{html_radios name=$key options=$arrUse selected=$arrForm[$key]|default:0}--><br>
            文言：<input type="text" name="<!--{$key2}-->" value="<!--{$arrForm[$key2]}-->" />
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">売上順</td>
        <td>
        	販売金額の多い順に並び替えます。<br>
        	<!--{assign var=key value="sort_sales"}-->
        	<!--{assign var=key2 value="text_sales"}-->
            <span class="attention"><!--{$arrErr[$key]}--><!--{$arrErr[$key2]}--></span>
			<!--{html_radios name=$key options=$arrUse selected=$arrForm[$key]|default:0}--><br>
            文言：<input type="text" name="<!--{$key2}-->" value="<!--{$arrForm[$key2]}-->" />
        </td>
    </tr>
</table>

<div class="btn-area">
    <ul>
        <li>
            <a class="btn-action" href="javascript:;" onclick="document.form1.submit();return false;"><span class="btn-next">この内容で登録する</span></a>
        </li>
    </ul>
</div>

</form>
<!--{include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`admin_popup_footer.tpl"}-->
