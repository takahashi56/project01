<!--{*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2014 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *}-->

<!--{strip}-->

<script type="text/javascript">

var url = '<!--{$smarty.const.TOP_URLPATH}-->';

jQuery(function($){
    $(this).on("click", "#btn_mmw", function(event){
        event.preventDefault();
        $.ajax({
            type: 'POST',
            dataType:'json',
            url:url+'plugin/MailMagazineRegister/plg_MailMagazineRegisterW_ajax.php',
            data:{
                item:$('#form_mmw').serializeArray(),
            },
            success:function(data) {
                $('#MMWArea').html(data);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {
            }
        });
        event.stopImmediatePropagation();
    });
    $(this).on("click", "#btn_mmw_r", function(event){
        event.preventDefault();
        $(':hidden[name="mode"]').val("mmw_return");
        $.ajax({
            type: 'POST',
            dataType:'json',
            url:url+'plugin/MailMagazineRegister/plg_MailMagazineRegisterW_ajax.php',
            data:{
                item:$('#form_mmw').serializeArray(),
            },
            success:function(data) {
                $('#MMWArea').html(data);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {
            }
        });
        event.stopImmediatePropagation();
    });
});

</script>

<div id="MMWArea">

<!--{if $arrMMR.mode == "regist"}-->
<h2 class="title"><!--{$tpl_title|h}--></h2>
<form name="form_mmw" id="form_mmw" method="post" action="?">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="mmw_confirm" />
<table summary="">
    <col width="30%" />
    <col width="70%" />
        <tr>
            <th>メールアドレス
                <!--{if $arrMMR.email_exist}--><span class="attention">※</span><!--{/if}-->
            </th>
            <td>
                <!--{assign var=key1 value="`$arrMMR.prefix`email"}-->
                <!--{assign var=key2 value="`$arrMMR.prefix`email02"}-->
                <!--{if $arrErr[$key1] || $arrErr[$key2]}-->
                    <div class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></div>
                <!--{/if}-->
                <input type="text" name="<!--{$key1}-->" value="<!--{$arrForm[$key1].value|h}-->" style="<!--{$arrErr[$key1]|sfGetErrorColor}-->; ime-mode: disabled;" class="box300 top" /><br />
<!--{if false}-->
                <input type="text" name="<!--{$key2}-->" value="<!--{$arrForm[$key2].value|h}-->" style="<!--{$arrErr[$key1]|cat:$arrErr[$key2]|sfGetErrorColor}-->; ime-mode: disabled;" class="box300" /><br />
                <span class="attention mini">確認のため2度入力してください。</span>
<!--{/if}-->
            </td>
        </tr>
</table>
            <div class="btn_area">
                <ul>
                    <li>
                        <input type="image" class="hover_change_image" src="<!--{$TPL_URLPATH}-->img/button/btn_next.jpg" alt="次へ" name="singular" id="btn_mmw" />
                    </li>
                </ul>
            </div>
        </form>
<!--{elseif $arrMMR.mode == "confirm"}-->
<h2 class="title"><!--{$tpl_title|h}--></h2>
<p>メルマガ会員を退会します。よろしいですか？</p>
<form name="form_mmw" id="form_mmw" method="post" action="?">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="mmw_complete" />
<table summary="">
    <col width="30%" />
    <col width="70%" />
    <tr>
        <th scope="row">メールアドレス</th>
        <td>
            <!--{assign var=key value="`$arrMMR.prefix`email"}-->
            <!--{$arrForm[$key]|h}-->
        </td>
    </tr>
</table>
            <div class="btn_area">
                <ul>
                    <li>
                        <input type="image" class="hover_change_image" src="<!--{$TPL_URLPATH}-->img/button/btn_back.jpg" alt="戻る" name="back" id="btn_mmw_r" />
                    </li>
                    <li>
                        <input type="image" class="hover_change_image" src="<!--{$TPL_URLPATH}-->img/button/btn_refuse_do.jpg" alt="会員退会をする" name="send" id="btn_mmw" />
                    </li>
                </ul>
            </div>
        </form>
<!--{elseif $arrMMR.mode == "complete"}-->
<h2 class="title"><!--{$tpl_title|h}--></h2>
<div id="undercolumn">
    <div id="undercolumn_entry">
        <div id="complete_area">
            <p class="message"><!--{$MSG|h}--></p>

            <div class="btn_area">
                <ul>
                    <li>
                        <a href="<!--{$smarty.const.TOP_URL}-->"><img class="hover_change_image" src="<!--{$TPL_URLPATH}-->img/button/btn_toppage.jpg" alt="トップページへ" /></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--{/if}-->

</div>

<!--{/strip}-->
