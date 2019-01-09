<!--{*
 * この商品を買った人はこんな商品も買っていますプラグイン
 * 会員情報に法人・部門を付与します
 * Copyright (C) 2013 Nobuhiko Kimoto
 * http://nob-log.info/contact/
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *}-->

<!--{include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`admin_popup_header.tpl"}-->

<h2><!--{$tpl_subtitle}--></h2>

<form name="form1" id="form1" method="post" action="<!--{$smarty.server.REQUEST_URI|h}-->" enctype="multipart/form-data">
    <input type="hidden" name="mode" value="register">
    <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
    <input type="hidden" name="image_key" value="" />
    <!--{foreach key=key item=item from=$arrForm.arrHidden}-->
        <input type="hidden" name="<!--{$key}-->" value="<!--{$item|h}-->" />
    <!--{/foreach}-->

    <p>
    「この商品を買った人はこんな商品も買っていますプラグイン」ブロックが作成されていますので商品詳細画面に設置してください。<br>
    ※商品詳細画面以外では動作いたしませんのでご注意ください
    </p>

    <table border="0" cellspacing="1" cellpadding="8" summary="プラグイン項目設定画面">
        <tr><!--{assign var=key value="free_field1"}-->
            <th><!--{$arrTitle[$key]}--></th>
            <td>
                <span class="attention"><!--{$arrErr[$key]}--></span>
                <input type="text" name="<!--{$key}-->" value="<!--{$arrForm[$key].value|h}-->" maxlength="<!--{$arrForm[$key].length}-->" size="60" class="box60" style="<!--{$arrErr[$key]|sfGetErrorColor}-->" />
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
