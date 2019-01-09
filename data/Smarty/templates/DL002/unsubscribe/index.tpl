<!--{*
 * EC-CUBE on Bootstrap3. This file is part of EC-CUBE
 *
 * Copyright(c) 2014 clicktx. All Rights Reserved.
 *
 * http://perl.no-tubo.net/
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

<div id="undercolumn">
    <h2 class="title"><!--{$tpl_title|h}--></h2>
    <div id="undercolumn_contact col-sm-12">
        <p class="margin-bottom-lg">下記入力内容で送信してもよろしいでしょうか？<br />
            よろしければ、一番下の「確認する」ボタンをクリックしてください。</p>
        <form name="form1" id="form1" method="post" action="?">
            <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
            <input type="hidden" name="mode" value="complete" />
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <table summary="お問い合わせ内容確認" class="table table-bordered">
                        <col width="30%" />
                        <col width="70%" />
                        <tr>
                            <th>お名前</th>
                            <td><!--{$arrData.name01|h}-->　<!--{$arrData.name02|h}--></td>
                        </tr>
                        <tr>
                            <th>お名前(フリガナ)</th>
                            <td><!--{$arrData.kana01|h}-->　<!--{$arrData.kana02|h}--></td>
                        </tr>
                        <tr>
                            <th>郵便番号</th>
                            <td>
                                <!--{if strlen($arrData.zip01) > 0 && strlen($arrData.zip02) > 0}-->
                                    〒<!--{$arrData.zip01|h}-->-<!--{$arrData.zip02|h}-->
                                <!--{/if}-->
                            </td>
                        </tr>
                        <tr>
                            <th>住所</th>
                            <td><!--{$arrPref[$arrData.pref]}--><!--{$arrData.addr01|h}--><!--{$arrData.addr02|h}--></td>
                        </tr>
                        <tr>
                            <th>電話番号</th>
                            <td>
                                <!--{if strlen($arrData.tel01) > 0 && strlen($arrData.tel02) > 0 && strlen($arrData.tel03.value) > 0}-->
                                    <!--{$arrData.tel01|h}-->-<!--{$arrData.tel02|h}-->-<!--{$arrData.tel03.value|h}-->
                                <!--{/if}-->
                            </td>
                        </tr>
                        <tr>
                            <th>メールアドレス</th>
                            <td><a href="mailto:<!--{$arrData.email|escape:'hex'}-->"><!--{$arrData.email|escape:'hexentity'}--></a></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="btn_area row padding-left-md padding-right-md">
                <div class="col-sm-3 padding-right-none hidden-xs">
                    <a href="/" class="btn btn-default btn-block">戻る</a>
                </div>
                <div class="col-sm-6">
                    <button name="send_button" id="send_button" class="btn btn-primary btn-block xs-btn-lg sm-btn-lg">確認する</button>
                </div>
                <div class="col-xs-12 visible-xs margin-top-sm">
                    <a href="/" class="btn btn-default btn-sm btn-block">戻る</a>
                </div>
            </div>

        </form>
    </div>
</div>
