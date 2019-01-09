<!--{*
 * AutoMetaKeyword
 * Copyright(c) C-Rowl Co., Ltd. All Rights Reserved.
 * http://www.c-rowl.com/
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
<p>メタタグ（Keyword）自動設定プラグインの設定が行えます。<br/>
    <br/>
</p>

<table border="0" cellspacing="1" cellpadding="8" summary=" ">
    <tr>
        <td colspan="2" width="90" bgcolor="#f3f3f3">▼メタタグ自動設定プラグイン設定</td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">商品一覧画面のメタタグ（Keyword）設定<span class="attention">※</span></td>
        <td>
        <!--{assign var=key value="list"}-->
        <span class="attention"><!--{$arrErr[$key]}--></span>
        <input type="radio" name="list" value="1" <!--{if $arrForm.list == "1"}-->checked<!--{/if}--> >カテゴリ名を自動設定する</input><br/>
        <input type="radio" name="list" value="2" <!--{if $arrForm.list == "2"}-->checked<!--{/if}--> >自動設定しない</input>
        </td>
    </tr>
    <tr>
        <td bgcolor="#f3f3f3">商品詳細画面のメタタグ（Keyword）設定<span class="attention">※</span></td>
        <td>
        <!--{assign var=key value="detail"}-->
        <span class="attention"><!--{$arrErr[$key]}--></span>
        <input type="radio" name="detail" value="1" <!--{if $arrForm.detail == "1"}-->checked<!--{/if}--> >商品名を自動設定する</input><br />
        <input type="radio" name="detail" value="2" <!--{if $arrForm.detail == "2"}-->checked<!--{/if}--> >自動設定しない</input>
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
