<!--{if $cancel=== false}-->
	<center>クレジット決済に関する注意事項</center>

	<hr>
	ここから先はアナザーレーン株式会社の提供する決済ページに遷移します。<br>
	決済を中断する場合は、このページ内の「クレジット決済を中断する」ボタン、または遷移先のページ内の「戻る」ボタンをご利用ください。<br>
	ブラウザの戻るボタンを利用してページを戻したり、ウインドウを閉じたりなさらないようご注意ください。<br>
	<br>
	<form method="post" action="<!--{$order_url|escape}-->">
		<!--{foreach key=key item=item from=$params}-->
		<input type="hidden" name="<!--{$key}-->" value="<!--{$item}-->">
		<!--{/foreach}-->
		<center><input type="submit" value="クレジット決済に進む"></center>
	</form>
	<br>
	<form method="post" action="./load_payment_module.php" autocomplete="off">
		<input type="hidden" name="Result" value="NG">
		<!--{foreach key=key item=item from=$params}-->
		<input type="hidden" name="<!--{$key}-->" value="<!--{$item}-->">
		<!--{/foreach}-->
		<center><input type="submit" value="クレジット決済を中断する"></center>
	</form>

<!--{else}-->
	<!--{$cancel_msg}-->
<!--{/if}-->
