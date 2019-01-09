<!--{if $arrCheckItems}-->
<style type="text/css">
#checked {
	clear:both;
}
#checked h2 {
	background-color:#EFEFEF;
	border: 1px solid #CCC;
	padding:5px;
}
#checked .bloc_exp {
	padding:5px;
}
#checked ul {
	padding:5px;
}
#checked li {
	display:inline-block;
	width: 185px !important;
} 
#checked li a.image-area img {

}
</style>

<!-- PC用 -->
<div class="mfp_bloc bloc_outer pc-tag" style="clear:both;">
	<h2 class="recommendify">お客様が最近チェックした商品</h2>
	<div class="bloc_body">
		<ul class="clearfix line-slider">
		<!--{foreach from=$arrCheckItems item=arrItem name="arrCheckItems"}-->
			<li>
				<a class="rank<!--{$smarty.foreach.arrCheckItems.iteration}--> image-area" href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrItem.product_id|u}-->">
					<img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrItem.main_list_image|sfNoImageMainList|h}-->" 
					alt="<!--{$arrItem.name|h}-->" /></a>
				<div class="info">
					<h3><a class="ellipsis multiline" href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrItem.product_id|u}-->"><!--{$arrItem.name|h}--></a></h3>
					<p class="sale_price"><span class="price">
					<!--{if $arrItem.price02_min_inctax == $arrItem.price02_max_inctax}-->
						<!--{$arrItem.price02_min_inctax|number_format}-->
					<!--{else}-->
						<!--{$arrItem.price02_min_inctax|number_format}-->～<!--{$arrItem.price02_max_inctax|number_format}-->
					<!--{/if}-->ポイント</span></p>
				</div>
			</li>
		<!--{/foreach}-->
		</ul>
	</div>
</div>
<!-- end PC用 -->

<!-- SP用 -->
<div class="mfp_bloc bloc_outer sp-tag" style="clear:both;">
	<h2 class="recommendify">お客様が最近チェックした商品</h2>
	<div id="product-list-wrap">
	<!--{foreach from=$arrCheckItems item=arrItem name="arrCheckItems"}-->
		<div class=" clearfix product-list-item category-lists">
			<div class="list-item-inner clearfix">

				<div class="product-list-img"><div>
					<a href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrItem.product_id|u}-->" class="thumbnail">
						<img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrItem.main_list_image|sfNoImageMainList|h}-->" alt="<!--{$arrItem.name|h}-->">
					</a>
				</div></div>

				<div class="title">
					<!--★商品名★-->
					<a href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrItem.product_id|u}-->" class="thumbnail">
						<!--{$arrItem.name|mb_substr:0:21|h}--><!--{if $arrItem.name|mb_strlen > 21}-->..<!--{/if}-->
					</a>
				</div>

				<!--★価格★-->
				<div class="pointbox">
					<!--{strip}-->
					<img src="<!--{$TPL_URLPATH}-->img/icon/icon_price.png" />
					<span class="point">
					<!--{if $arrItem.price02_min_inctax == $arrItem.price02_max_inctax}-->
						<!--{$arrItem.price02_min_inctax|number_format}-->
					<!--{else}-->
						<!--{$arrItem.price02_min_inctax|number_format}-->～<!--{$arrItem.price02_max_inctax|number_format}-->
					<!--{/if}-->ポイント</span>
					<!--{/strip}-->
				</div>

			</div>
		</div>
	<!--{/foreach}-->
	</div>
</div>
<!-- end SP用 -->

<!--{/if}-->
