<!--{*
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
 *}-->

<!--{include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`admin_popup_header.tpl"}-->
<script type="text/javascript">
</script>

<h2><!--{$tpl_subtitle}--></h2>
<form name="form1" id="form1" method="post" action="<!--{$smarty.server.REQUEST_URI|h}-->">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="edit">

<h3>設定</h3>
<table border="0" cellspacing="1" cellpadding="8" summary=" ">
        <col width="30%" />
        <col width="70%" />
    <tr >
        <th>会員価格タイトル<span class="attention">※</span></th>
        <td><span class="attention"><!--{$arrErr.member_rank_price_title_mode}--></span>
        会員ランク名をタイトルに<!--{html_options name="member_rank_price_title_mode" options=$arrMode selected=$arrForm.member_rank_price_title_mode|default:0}-->
        <br><span class="attention"><!--{$arrErr.member_rank_price_title}--></span>
        固定表示タイトル：<input type="text" class="box160" name="member_rank_price_title" value="<!--{$arrForm.member_rank_price_title}-->" style="<!--{if $arrErr.member_rank_price_title != ""}-->background-color: <!--{$smarty.const.ERR_COLOR}-->;<!--{/if}-->">
        </td>
    </tr>
    <tr >
        <th>会員価格の表示設定<span class="attention">※</span></th>
        <td><span class="attention"><!--{$arrErr.login_disp}--></span><!--{html_radios options=$arrLoginDisp name="login_disp" selected=$arrForm.login_disp|default:0}--></td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">更新期間</td>
        <td>
        	<!--{assign var=key value="term"}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
			<!--{html_options name=$key options=$arrTerm selected=$arrForm[$key]|default:0}-->
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">対象受注ステータス設定<br><span style="font-size:10px; color:#0000FF;">昇格条件の購入金額、購入回数のカウント対象とする受注ステータスを設定します</span></td>
        <td>
        	<!--{assign var=key value="target_id"}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
        	<!--{html_checkboxes options=$arrORDERSTATUS name=$key selected=$arrForm[$key] separator="<br>"}-->
        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">ポイント有効期限設定</td>
        <td>        
        	<!--{assign var=key value="point_term"}-->
            <span class="attention"><!--{$arrErr[$key]}--></span>
			<input type="text" name="point_term" value="<!--{$arrForm[$key]}-->" class="box10">日間
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

<h3>手動チェック</h3>
<form name="form2" id="form2" method="post" action="<!--{$smarty.server.REQUEST_URI|h}-->">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="rank_check">
<div class="btn-area">
    <ul>
        <li>
            <a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form2','rank_check','','');return false;"><span class="btn-next">全会員のランクチェックを行う</span></a>
        </li>
        <br><br>
        <li>
            <a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form2','rank_reset','','');return false;"><span class="btn-next">更新期間内のランクチェックフラグをリセットする</span></a>
        </li>
    </ul>
</div>
</form>
<!--{include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`admin_popup_footer.tpl"}-->
