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
    $(this).on("click", "#btn_mmr", function(event){
        event.preventDefault();
        $.ajax({
            type: 'POST',
            dataType:'json',
            url: url+'plugin/MailMagazineRegister/plg_MailMagazineRegister_ajax.php',
            data:{
                item:$('#form_mmr').serializeArray(),
            },
            success:function(data) {
                $('#MMRArea').html(data);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {
            }
        });
        event.stopImmediatePropagation();
    });
    $(this).on("click", "#btn_mmr_r", function(event){
        event.preventDefault();
        $(':hidden[name="mode"]').val("mmr_return");
        $.ajax({
            type: 'POST',
            dataType:'json',
            url:url+'plugin/MailMagazineRegister/plg_MailMagazineRegister_ajax.php',
            data:{
                item:$('#form_mmr').serializeArray(),
            },
            success:function(data) {
                $('#MMRArea').html(data);
            },
            error:function(XMLHttpRequest, textStatus, errorThrown) {
            }
        });
        event.stopImmediatePropagation();
    });
});

</script>

<div id="MMRArea">

<!--{if $arrMMR.mode == "regist"}-->
<h2 class="title"><!--{$tpl_title|h}--></h2>
<form name="form_mmr" id="form_mmr" method="post" action="?">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="mmr_confirm" />
<table summary="">
    <col width="30%" />
    <col width="70%" />
    <!--{if $arrMMR.name_disp}-->
    <tr>
        <th>お名前
            <!--{if $arrMMR.name_exist}--><span class="attention">※</span><!--{/if}-->
        </th>
        <td>
            <!--{assign var=key1 value="`$prefix`name01"}-->
            <!--{assign var=key2 value="`$prefix`name02"}-->
            <!--{if $arrErr[$key1] || $arrErr[$key2]}-->
                <div class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></div>
            <!--{/if}-->
            姓&nbsp;<input type="text" name="<!--{$key1}-->" value="<!--{$arrForm[$key1].value|h}-->" maxlength="<!--{$arrForm[$key1].length}-->" style="<!--{$arrErr[$key1]|sfGetErrorColor}-->; ime-mode: active;" class="box120" />&nbsp;
            名&nbsp;<input type="text" name="<!--{$key2}-->" value="<!--{$arrForm[$key2].value|h}-->" maxlength="<!--{$arrForm[$key2].length}-->" style="<!--{$arrErr[$key2]|sfGetErrorColor}-->; ime-mode: active;" class="box120" />
        </td>
    </tr>
    <!--{/if}-->
    <!--{if $arrMMR.kana_disp}-->
    <tr>
        <th>お名前(フリガナ)
            <!--{if $arrMMR.kana_exist}--><span class="attention">※</span><!--{/if}-->
        </th>
        <td>
            <!--{assign var=key1 value="`$prefix`kana01"}-->
            <!--{assign var=key2 value="`$prefix`kana02"}-->
            <!--{if $arrErr[$key1] || $arrErr[$key2]}-->
                <div class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></div>
            <!--{/if}-->
            セイ&nbsp;<input type="text" name="<!--{$key1}-->" value="<!--{$arrForm[$key1].value|h}-->" maxlength="<!--{$arrForm[$key1].length}-->" style="<!--{$arrErr[$key1]|sfGetErrorColor}-->; ime-mode: active;" class="box120" />&nbsp;
            メイ&nbsp;<input type="text" name="<!--{$key2}-->" value="<!--{$arrForm[$key2].value|h}-->" maxlength="<!--{$arrForm[$key1].length}-->" style="<!--{$arrErr[$key2]|sfGetErrorColor}-->; ime-mode: active;" class="box120" />
        </td>
    </tr>
    <!--{/if}-->
    <!--{if $arrMMR.email_disp}-->
        <tr>
            <th>メールアドレス
                <!--{if $arrMMR.email_exist}--><span class="attention">※</span><!--{/if}-->
            </th>
            <td>
                <!--{assign var=key1 value="`$prefix`email"}-->
                <!--{assign var=key2 value="`$prefix`email02"}-->
                <!--{if $arrErr[$key1] || $arrErr[$key2]}-->
                    <div class="attention"><!--{$arrErr[$key1]}--><!--{$arrErr[$key2]}--></div>
                <!--{/if}-->
                <input type="text" name="<!--{$key1}-->" value="<!--{$arrForm[$key1].value|h}-->" style="<!--{$arrErr[$key1]|sfGetErrorColor}-->; ime-mode: disabled;" class="box300 top" /><br />
                <input type="text" name="<!--{$key2}-->" value="<!--{$arrForm[$key2].value|h}-->" style="<!--{$arrErr[$key1]|cat:$arrErr[$key2]|sfGetErrorColor}-->; ime-mode: disabled;" class="box300" /><br />
                <span class="attention mini">確認のため2度入力してください。</span>
            </td>
        </tr>
    <!--{/if}-->
    <!--{if $arrMMR.sex_disp}-->
        <tr>
            <th>性別
                <!--{if $arrMMR.sex_exist}--><span class="attention">※</span><!--{/if}-->
            </th>
            <td>
                <!--{assign var=key1 value="`$prefix`sex"}-->
                <!--{if $arrErr[$key1]}-->
                    <div class="attention"><!--{$arrErr[$key1]}--></div>
                <!--{/if}-->
                <span style="<!--{$arrErr[$key1]|sfGetErrorColor}-->">
                    <!--{html_radios name=$key1 options=$arrSex selected=$arrForm[$key1].value separator='<br />'}-->
                </span>
            </td>
        </tr>
    <!--{/if}-->
    <!--{if $arrMMR.job_disp}-->
        <tr>
            <th>職業
                <!--{if $arrMMR.job_exist}--><span class="attention">※</span><!--{/if}-->
            </th>
            <td>
                <!--{assign var=key1 value="`$prefix`job"}-->
                <!--{if $arrErr[$key1]}-->
                    <div class="attention"><!--{$arrErr[$key1]}--></div>
                <!--{/if}-->
                <select name="<!--{$key1}-->" style="<!--{$arrErr[$key1]|sfGetErrorColor}-->">
                    <option value="" selected="selected">選択してください</option>
                    <!--{html_options options=$arrJob selected=$arrForm[$key1].value}-->
                </select>
            </td>
        </tr>
    <!--{/if}-->
    <!--{if $arrMMR.birth_disp}-->
        <tr>
            <th>生年月日
                <!--{if $arrMMR.birth_exist}--><span class="attention">※</span><!--{/if}-->
            </th>
            <td>
                <!--{assign var=key1 value="`$prefix`year"}-->
                <!--{assign var=key2 value="`$prefix`month"}-->
                <!--{assign var=key3 value="`$prefix`day"}-->
                <!--{assign var=errBirth value="`$arrErr.$key1``$arrErr.$key2``$arrErr.$key3`"}-->
                <!--{if $errBirth}-->
                    <div class="attention"><!--{$errBirth}--></div>
                <!--{/if}-->
                <select name="<!--{$key1}-->" style="<!--{$errBirth|sfGetErrorColor}-->">
                    <!--{html_options options=$arrYear selected=$arrForm[$key1].value|default:''}-->
                </select>年&nbsp;
                <select name="<!--{$key2}-->" style="<!--{$errBirth|sfGetErrorColor}-->">
                    <!--{html_options options=$arrMonth selected=$arrForm[$key2].value|default:''}-->
                </select>月&nbsp;
                <select name="<!--{$key3}-->" style="<!--{$errBirth|sfGetErrorColor}-->">
                    <!--{html_options options=$arrDay selected=$arrForm[$key3].value|default:''}-->
                </select>日
            </td>
        </tr>
    <!--{/if}-->
            <tr>
                <th>メールマガジン送付について<span class="attention">※</span></th>
                <td>
                    <!--{assign var=key1 value="`$prefix`mailmaga_flg"}-->
                    <!--{if $arrErr[$key1]}-->
                        <div class="attention"><!--{$arrErr[$key1]}--></div>
                    <!--{/if}-->
                    <span style="<!--{$arrErr[$key1]|sfGetErrorColor}-->">
                        <!--{html_radios name=$key1 options=$arrMAILMAGATYPE selected=$arrForm[$key1].value separator='<br />'}-->
                    </span>
                </td>
            </tr>
