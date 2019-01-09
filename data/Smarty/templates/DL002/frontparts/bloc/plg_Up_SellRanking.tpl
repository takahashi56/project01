<!--{*
/*
 * Up_SellRanking
 * Copyright(c) 2014 Designup All Rights Reserved.
 *
 * http://designup.jp/
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
 */
 *}-->
<!--{strip}-->
<!--{if count($arrBestProducts) > 0}-->
<div class="block_outer">
	<div id="plg_Up_SellRanking_area">
		<h2 class="ranking-block">総合<!--{$blocTitle}--></h2>
		<div id="product-list-wrap" class="clearfix">
		<!--{*
			ランキング表示、表示数はプラグイン設定から行う
		*}-->
		<!--{foreach from=$arrBestProducts item=arrProduct name="bestseller"}-->
			<div class="product-list-item category-lists"><div class="list-item-inner clearfix">
				<div class="product-list-img"><div>
					<a href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrProduct.product_id|u}-->">
						<img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrProduct.main_list_image|sfNoImageMainList|h}-->" alt="<!--{$arrProduct.name|h}-->" />
					</a>
				</div></div>
				<div class="title">
					<!--★商品名★-->
					<a href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrProduct.product_id|u}-->" class="thumbnail">
						<!--{$arrProduct.name|mb_substr:0:21|h}--><!--{if $arrProduct.name|mb_strlen > 21}-->..<!--{/if}-->
					</a>
				</div>

				<div class="indicator-row">
				<!--{foreach from=$productStatus[$id] item=icons}-->
					<!--{foreach from=$icons item=icon}-->
					<img src="<!--{$TPL_URLPATH}-->img/icon/ico_0<!--{$icon}-->.png">
					<!--{/foreach}-->
				<!--{/foreach}-->
				</div>

				<!--★価格★-->
				<div class="pointbox">
					<!--{strip}-->
					<!-- VIP会員価格がある場合は出力する -->
					<!--{if $arrProduct.vip_price}-->
						<img src="<!--{$TPL_URLPATH}-->img/icon/icon_price.png" />
						<span class="point">
						<!--{$arrProduct.vip_price|number_format}-->
						<!--{if $tpl_product_type[$id] == 1}-->
							円<span class="mini">(税込)</span>
						<!--{else}-->
							ポイント
						<!--{/if}-->
					<!--{else}-->
						<!--{if $arrProduct.price02_min_inctax == $arrProduct.price02_max_inctax}-->
							<img src="<!--{$TPL_URLPATH}-->img/icon/icon_price.png" />
							<span class="point">
							<!--{$arrProduct.price02_min_inctax|number_format}-->
							<!--{if $tpl_product_type[$id] == 1}-->
								円<span class="mini">(税込)</span>
							<!--{else}-->
								ポイント
							<!--{/if}-->
						<!--{else}-->
							<!--{$arrProduct.price02_min_inctax|number_format}-->円～
						<!--{/if}-->
					<!--{/if}-->
					<!--{/strip}-->
					</span>
				</div>
				<div class="rank"><!--{$smarty.foreach.bestseller.iteration}--></div>
			</div></div>
		<!--{/foreach}-->
		</div>
	</div>
</div>
<!--{/if}-->
<!--{/strip}-->
