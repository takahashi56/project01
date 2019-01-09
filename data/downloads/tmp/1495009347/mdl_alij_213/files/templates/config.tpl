<!--{include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`admin_popup_header.tpl"}-->

<h2><!--{$smarty.const.MDL_ALIJ_TITLE}--></h2>

<form name="form1" id="form1" method="post" action="<!--{$smarty.server.REQUEST_URI|escape}-->">
<input type="hidden" name="mode" value="edit">
<input type="hidden" name="<!--{$key}-->"  value="1" >
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
ALIJ決済モジュールをご利用頂く為には、ユーザ様ご自身で
アナザーレーン株式会社様とご契約を行っていただく必要があります。 <br/>
お申し込みにつきましては、下記のページから、お申し込みを行って下さい。<br/><br/>
<a href="#" onClick="win_open('http://www.alij.ne.jp/')" > ＞＞ ALIJ決済システムについて</a><br/>

<table class="form">
	<colgroup width="25%"></colgroup>
	<colgroup width="75%"></colgroup>
	<tr>
		<th>SiteID</th>
		<td>
			<!--{assign var=key value="siteid"}-->
			<span class="red12"><!--{$arrErr[$key]}--></span>
			<input type="text" name="<!--{$key}-->" style="ime-mode:disabled; <!--{$arrErr[$key]|sfGetErrorColor}-->" value="<!--{$arrForm[$key].value}-->" class="box10" maxlength="<!--{$arrForm[$key].length}-->">
		</td>
	</tr>
	<tr>
		<th>SitePASS</th>
		<td>
			<!--{assign var=key value="sitepass"}-->
			<span class="red12"><!--{$arrErr[$key]}--></span>
			<input type="text" name="<!--{$key}-->" style="ime-mode:disabled; <!--{$arrErr[$key]|sfGetErrorColor}-->" value="<!--{$arrForm[$key].value}-->" class="box10" maxlength="<!--{$arrForm[$key].length}-->">
		</td>
	</tr>
	<tr>
		<th>クイックチャージ</th>
		<td>
			使用する<br/>
				<!--{assign var=key value="quickcharge"}-->
				<!--{if $arrForm[$key].value === "true"}-->
					<input type="checkbox" name="quickcharge" value="true" checked>

				<!--{else}-->
					<input type="checkbox" name="quickcharge" value="true">
				<!--{/if}-->
			※クイックチャージをご希望の際は弊社までご連絡ください。
		</td>
	</tr>
</table>
<div class="btn-area">
  <ul>
      <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', 'edit', '', ''); return false;"><span class="btn-next">登録</span></a></li>&nbsp;&nbsp;&nbsp;
       <li><a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form1', '', '', ''); return false;"><span class="btn-next">戻る</span></a></li>

  </ul>
</div>
</form>


<!--{include file="`$smarty.const.TEMPLATE_ADMIN_REALDIR`admin_popup_footer.tpl"}-->