</table>
            <div class="btn_area">
                <ul>
                    <li>
                        <input type="image" class="hover_change_image" src="<!--{$TPL_URLPATH}-->img/button/btn_next.jpg" alt="次へ" name="singular" id="btn_mmr" />
                    </li>
                </ul>
            </div>
        </form>
<!--{elseif $arrMMR.mode == "confirm"}-->
<h2 class="title"><!--{$tpl_title|h}--></h2>
<form name="form_mmr" id="form_mmr" method="post" action="?">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="mmr_complete" />
<table summary="">
    <col width="30%" />
    <col width="70%" />
    <!--{if $arrMMR.name_disp}-->
    <tr>
        <th scope="row">お名前</th>
        <td><!--{$arrForm.name01|h}--> <!--{$arrForm.name02|h}--></td>
    </tr>
    <!--{/if}-->
    <!--{if $arrMMR.kana_disp}-->
    <tr>
        <th scope="row">お名前(フリガナ)</th>
        <td><!--{$arrForm.kana01|h}--> <!--{$arrForm.kana02|h}--></td>
    </tr>
    <!--{/if}-->
    <!--{if $arrMMR.email_disp}-->
    <tr>
        <th scope="row">メールアドレス</th>
        <td><!--{$arrForm.email|h}--></td>
    </tr>
    <!--{/if}-->
    <!--{if $arrMMR.sex_disp}-->
    <tr>
        <th scope="row">性別</th>
        <td><!--{$arrSex[$arrForm.sex]|h}--></td>
    </tr>
    <!--{/if}-->
    <!--{if $arrMMR.job_disp}-->
    <tr>
        <th scope="row">職業</th>
        <td><!--{$arrJob[$arrForm.job]|default:'(未登録)'|h}--></td>
    </tr>
    <!--{/if}-->
    <!--{if $arrMMR.birth_disp}-->
    <tr>
        <th scope="row">生年月日</th>
        <td>
            <!--{$arrForm.birth|regex_replace:"/ .+/":""|regex_replace:"/-/":"/"|default:'(未登録)'|h}-->
        </td>
    </tr>
    <!--{/if}-->
    <tr>
        <th scope="row">メールマガジン送付について</th>
        <td><!--{$arrMAILMAGATYPE[$arrForm.mailmaga_flg]|h}--></td>
    </tr>
</table>
            <div class="btn_area">
                <ul>
                    <li>
                        <input type="image" class="hover_change_image" src="<!--{$TPL_URLPATH}-->img/button/btn_back.jpg" alt="戻る" name="back" id="btn_mmr_r" />
                    </li>
                    <li>
                        <input type="image" class="hover_change_image" src="<!--{$TPL_URLPATH}-->img/button/btn_entry.jpg" alt="会員登録をする" name="send" id="btn_mmr" />
                    </li>
                </ul>
            </div>
        </form>
<!--{elseif $arrMMR.mode == "complete"}-->
<h2 class="title"><!--{$tpl_title|h}--></h2>
<div id="undercolumn">
    <div id="undercolumn_entry">
        <div id="complete_area">
            <p class="message">メルマガ会員登録の受付が完了いたしました。</p>

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
