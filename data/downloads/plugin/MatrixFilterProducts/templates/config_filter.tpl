<!--{*
 * MatrixFilterProducts
 * Copyright (C) 2013 colori All Rights Reserved.
 * http://colo-ri.jp/
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
$(document).ready(function(){
	$.arrSTATUS = [];
	<!--{foreach from=$arrSTATUS key=status_id item=status}-->
	$.arrSTATUS.push([<!--{$status_id}-->,"<!--{$status|h}-->"]);
	<!--{/foreach}-->
	$.arrCATTREE = [];
	<!--{foreach from=$arrCATTREE key="category_id" item="category_path"}-->
	$.arrCATTREE.push([<!--{$category_id}-->,"<!--{$category_path}-->"]);
	<!--{/foreach}-->
	$.arrURLPARAM = {};
	<!--{foreach from=$arrURLPARAM key=id item=urlparam}-->
	$.arrURLPARAM.<!--{$id}--> = '<!--{$urlparam}-->';
	<!--{/foreach}-->
	$.arrDbFields = [];
	<!--{foreach from=$arrDbFields item=fld}-->
	$.arrDbFields.push('<!--{$fld}-->');
	<!--{/foreach}-->
});
</script>
<script type="text/javascript" src="<!--{$smarty.const.PLUGIN_HTML_URLPATH}-->MatrixFilterProducts/media/plg_MatrixFilterProducts_config.js"></script>
<style type="text/css">
	<!--{include file="`$smarty.const.PLUGIN_HTML_REALDIR`/MatrixFilterProducts/media/plg_MatrixFilterProducts_config.css"}-->
</style>

<h1><span class="title">「<!--{$arrBloc.bloc_name|h}-->」<!--{$tpl_subtitle}--></span></h1>
<form name="form1" id="form1" method="post" action="<!--{$smarty.server.REQUEST_URI|h}-->">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" id="mode" name="mode" value="edit">
<p style="padding:10px 0px">「<!--{$arrBloc.bloc_name|h}-->」へ表示させる商品絞り込み用のフィルターを作成できます。<br />フィルターの組み合わせで商品をAND検索します。</p>

<!--{if !$edited and count($arrFilters)}-->
<h2>フィルターリスト</h2>
<table border="0" cellspacing="1" cellpadding="8" summary=" " style="margin-bottom:5px">
	<tr>
		<th style="width:20%" class="center"><b>ターゲット</b></th>
		<th style="width:20%" class="center"><b>条件</b></th>
		<th style="width:45%" class="center"><b>値</b></th>
        <th style="width:5%" class="center"><b>OR</b></th>
		<th style="width:10%" class="center">&nbsp;</th>
	</tr>
<!--{assign var=or_connect_str value=""}-->
<!--{foreach from=$arrFilters item=arrFilter name=arrFilters}-->

	<!--{* グループ化がチェックされている場合 *}-->
	<!--{if $arrFilter.mfp_filter_or_connect}-->
    	<!--{if !$or_connect_str}-->
        	<!--{if $smarty.foreach.arrFilters.last}-->
            	<!--{assign var=or_connect_str value=""}-->
            <!--{else}-->
    			<!--{assign var=or_connect_str value="┓"}-->
            <!--{/if}-->
        <!--{else}-->
        	<!--{if $smarty.foreach.arrFilters.last}-->
            	<!--{if $or_connect_str != "┛"}-->
            		<!--{assign var=or_connect_str value="┛"}-->
                <!--{else}-->
                	<!--{assign var=or_connect_str value=""}-->
                <!--{/if}-->
            <!--{else}-->
				<!--{if $or_connect_str == "┛"}-->
					<!--{assign var=or_connect_str value="┓"}-->
				<!--{else}-->
        			<!--{assign var=or_connect_str value="┃"}-->
				<!--{/if}-->
            <!--{/if}-->
        <!--{/if}-->
    <!--{* グループ化がチェックされていない場合 *}-->
    <!--{else}-->
    	<!--{if $or_connect_str}-->
        	<!--{if $smarty.foreach.arrFilters.last}-->
            	<!--{if $or_connect_str != "┛"}-->
            		<!--{assign var=or_connect_str value="┛"}-->
                <!--{else}-->
                	<!--{assign var=or_connect_str value=""}-->
                <!--{/if}-->
            <!--{else}-->
    			<!--{assign var=or_connect_str value="┛"}-->
            <!--{/if}-->
        <!--{else}-->
        	<!--{assign var=or_connect_str value=""}-->
        <!--{/if}-->
    <!--{/if}-->
    
	<tr>
		<td style="border-right-width:0px"><!--{$arrTargetName[$arrFilter.mfp_filter_target]}--></td>
		<td class="center"><!--{$arrConditionName[$arrFilter.mfp_filter_condition]}--></td>
		<td style="font-family:monospace">
			<b>
			<!--{* 規定値 *}-->
			<!--{if $arrFilter.mfp_filter_valuetype == $smarty.const.PLG_MFP_FILTER_VALUETYPE_DEFAULT}-->
				<!--{* カテゴリーID *}-->
				<!--{if $arrFilter.mfp_filter_target == $smarty.const.PLG_MFP_FILTER_TARGET_CATEGORY_ID}-->
					<!--{$arrCATTREE[$arrFilter.mfp_filter_value]}-->
				<!--{elseif $arrFilter.mfp_filter_target == $smarty.const.PLG_MFP_FILTER_TARGET_STATUS_ID}-->
					<!--{$arrSTATUS[$arrFilter.mfp_filter_value]}-->
				<!--{/if}-->
			<!--{else}-->
				<!--{$arrFilter.mfp_filter_value|h}-->
			<!--{/if}-->
			</b>
			(<!--{$arrFilterValuetypeName[$arrFilter.mfp_filter_valuetype]}-->)
		</td>
        <td class="center"><!--{$or_connect_str}--></td>
		<td style="" class="center"><a href="javascript:;" title="<!--{$arrFilter.mfp_filter_id}-->" class="list-filter-edit-action">[編集]</a> <a href="javascript:;" title="<!--{$arrFilter.mfp_filter_id}-->" class="list-filter-delete-action">[削除]</a></td>
	</tr>
<!--{/foreach}-->
</table>
<!--{/if}-->


<h2>フィルターを<!--{if $edited}-->編集<!--{else}-->追加<!--{/if}--></h2>

<!--{if count($arrErr)}-->
<p class="attention" style="margin-bottom:1em"><b><!--{foreach from=$arrErr item=err}--><!--{$err}--><!--{/foreach}--></b></p>
<!--{/if}-->

<p><span class="attention">*</span>は必須入力項目です。</p>
<input type="hidden" id="mfp_filter_id" name="mfp_filter_id" value="<!--{$arrForm.mfp_filter_id}-->" />
<input type="hidden" id="mfp_id" name="mfp_id" value="<!--{if $arrForm.mfp_id}--><!--{$arrForm.mfp_id}--><!--{elseif $smarty.get.mfp_id}--><!--{$smarty.get.mfp_id}--><!--{/if}-->" />
<table border="0" cellspacing="1" cellpadding="8" summary=" " id="mfp_filter_list_table">
	<tr>
		<th style="width:15%">ターゲット <span class="attention">*</span></th>
		<td>
			<!--{assign var=options value=$arrTargetName}-->
			<select id="mfp_filter_target" name="mfp_filter_target">
			<!--{foreach from=$options item=option name=options}-->
				<option value="<!--{$smarty.foreach.options.iteration}-->"<!--{if $arrForm.mfp_filter_target==$smarty.foreach.options.iteration}--> selected="selected"<!--{/if}-->><!--{$option|h}--></option>
			<!--{/foreach}-->
			</select>
		</td>
	</tr>
	<tr>
		<th>条件 <span class="attention">*</span></th>
		<td>
		<!--{assign var=options value=$arrConditionName}-->
		<select id="mfp_filter_condition" name="mfp_filter_condition">
		<!--{foreach from=$options item=option name=options}-->
			<option value="<!--{$smarty.foreach.options.iteration}-->"<!--{if $arrForm.mfp_filter_condition==$smarty.foreach.options.iteration}--> selected="selected"<!--{/if}-->><!--{$option|h}--></option>
		<!--{/foreach}-->
		</select>
		</td>
	</tr>
	<tr>
		<th>値 <span class="attention">*</span></th>
		<td>
		<!--{assign var=options value=$arrFilterValuetypeName}-->
		<select id="mfp_filter_valuetype" name="mfp_filter_valuetype">
		<!--{foreach from=$options item=option name=options}-->
			<option value="<!--{$smarty.foreach.options.iteration}-->"<!--{if $arrForm.mfp_filter_valuetype==$smarty.foreach.options.iteration}--> selected="selected"<!--{/if}-->><!--{$option}--></option>
		<!--{/foreach}-->
		</select> 
		<input type="hidden" id="mfp_filter_value" name="mfp_filter_value" value="<!--{$arrForm.mfp_filter_value}-->" />
		<input style="display:none;font-family:monospace" type="text" id="mfp_filter_value_text" name="mfp_filter_value_text" value="<!--{$arrForm.mfp_filter_value}-->" disabled="disabled"/>
		<select style="display:none" id="mfp_filter_value_select" name="mfp_filter_value_select" disabled="disabled"></select> 
		<label id="mfp_filter_except_self_label"><input style="vertical-align:middle" type="checkbox" id="mfp_filter_except_self" name="mfp_filter_except_self" value="1" <!--{if $arrForm.mfp_filter_except_self}-->checked="checked"<!--{/if}-->/>ページの商品は除外</label>
		</td>
	</tr>
    <tr>
		<th>ORグループ</th>
		<td>
		<label id="mfp_filter_or_connect_label"><input style="vertical-align:middle" type="checkbox" id="mfp_filter_or_connect" name="mfp_filter_or_connect" value="1" <!--{if $arrForm.mfp_filter_or_connect}-->checked="checked"<!--{/if}-->/>次のフィルターとOR条件でグループ化</label><br>
        <small>※最後のフィルターでは無視されます</small>
		</td>
	</tr>
</table>

<div class="btn-area">
    <ul>
		<!--{if $edited}-->
		<li><a class="btn-action" href="javascript:;" id="to-filter-default"><span class="btn-prev">フィルター一覧画面に戻る</span></a></li>
		<!--{else}-->
		<li><a class="btn-action" href="javascript:;" id="to-default"><span class="btn-prev">前の画面に戻る</span></a></li>
		<!--{/if}-->
        <li><a class="btn-action" href="javascript:;" id="submit"><span class="btn-next">この内容で設定する</span></a></li>
    </ul>
</div>

</form>
<!--{include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`admin_popup_footer.tpl"}-->
