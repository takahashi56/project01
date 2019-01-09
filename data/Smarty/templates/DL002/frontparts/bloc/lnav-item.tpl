<div class="nav lnav lnav-item">
	<ul>
		<li class="right-drop" id="menu1">
			<span class="navicon icon_geta chiled"></span><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=48">最新作</a>
			<ul class="sub-menu" style="display:none">
				<!--{foreach from=$arrSaisin item= arrChild}-->
				<li><a class="outbox-parent" href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=<!--{$arrChild.category_id}-->"><!--{$arrChild.category_name}--></a></li>
				<!--{/foreach}-->
			</ul>
		</li>
		<li>
		  <span class="navicon icon_geta"></span><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=161">近々配信終了する作品</a>
		</li>
		<li class="right-drop">
			<span class="navicon icon_user"></span><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=101">メインジャンル一覧</a>
			<ul class="sub-menu" style="display:none">
				<!--{foreach from=$arrFetchType item= arrChild}-->
				<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=<!--{$arrChild.category_id}-->"><!--{$arrChild.category_name}--></a></li>
				<!--{/foreach}-->
			</ul>
		</li>
		<li class="right-drop">
			<span class="navicon icon_video"></span><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/label.php">シリーズ一覧</a>
			<ul class="sub-menu" style="display:none">
				<!--{foreach from=$arrLabel item= arrChild}-->
				<li><a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=<!--{$arrChild.category_id}-->"><!--{$arrChild.category_name}--></a></li>
				<!--{/foreach}-->
			</ul>
			</li>
		<li class="right-drop">
			<span class="navicon icon_graph"></span><a href="<!--{$smarty.const.ROOT_URLPATH}-->user_data/ranking.php">ランキング</a>
			<ul class="sub-menu" style="display:none">
				<!--{foreach from=$arrBestProducts item=arrProduct name="bestseller" }-->
				<li>
				<a href="<!--{$smarty.const.ROOT_URLPATH}-->products/detail.php?product_id=<!--{$arrProduct.product_id|u}-->">ランキング<!--{$smarty.foreach.bestseller.iteration}-->位</a>
				<div class="outbox" style="display:none"><!--{$arrProduct.name|h}--></div>
				</li>
				<!--{/foreach}-->
			</ul>
			</li>
	</ul>
</div>
<div class="separator"></div>