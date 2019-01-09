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
<div class="mfp_bloc bloc_outer" id="<!--{$bloc.mfp_bloc_elementid}-->">
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
	
		<ul class="clearfix">
		<!--{foreach from=$arrProducts key=product_id item=arrProduct name=arrProducts}-->
			<li>
				<a class="rank<!--{$smarty.foreach.arrProducts.iteration}--> image-area" href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrProduct.product_id|u}-->"><img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrProduct.main_image|sfNoImageMainList|h}-->" alt="<!--{$arrProduct.name|h}-->" /></a>
				<div class="info">
					<h3><a href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrProduct.product_id|u}-->"><!--{$arrProduct.name|h}--></a></h3>
					<p class="sale_price"><span class="price">
					<!--{if $arrProduct.price02_min_inctax == $arrProduct.price02_max_inctax}-->
						<!--{$arrProduct.price02_min_inctax|number_format}-->
					<!--{else}-->
						<!--{$arrProduct.price02_min_inctax|number_format}-->～<!--{$arrProduct.price02_max_inctax|number_format}-->
					<!--{/if}-->円</span></p>
				</div>
			</li>
		<!--{/foreach}-->
		</ul>
	</div>
</div>
<!--{/if}-->