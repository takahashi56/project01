<style type="text/css">
<!--
.alij_payment{
    margin:10px 40px;

}

h2.alij_title {
    margin-bottom: 10px;
    padding: 8px;
    border-top: solid 1px #ebeced;
    color: #f60;
    background: url("../img/background/bg_tit_sub_01.jpg") repeat-x left bottom;
    background-color: #fef3d8;
    font-size: 170%;
}

.alij_announce {
    margin-bottom: 30px;
    padding: 10px;
    border: solid 1px #ffcc62;
    background-color: #fffaf0;
}
-->
</style>


<div class="alij_payment">

<!--{if $cancel=== false}-->
<h2 class="title">決済前に必ずお読みください</h2>

<div class="alij_announce">
	ここから先はアナザーレーン株式会社の提供する決済ページに遷移します。<br/>
	決済を中断する場合は、このページ内の「クレジット決済を中断する」ボタン、または遷移先のページ内の「戻る」ボタンをご利用ください。<br/>
	ブラウザの戻るボタンを利用してページを戻したり、ウインドウを閉じたりなさらないようご注意ください。<br/>
</div>

	<form method="post" action="<!--{$order_url|escape}-->">
		<!--{foreach key=key item=item from=$params}-->
		<input type="hidden" name="<!--{$key}-->" value="<!--{$item}-->">
		<!--{/foreach}-->
		<center><input type="submit" value="クレジット決済に進む"></center>
	</form>

	<br/><br/>

	<form method="post" action="./load_payment_module.php" autocomplete="off">
		<input type="hidden" name="Result" value="NG">
		<!--{foreach key=key item=item from=$params}-->
		<input type="hidden" name="<!--{$key}-->" value="<!--{$item}-->">
		<!--{/foreach}-->
		<center><input type="submit" value="クレジット決済を中断する"></center>
	</form>

	<br>
	<hr>

<!--{else}-->

<div class="alij_announce">
	<!--{$cancel_msg}-->
</div>
<!--{/if}-->
</div>