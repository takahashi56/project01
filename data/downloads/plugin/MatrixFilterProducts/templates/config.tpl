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
<script type="text/javascript" src="<!--{$smarty.const.PLUGIN_HTML_URLPATH}-->MatrixFilterProducts/media/plg_MatrixFilterProducts_config.js"></script>
<style type="text/css">
	<!--{include file="`$smarty.const.PLUGIN_HTML_REALDIR`/MatrixFilterProducts/media/plg_MatrixFilterProducts_config.css"}-->
</style>

<h1><span class="title"><!--{$tpl_subtitle}--></h1>
<form name="form1" id="form1" method="post" action="<!--{$smarty.server.REQUEST_URI|h}-->">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" id="mode" name="mode" value="edit">
<p style="padding:10px 0px">複数の検索条件を組み合わせた商品リストブロックを作成できます。</p>

<!--{if !$arrForm.mfp_id and count($arrBlocs)}-->
<h2>ブロックリスト</h2>
<table border="0" cellspacing="1" cellpadding="8" summary=" " style="margin-bottom:5px">
	<tr>
		<th style="width:5%" class="center"><b>ID</b></th>
		<th style="" class="center"><b>ブロック名</b></th>
		<th style="width:17%" class="center"><b>デバイス</b></th>
		<th style="" class="center"><b>操作</b></th>
		<th style="width:20%" class="center" colspan="2"><b>フィルター</b></th>
	</tr>
<!--{foreach from=$arrBlocs item=arrBloc name=arrBlocs}-->
	<!--{assign var=mfp_id value=$arrBloc.mfp_id}-->
	<tr>
		<td class="center"><b><!--{$mfp_id}--></b></td>
		<td><b><!--{$arrBloc.mfp_bloc_name|h}--></b></td>
		<td class="center"><!--{$arrDEVICETYPE[$arrBloc.device_type_id]}--></td>
		<td style="width:20%" class="center"><a href="javascript:;" onclick="window.opener.location.href='/admin/design/bloc.php?bloc_id=<!--{$arrBloc.bloc_id}-->&device_type_id=<!--{$arrBloc.device_type_id}-->';">[ブロックに移動]</a><br /><a href="javascript:;" title="<!--{$arrBloc.mfp_id}-->" class="list-edit-action">[編集]</a> <a href="javascript:;" title="<!--{$arrBloc.mfp_id}-->" class="list-delete-action">[削除]</a></td>
		<td>
			<!--{assign var=arrFilters value=$arrAllFilters[$arrBloc.mfp_id]}-->
			<!--{if $arrFilters}-->
			<p class="center"><!--{$arrFilters|@count}--></p>
			<!--{else}-->
			<p class="center">未設定</p>
			<!--{/if}-->
		</td>
		<td style="width:10%" class="center"><a href="javascript:;" title="<!--{$arrBloc.mfp_id}-->" class="list-filter-action">[編集]</a></td>
	</tr>
<!--{/foreach}-->
</table>
<!--{/if}-->


<h2>ブロックを<!--{if $edited}-->編集<!--{else}-->作成<!--{/if}--></h2>

<!--{if count($arrErr)}-->
<p class="attention" style="margin-bottom:1em"><b><!--{foreach from=$arrErr item=err}--><!--{$err}--><!--{/foreach}--></b></p>
<!--{/if}-->

