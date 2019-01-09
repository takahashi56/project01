<!--{*
 * OperateProductSTrial
 * Copyright(c) 2015 DAISY Inc. All Rights Reserved.
 *
 * http://www.daisy.link/
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
$(function(){
    $('#edit-products')
        .click(function(){
            if(confirm('選択した全ての商品に適用されます。よろしいですか？')){
                fnModeSubmit('edit_products','','');
                $(this).closest('form').trigger('submit');
            }
        });
        
    $('.form.disabled :input').attr('disabled', 'disabled');
})
function checkChangeStock(){
    $('#change-stock').attr('checked','checked');
}
</script>

<style>
#product-list .select{
    text-align:center;
}
#product-list .id{
    text-align:right;
}
</style>

<form name="form1" id="form1" method="post" action="?">
    <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
    <input type="hidden" name="mode" value="edit_products" />
    <!--{assign var=key value="product_ids"}-->
    <!--{foreach from=$arrForm[$key].value item=product_id}-->
        <input type="hidden" name=<!--{$key}-->[]" value="<!--{$product_id|h}-->" />
    <!--{/foreach}-->
    <table class="form">
        <colgroup>
            <col width="20%" />
            <col width="80%" />
        </colgroup>
        <tbody>
            <!--{assign var=key value="status"}-->
            <tr>
                <th>
                    公開・非公開
                </th>
                <td>
                    <span class="attention">
                        <!--{$arrErr[$key]}-->
                    </span>
                    <label>
                        <input type="radio" value="" name="<!--{$key}-->" <!--{if $arrForm[$key].value == ""}-->checked="checked"<!--{/if}--> />
                        変更なし
                    </label>
                    <!--{html_radios options=$arrDisplayStatuses name=$key selected=$arrForm[$key].value}-->
                </td>
            </tr>
        </tbody>
    </table>
    <p class="attention">
        製品版では下記の機能も使用できます。
    </p>
    <table class="form disabled">
        <colgroup>
            <col width="20%" />
            <col width="80%" />
        </colgroup>
        <tbody>
            <!--{assign var=key value="product_status"}-->
            <!--{foreach from=$arrStatuses key=status_key item=name}-->
            <tr>
                <th>
                    <img src="<!--{$TPL_URLPATH_DEFAULT}--><!--{$arrStatusImages[$status_key]}-->" alt="<!--{$name}-->">
                </th>
                <td>
                    <span class="attention">
                        <!--{$arrErr[$key]}-->
                    </span>
                    <label>
                        <input type="radio" value="" name="<!--{$key}-->[<!--{$status_key}-->]" <!--{if $arrForm[$key].value[$status_key] == ""}-->checked="checked"<!--{/if}--> />
                        変更なし
                    </label>
                    <label>
                        <input type="radio" value="1" name="<!--{$key}-->[<!--{$status_key}-->]" <!--{if $arrForm[$key].value[$status_key] == "1"}-->checked="checked"<!--{/if}--> />
                        ON
                    </label>
                    <label>
                        <input type="radio" value="0" name="<!--{$key}-->[<!--{$status_key}-->]" <!--{if $arrForm[$key].value[$status_key] == "0"}-->checked="checked"<!--{/if}--> />
                        OFF
                    </label>
                </td>
            </tr>
            <!--{/foreach}-->
            <!--{assign var=key1 value="change_stock"}-->
            <!--{assign var=key2 value="stock"}-->
            <!--{assign var=key3 value="stock_unlimited"}-->
            <tr>
                <th>
                    在庫数
                </th>
                <td>
                    <span class="attention">
                        <!--{$arrErr[$key1]}-->
                        <!--{$arrErr[$key2]}-->
                        <!--{$arrErr[$key3]}-->
                    </span>
                    <label>
                        <input type="radio" value="" name="<!--{$key1}-->" <!--{if $arrForm[$key1].value == ""}-->checked="checked"<!--{/if}--> />
                        変更なし
                    </label>
                    <input id="change-stock" type="radio" value="1" name="<!--{$key1}-->" <!--{if $arrForm[$key1].value != ""}-->checked="checked"<!--{/if}--> />
                    <input id="stock-number" type="text" name="<!--{$key2}-->" value="<!--{$arrForm[$key2].value}-->" size="6" class="box6" maxlength="<!--{$smarty.const.AMOUNT_LEN}-->" onfocus="checkChangeStock();" style="<!--{$arrErr[$key2]|sfGetErrorColor}-->" />
                    <label>
                        <input type="checkbox" name="<!--{$key3}-->" value="1" onchange="if(this.checked) checkChangeStock(); eccube.checkStockLimit('<!--{$smarty.const.DISABLED_RGB}-->');" <!--{if $arrForm[$key3].value == "1"}-->checked="checked"<!--{/if}-->/>
                        無制限
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
                        
    <h2>
        選択中の商品
    </h2>
    <p class="attention">
        <!--{$arrErr.edit_product_ids}-->
    </p>
    <table id="product-list" class="list">
        <colgroup>
            <col width="10%" />
            <col width="10%" />
            <col width="90%" />
        </colgroup>
        <thead>
            <tr>
                <th>
                    選択
                </th>
                <th>
                    ID
                </th>
                <th>
                    商品名
                </th>
            </tr>
        </thead>
        <tbody>
            <!--{foreach from=$arrProducts item=arrProduct}-->
                <!--{assign var=product_id value=$arrProduct.product_id}-->
                <tr>
                    <!--{assign var=key value="edit_product_ids"}-->
                    <td class="select">
                        <input type="checkbox" name="<!--{$key}-->[]" value="<!--{$product_id}-->" <!--{if $product_id|@in_array:$arrForm[$key].value}-->checked="checked"<!--{/if}--> />
                    </td>
                    <td class="id">
                        <!--{$arrProduct.product_id}-->
                    </td>
                    <td class="name">
                        <!--{$arrProduct.name|h}-->
                    </td>
                </tr>
            <!--{/foreach}-->
        </tbody>
    </table>

    <div class="btn-area">
        <ul>
            <li><a id="edit-products" class="btn-action" href="javascript:;" ><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>
</form>