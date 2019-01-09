<!--{*
 * MailMagaRegist
 * Copyright (C) 2012 S-Cubism CO.,LTD. All Rights Reserved.
 * ttp://ec-cube.ec-orange.jp/
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

<!--▼ MailMagaRegist-->
<div class="block_outer">
    <div id="login_area">
        <h2>メルマガ登録</h2>
        <form name="form1" id="form1" method="post" action="<!--{$smarty.const.HTTPS_URL}-->frontparts/bloc/plg_mailMagaRegist_mailmagaregist.php">
            <input type="hidden" name="mode" value="regist" />
            <!--{$tpl_errMsg}--><!--{$tpl_msg}-->
            <div class="block_body">
                <dl class="formlist">
                    <dt>メールアドレス</dt>
                    <dd>
                        <input type="text" name="email1" class="box140" value="" style="ime-mode: disabled;" /><br />
                        <input type="text" name="email2" class="box140" value="" style="ime-mode: disabled;" /><br />
                        <span class="attention mini">確認のため2度入力してください。</span>
                    </dd>
                </dl>
                <a class="btn-normal" href="#" onclick="fnModeSubmit('regist','',''); return false;"><span class="btn-next">登録</span></a>
            </div>
        </form>
    </div>
</div>
<!--▲ MailMagaRegist-->