<p><span class="attention">*</span>は必須入力項目です。</p>
<input type="hidden" id="mfp_id" name="mfp_id" value="<!--{$arrForm.mfp_id}-->" />
<input type="hidden" id="mfp_bloc_id" name="mfp_bloc_id" value="<!--{$arrForm.mfp_bloc_id}-->" />
<input type="hidden" id="mfp_device_type_id" name="mfp_device_type_id" value="<!--{if $arrForm.mfp_device_type_id}--><!--{$arrForm.mfp_device_type_id}--><!--{else}--><!--{$smarty.const.DEVICE_TYPE_PC}--><!--{/if}-->" />
<table border="0" cellspacing="1" cellpadding="8" summary=" " style="margin-bottom:5px">
	<tr>
		<th style="width:25%">ブロック名 <span class="attention">*</span></th>
		<td><input type="text" id="mfp_bloc_name" name="mfp_bloc_name" value="<!--{$arrForm.mfp_bloc_name}-->" /></td>
	</tr>
	<tr>
		<th style="width:25%">ID名 <span class="attention">*</span></th>
		<td>
		<input type="text" id="mfp_bloc_elementid" name="mfp_bloc_elementid" value="<!--{$arrForm.mfp_bloc_elementid}-->" /><br />
		<!--{if $arrForm.mfp_id}--><small class="attention" style="font-family:monospace">※ID名を変更するとテンプレートファイル名も変更されます。</small><!--{/if}--></td>
	</tr>
	<tr>
		<th>タイトル</th>
		<td><input type="text" id="mfp_bloc_title" name="mfp_bloc_title" value="<!--{$arrForm.mfp_bloc_title}-->" /></td>
	</tr>
	<tr>
		<th>説明文</th>
		<td><textarea id="mfp_bloc_exp" name="mfp_bloc_exp"><!--{$arrForm.mfp_bloc_exp}--></textarea></td>
	</tr>
	<tr>
		<th>デバイス</th>
		<td>
		<select id="mfp_device_type_id" name="mfp_device_type_id">
		<!--{foreach from=$arrDEVICETYPE key=device_type_id item=device_type_name}-->
			<option value="<!--{$device_type_id}-->"<!--{if $arrForm.mfp_device_type_id and $arrForm.mfp_device_type_id==$device_type_id}--> selected="selected"<!--{/if}-->><!--{$device_type_name}--></option>
		<!--{/foreach}-->
		</select><br />
		<!--{if $arrForm.mfp_id}--><small class="attention" style="font-family:monospace">※デバイスを変更すると配置されていたレイアウト情報が削除されます。</small><!--{/if}-->
		</td>
	</tr>
	<tr>
		<th>表示数 <span class="attention">*</span></th>
		<td>
		<select id="mfp_num" name="mfp_num">
		<!--{section name=mfp_num loop=100}-->
			<option value="<!--{$smarty.section.mfp_num.iteration}-->"<!--{if ($arrForm.mfp_num and $arrForm.mfp_num==$smarty.section.mfp_num.iteration) or (!$arrForm.mfp_num and $smarty.section.mfp_num.iteration==$smarty.const.PLG_MFP_NUM_DEFAULT)}--> selected="selected"<!--{/if}-->><!--{$smarty.section.mfp_num.iteration}--></option>
		<!--{/section}-->
		</select>&nbsp;件
		</td>
	</tr>
	<tr>
		<th>ピックアップ順 <span class="attention">*</span></th>
		<td>
		<!--{assign var=options value=$arrDimensionName}-->
		<select id="mfp_order_dimension" name="mfp_order_dimension">
		<!--{foreach from=$options key=k item=opt name=options}-->
			<option value="<!--{$k}-->"<!--{if $arrForm.mfp_order_dimension==$k}--> selected="selected"<!--{/if}-->><!--{$opt}--></option>
		<!--{/foreach}-->
		</select>

		<!--{assign var=options value=$arrDirectionName}-->
		<select id="mfp_order_direction" name="mfp_order_direction">
		<!--{foreach from=$options item=opt name=options}-->
			<option value="<!--{$smarty.foreach.options.iteration}-->"<!--{if $arrForm.mfp_order_direction==$smarty.foreach.options.iteration}--> selected="selected"<!--{/if}-->><!--{$opt}--></option>
		<!--{/foreach}-->
		</select>
		
		<label><input type="checkbox" id="mfp_disp_random" name="mfp_disp_random" value="1" <!--{if $arrForm.mfp_disp_random==1}-->checked="checked" <!--{/if}-->/>ランダム表示にする</label>
		</td>
	</tr>
	<tr>
		<th>商品画像の幅</th>
		<td><input type="text" id="mfp_image_width" name="mfp_image_width" value="<!--{if $arrForm.mfp_image_width}--><!--{$arrForm.mfp_image_width}--><!--{else}--><!--{$smarty.const.SMALL_IMAGE_WIDTH}--><!--{/if}-->" /> ピクセル</td>
	</tr>
	<tr>
		<th>商品画像の高さ</th>
		<td><input type="text" id="mfp_image_height" name="mfp_image_height" value="<!--{if $arrForm.mfp_image_height}--><!--{$arrForm.mfp_image_height}--><!--{else}--><!--{$smarty.const.SMALL_IMAGE_HEIGHT}--><!--{/if}-->" /> ピクセル</td>
	</tr>
</table>

<div class="btn-area">
    <ul>
		<!--{if $arrForm.mfp_id}-->
		<li><a class="btn-action" href="javascript:;" id="to-default"><span class="btn-prev">前の画面に戻る</span></a></li>
		<!--{/if}-->
        <li><a class="btn-action" href="javascript:;" onclick="document.form1.submit();return false;"><span class="btn-next">この内容で設定する</span></a></li>
    </ul>
</div>

</form>
<!--{include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`admin_popup_footer.tpl"}-->
