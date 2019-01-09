<div class="clearfix"></div>
<div class="point-info">
<!--{if $tpl_login !== false}-->
	<!--{if $smarty.const.USE_POINT !== false}-->&nbsp;
	<span class="user_name"><!--{$CustomerName1|h}--> <!--{$CustomerName2|h}--> 様</span>&nbsp;は現在&nbsp;<span class="point st"><!--{$CustomerPoint|number_format|default:"0"|h}--></span>&nbsp;ポイント保有されています。（ポイントは <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=2">こちら</a> からご購入いただけます。）
	<!--{/if}-->
<!--{else}-->
	<!--{if $smarty.const.USE_POINT !== false}-->&nbsp;
	<span class="user_name">ゲスト 様</span>&nbsp;は現在&nbsp;<span class="point st">0</span>&nbsp;ポイント保有されています。（ポイントは <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=2">こちら</a> からご購入いただけます。）
	<!--{/if}-->
<!--{/if}-->
</div>