<!--{*
 * 条件指定商品リスト・ブロック作成プラグイン
 * Copyright (C) 2013 colori
 * 
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 USA
 *}-->
 
<!--{if count($arrProducts) > 0}-->
<style type="text/css">
#<!--{$bloc.mfp_bloc_elementid}--> {
	clear:both;
}
#<!--{$bloc.mfp_bloc_elementid}--> h2 {
	background-color:#EFEFEF;
	border: 1px solid #CCC;
	padding:5px;
}
#<!--{$bloc.mfp_bloc_elementid}--> .bloc_exp {
	padding:5px;
}
#<!--{$bloc.mfp_bloc_elementid}--> ul {
	padding:5px;
}
#<!--{$bloc.mfp_bloc_elementid}--> li {
	display:inline-block;
}
#<!--{$bloc.mfp_bloc_elementid}--> li a.image-area img {
	max-width:<!--{$bloc.mfp_image_width}-->px;
	max-height:<!--{$bloc.mfp_image_height}-->px;
}
</style>

<!-- PC用 -->
<div class="mfp_bloc bloc_outer pc-tag" >
	<!--{* ▼タイトル *}-->
	<!--{if $bloc.mfp_bloc_title}-->
	<h2><!--{$bloc.mfp_bloc_title|h}--></h2>
	<!--{/if}-->
	<!--{* ▲タイトル *}-->
	<div class="bloc_body">		
		<!--{* ▼説明 *}-->
		<!--{if $bloc.mfp_bloc_exp}-->
		<p class="bloc_exp"><!--{$bloc.mfp_bloc_exp|h}--></p>
		<!--{/if}-->
		<!--{* ▲説明 *}-->
	
		<ul class="clearfix line-slider">
		<!--{foreach from=$arrProducts key=product_id item=arrProduct name=arrProducts}-->
			<li>
				<a class="rank<!--{$smarty.foreach.arrProducts.iteration}--> image-area" href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrProduct.product_id|u}-->"><img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrProduct.main_list_image|sfNoImageMainList|h}-->" alt="<!--{$arrProduct.name|h}-->" /></a>
				<div class="info">
					<h3><a class="ellipsis multiline" href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrProduct.product_id|u}-->"><!--{$arrProduct.name|h}--></a></h3>
					<p class="sale_price"><span class="price">
					<!--{if $arrProduct.price02_min_inctax == $arrProduct.price02_max_inctax}-->
						<!--{$arrProduct.price02_min_inctax|number_format}-->
					<!--{else}-->
						<!--{$arrProduct.price02_min_inctax|number_format}-->～<!--{$arrProduct.price02_max_inctax|number_format}-->
					<!--{/if}-->ポイント</span></p>
				</div>
			</li>
		<!--{/foreach}-->
		</ul>
	</div>
</div>
<!-- end PC用 -->

<!-- SP用 -->
<div class="mfp_bloc bloc_outer popular sp-tag">
	<!--{* ▼タイトル *}-->
	<!--{if $bloc.mfp_bloc_title}-->
	<h2 class="recommendify"><!--{$bloc.mfp_bloc_title|h}--></h2>
	<!--{/if}-->
	<!--{* ▲タイトル *}-->

	<div id="product-list-wrap">
		<!--{* ▼説明 *}-->
		<!--{if $bloc.mfp_bloc_exp}-->
		<p class="bloc_exp"><!--{$bloc.mfp_bloc_exp|h}--></p>
		<!--{/if}-->
		<!--{* ▲説明 *}-->

		<!--{foreach from=$arrProducts key=product_id item=arrProduct name=arrProducts}-->
		<div class=" clearfix product-list-item category-lists">
			<div class="list-item-inner clearfix">

				<div class="product-list-img"><div>
					<a href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrProduct.product_id|u}-->" class="thumbnail">
						<img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrProduct.main_list_image|sfNoImageMainList|h}-->" alt="<!--{$arrProduct.name|h}-->" />
					</a>
				</div></div>

				<div class="title">
					<!--★商品名★-->
					<a href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrProduct.product_id|u}-->" class="thumbnail">
						<!--{$arrProduct.name|mb_substr:0:21|h}--><!--{if $arrProduct.name|mb_strlen > 21}-->..<!--{/if}-->
					</a>
				</div>

				<!--★価格★-->
				<div class="pointbox">
					<!--{strip}-->
					<img src="<!--{$TPL_URLPATH}-->img/icon/icon_price.png" />
					<span class="point">
					<!--{if $arrProduct.price02_min_inctax == $arrProduct.price02_max_inctax}-->
						<!--{$arrProduct.price02_min_inctax|number_format}-->
					<!--{else}-->
						<!--{$arrProduct.price02_min_inctax|number_format}-->～<!--{$arrProduct.price02_max_inctax|number_format}-->
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
