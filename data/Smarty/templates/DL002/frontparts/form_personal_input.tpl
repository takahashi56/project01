<!--{*
/*
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
 */
*}-->

<!--{strip}-->
            <!--{assign var=errCnt value=0}-->
            <div class="form-group">
                <!--{assign var=key1 value="`$prefix`name01"}-->
                <!--{assign var=key2 value="`$prefix`name02"}-->
                <label for="<!--{$key1}-->" class="col-sm-3 col-md-2 control-label">
                    お名前<span class="attention">※</span>
                </label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-xs-6<!--{if $arrErr[$key1]}--> has-error<!--{/if}-->">
                            <input id="<!--{$key1}-->" type="text" class="box120 form-control" name="<!--{$key1}-->" value="<!--{$arrForm[$key1].value|h}-->" maxlength="<!--{$arrForm[$key1].length}-->" style="<!--{$arrErr[$key1]|sfGetErrorColor}-->; ime-mode: active;" placeholder="姓" />
                            <span class="attention"><!--{$arrErr[$key1]}--></span>
                        </div>
                        <div class="col-xs-6<!--{if $arrErr[$key2]}--> has-error<!--{/if}-->">
                            <input type="text" class="box120 form-control" name="<!--{$key2}-->" value="<!--{$arrForm[$key2].value|h}-->" maxlength="<!--{$arrForm[$key2].length}-->" style="<!--{$arrErr[$key2]|sfGetErrorColor}-->; ime-mode: active;" placeholder="名" />
                            <span class="attention"><!--{$arrErr[$key2]}--></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <!--{assign var=key1 value="`$prefix`kana01"}-->
                <!--{assign var=key2 value="`$prefix`kana02"}-->
                <label for="<!--{$key1}-->" class="col-sm-3 col-md-2 control-label">
                    フリガナ<span class="attention">※</span>
                </label>
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-xs-6<!--{if $arrErr[$key1]}--> has-error<!--{/if}-->">
                            <input type="text" id="<!--{$key1}-->" class="box120 form-control" name="<!--{$key1}-->" value="<!--{$arrForm[$key1].value|h}-->" maxlength="<!--{$arrForm[$key1].length}-->" style="<!--{$arrErr[$key1]|sfGetErrorColor}-->; ime-mode: active;" placeholder="セイ" />
                            <span class="attention"><!--{$arrErr[$key1]}--></span>
                        </div>
                        <div class="col-xs-6<!--{if $arrErr[$key2]}--> has-error<!--{/if}-->">
                            <input type="text" class="box120 form-control" name="<!--{$key2}-->" value="<!--{$arrForm[$key2].value|h}-->" maxlength="<!--{$arrForm[$key2].length}-->" style="<!--{$arrErr[$key2]|sfGetErrorColor}-->; ime-mode: active;" placeholder="メイ" />
                            <span class="attention"><!--{$arrErr[$key2]}--></span>
                        </div>
                    </div>
                </div>
            </div>

            <!--{assign var=key1 value="`$prefix`zip01"}-->
            <!--{assign var=key2 value="`$prefix`zip02"}-->
            <!--{assign var=key3 value="`$prefix`pref"}-->
            <!--{assign var=key4 value="`$prefix`addr01"}-->
            <!--{assign var=key5 value="`$prefix`addr02"}-->
            <input type="hidden" id="<!--{$key1}-->" name="<!--{$key1}-->" value="<!--{if $arrForm[$key1].value}--><!--{$arrForm[$key1].value|h}--><!--{else}-->000<!--{/if}-->" />
            <input type="hidden" id="<!--{$key2}-->" name="<!--{$key2}-->" value="<!--{if $arrForm[$key2].value}--><!--{$arrForm[$key2].value|h}--><!--{else}-->0000<!--{/if}-->" />
            <input type="hidden" id="<!--{$key3}-->" name="<!--{$key3}-->" value="<!--{if $arrForm[$key3].value}--><!--{$arrForm[$key3].value|h}--><!--{else}-->1<!--{/if}-->" />
            <input type="hidden" id="<!--{$key4}-->" name="<!--{$key4}-->" value="<!--{if $arrForm[$key4].value}--><!--{$arrForm[$key4].value|h}--><!--{else}-->ダミー<!--{/if}-->" />
            <input type="hidden" id="<!--{$key5}-->" name="<!--{$key5}-->" value="<!--{if $arrForm[$key5].value}--><!--{$arrForm[$key5].value|h}--><!--{else}-->ダミー<!--{/if}-->" />

            <!--{assign var=key1 value="`$prefix`tel01"}-->
            <!--{assign var=key2 value="`$prefix`tel02"}-->
            <!--{assign var=key3 value="`$prefix`tel03"}-->
            <input type="hidden" id="<!--{$key1}-->" name="<!--{$key1}-->" value="<!--{if $arrForm[$key1].value}--><!--{$arrForm[$key1].value|h}--><!--{else}-->000<!--{/if}-->" />
            <input type="hidden" id="<!--{$key2}-->" name="<!--{$key2}-->" value="<!--{if $arrForm[$key2].value}--><!--{$arrForm[$key2].value|h}--><!--{else}-->0000<!--{/if}-->" />
            <input type="hidden" id="<!--{$key3}-->" name="<!--{$key3}-->" value="<!--{if $arrForm[$key3].value}--><!--{$arrForm[$key3].value|h}--><!--{else}-->0000<!--{/if}-->" />

            <!--{assign var=key1 value="`$prefix`fax01"}-->
            <!--{assign var=key2 value="`$prefix`fax02"}-->
            <!--{assign var=key3 value="`$prefix`fax03"}-->
            <input type="hidden" id="<!--{$key1}-->" name="<!--{$key1}-->" value="<!--{if $arrForm[$key1].value}--><!--{$arrForm[$key1].value|h}--><!--{else}-->000<!--{/if}-->" />
            <input type="hidden" id="<!--{$key2}-->" name="<!--{$key2}-->" value="<!--{if $arrForm[$key2].value}--><!--{$arrForm[$key2].value|h}--><!--{else}-->0000<!--{/if}-->" />
            <input type="hidden" id="<!--{$key3}-->" name="<!--{$key3}-->" value="<!--{if $arrForm[$key3].value}--><!--{$arrForm[$key3].value|h}--><!--{else}-->0000<!--{/if}-->" />

    <!--{if $flgFields > 1}-->
            <div class="form-group">
                <!--{assign var=key1 value="`$prefix`email"}-->
                <!--{assign var=key2 value="`$prefix`email02"}-->
                <label for="<!--{$key1}-->" class="col-sm-3 col-md-2 control-label">
                    メールアドレス<span class="attention">※</span>
                </label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <div class="col-md-7<!--{if $arrErr[$key1]}--> has-error<!--{/if}-->">
                            <input type="email" id="<!--{$key1}-->" class="box380 top form-control" name="<!--{$key1}-->" value="<!--{$arrForm[$key1].value|h}-->" style="<!--{$arrErr[$key1]|sfGetErrorColor}-->; ime-mode: disabled;" placeholder="user@domain.com" />
                            <span class="attention"><!--{$arrErr[$key1]}--></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-7<!--{if $arrErr[$key2]}--> has-error<!--{/if}-->">
                            <input type="email" class="box380 form-control" name="<!--{$key2}-->" value="<!--{$arrForm[$key2].value|h}-->" style="<!--{$arrErr[$key1]|cat:$arrErr[$key2]|sfGetErrorColor}-->; ime-mode: disabled;" placeholder="メールアドレス確認用" />
                            <span class="attention"><!--{$arrErr[$key2]}--></span>
                            <p class="mini help-block"><span class="attention">確認のため2度入力してください。</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <!--{if $emailMobile}-->
                <div class="form-group">
                    <!--{assign var=key1 value="`$prefix`email_mobile"}-->
                    <!--{assign var=key2 value="`$prefix`email_mobile02"}-->
                    <label for="<!--{$key1}-->" class="col-sm-3 col-md-2 control-label">
                        携帯メールアドレス
                    </label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <div class="col-md-7<!--{if $arrErr[$key1]}--> has-error<!--{/if}-->">
                                <input type="email" id="<!--{$key1}-->" class="box380 top form-control" name="<!--{$key1}-->" value="<!--{$arrForm[$key1].value|h}-->" style="<!--{$arrErr[$key1]|sfGetErrorColor}-->; ime-mode: disabled;" maxlength="<!--{$smarty.const.MTEXT_LEN}-->" placeholder="user@mobile.com" />
                                <span class="attention"><!--{$arrErr[$key1]}--></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-7<!--{if $arrErr[$key2]}--> has-error<!--{/if}-->">
                                <input type="email" class="box380 form-control" name="<!--{$key2}-->" value="<!--{$arrForm[$key2].value|h}-->" style="<!--{$arrErr[$key1]|cat:$arrErr[$key2]|sfGetErrorColor}-->; ime-mode: disabled;" maxlength="<!--{$smarty.const.MTEXT_LEN}-->" placeholder="メールアドレス確認用" />
                                <span class="attention"><!--{$arrErr[$key2]}--></span>
                                <p class="mini help-block"><span class="attention">確認のため2度入力してください。</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            <!--{/if}-->

            <!--{assign var=key1 value="`$prefix`sex"}-->
            <input type="hidden" id="<!--{$key1}-->" name="<!--{$key1}-->" value="<!--{if $arrForm[$key1].value}--><!--{$arrForm[$key1].value|h}--><!--{else}-->1<!--{/if}-->" />

            <div class="form-group">
                <!--{assign var=key1 value="`$prefix`year"}-->
                <!--{assign var=key2 value="`$prefix`month"}-->
                <!--{assign var=key3 value="`$prefix`day"}-->
                <!--{assign var=errBirth value="`$arrErr.$key1``$arrErr.$key2``$arrErr.$key3`"}-->
                <label for="<!--{$key1}-->" class="col-sm-3 col-md-2 control-label">
                    生年月日
                </label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <div class="col-md-7<!--{if $arrErr[$key1]}--> has-error<!--{/if}-->">
                            <div class="form-group">
                                <div class="col-xs-4 col-sm-4 padding-right-xs<!--{if $arrErr[$key1]}--> has-error<!--{/if}-->">
                                    <select id="<!--{$key1}-->" class="form-control" name="<!--{$key1}-->" style="<!--{$errBirth|sfGetErrorColor}-->">
                                    <!--{html_options options=$arrYear selected=$arrForm[$key1].value|default:''}-->
                                    </select>
                                </div>
                                <label class="control-label col-xs-1 padding-none">年</label>
                                <div class="col-xs-3 col-sm-3 padding-right-xs<!--{if $arrErr[$key1]}--> has-error<!--{/if}-->">
                                    <select class="form-control" name="<!--{$key2}-->" style="<!--{$errBirth|sfGetErrorColor}-->">
                                    <!--{html_options options=$arrMonth selected=$arrForm[$key2].value|default:''}-->
                                    </select>
                                </div>
                                <label class="control-label col-xs-1 padding-none margin-none">月</label>
                                <div class="col-xs-3 col-sm-3 padding-right-xs<!--{if $arrErr[$key1]}--> has-error<!--{/if}-->">
                                    <select class="form-control" name="<!--{$key3}-->" style="<!--{$errBirth|sfGetErrorColor}-->">
                                    <!--{html_options options=$arrDay selected=$arrForm[$key3].value|default:''}-->
                                    </select>
                                </div>
                                <label class="control-label col-xs-1 padding-none">日</label>
                            </div>
                            <span class="attention"><!--{$errBirth}--></span>
                        </div>
                    </div>
                </div>
            </div>
        <!--{if $flgFields > 2}-->
            <div class="form-group">
                <!--{assign var=key1 value="`$prefix`password"}-->
                <!--{assign var=key2 value="`$prefix`password02"}-->
                <label for="<!--{$key1}-->" class="col-sm-3 col-md-2 control-label">
                    希望するパスワード（記号可）<span class="attention">※</span>
                </label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <div class="col-md-7<!--{if $arrErr[$key1]}--> has-error<!--{/if}-->">
                            <input type="password" id="<!--{$key1}-->" class="box380 top form-control" name="<!--{$key1}-->" value="<!--{$arrForm[$key1].value|h}-->" maxlength="<!--{$arrForm[$key1].length}-->" style="<!--{$arrErr[$key1]|sfGetErrorColor}-->" placeholder="半角英数字<!--{$smarty.const.PASSWORD_MIN_LEN}-->～<!--{$smarty.const.PASSWORD_MAX_LEN}-->文字" />
                            <span class="attention"><!--{$arrErr[$key1]}--></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-7<!--{if $arrErr[$key2]}--> has-error<!--{/if}-->">
                            <input type="password" class="box380 form-control" name="<!--{$key2}-->" value="<!--{$arrForm[$key2].value|h}-->" maxlength="<!--{$arrForm[$key2].length}-->" style="<!--{$arrErr[$key1]|cat:$arrErr[$key2]|sfGetErrorColor}-->" placeholder="パスワード確認用" />
                            <span class="attention"><!--{$arrErr[$key2]}--></span>
                            <p class="mini help-block"><span class="attention">確認のため2度入力してください。</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <!--{assign var=key1 value="`$prefix`reminder"}-->
                <!--{assign var=key2 value="`$prefix`reminder_answer"}-->
                <label for="<!--{$key1}-->" class="col-sm-3 col-md-2 control-label">
                    パスワードを忘れた時のヒント<span class="attention">※</span>
                </label>
                <div class="col-sm-9">
                    <div class="form-group">
                        <div class="col-md-7<!--{if $arrErr[$key1]}--> has-error<!--{/if}-->">
                            <select id="<!--{$key1}-->" class="form-control" name="<!--{$key1}-->" style="<!--{$arrErr[$key1]|sfGetErrorColor}-->">
                                <option value="" selected="selected">質問を選択してください</option>
                                <!--{html_options options=$arrReminder selected=$arrForm[$key1].value}-->
                            </select>
                            <span class="attention"><!--{$arrErr[$key1]}--></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-7<!--{if $arrErr[$key2]}--> has-error<!--{/if}-->">
                            <input type="text" class="box380 form-control" name="<!--{$key2}-->" value="<!--{$arrForm[$key2].value|h}-->" style="<!--{$arrErr[$key2]|sfGetErrorColor}-->; ime-mode: active;" placeholder="質問の答え" />
                            <span class="attention"><!--{$arrErr[$key2]}--></span>
                        </div>
                    </div>
                </div>
            </div>

            <!--{assign var=key1 value="`$prefix`mailmaga_flg"}-->
            <input type="hidden" id="<!--{$key1}-->" name="<!--{$key1}-->" value="2" />

        <!--{/if}-->
    <!--{/if}-->
<!--{/strip}-->
