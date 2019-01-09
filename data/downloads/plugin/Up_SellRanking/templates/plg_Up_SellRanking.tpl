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
<style>
#plg_Up_SellRanking_area .block_title {
font-size: 16px;
border-bottom: 1px solid #aaa;
border-left: 6px solid #aaa;
padding: 5px 10px;
margin-bottom: 15px;
}
#plg_Up_SellRanking_area .item_panel {
display: inline-block;
vertical-align: top;
margin-right: 15px;		/* ボックス横マージン */
margin-bottom: 20px;	/* ボックス下マージン */
}
#plg_Up_SellRanking_area .item_image {
margin-bottom: 5px;		/* 画像下マージン */
}
#plg_Up_SellRanking_area .review {
color: #E1C030;			/* ☆の色  */
}
#plg_Up_SellRanking_area .review .count {
color: #2A67C7;			/* レビュー数の色  */
}
</style>
<div class="clearfix"></div>
<div class="block_outer">
	<div id="plg_Up_SellRanking_area">
		<h4 class="block_title"><!--{$blocTitle}--></h4>
		<div class="content_panel">

		<!--{*
			ランキング表示、表示数はプラグイン設定から行う
		*}-->
		<!--{foreach from=$arrBestProducts item=arrProduct name="bestseller"}-->
			<div class="item_panel">

				<div class="item_image">
					<a href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrProduct.product_id|u}-->">
						<img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrProduct.main_list_image|sfNoImageMainList|h}-->" alt="<!--{$arrProduct.name|h}-->" />
					</a>
				</div>

				<div class="item_meta">
					<p class="title">
						<!--{* ループインデックスで順位表示 *}-->
						<span class="rank_num num-<!--{$smarty.foreach.bestseller.iteration}-->">
								<!--{$smarty.foreach.bestseller.iteration}-->位.
						</span>
						<a href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrProduct.product_id|u}-->">
							<!--{$arrProduct.name|h}-->
						</a>
					</p>
					
					<!--{*
						メーカー名の表示
					*}-->
					<!--{foreach from=$arrMakerList item=arrMaker key="key" name="maker_list"}-->
						<!--{if $arrMaker.product_id == $arrProduct.product_id}-->
							<p class="maker"><!--{$arrMaker.neme}--></p>
						<!--{/if}-->
					<!--{/foreach}-->

					<!--{*
						レビュー数の表示
						$arrReviewListの値を検索し、現在のproduct_idと同じなら、そのidのおすすめ度を出力
					*}-->
					<!--{foreach from=$arrReviewList item=arrReview key="key" name="review_list"}-->
						<!--{if $arrReview.product_id == $arrProduct.product_id}-->
							<p class="review">
								<!--{if $arrReview.recommend_level==5}-->
									★★★★★
								<!--{elseif $arrReview.recommend_level==4}-->
									★★★★☆
								<!--{elseif $arrReview.recommend_level==3}-->
									★★★☆☆
								<!--{elseif $arrReview.recommend_level==2}-->
									★★☆☆☆
								<!--{elseif $arrReview.recommend_level==1}-->
									★☆☆☆☆
								<!--{else}-->
									☆☆☆☆☆
								<!--{/if}-->
								<span class="count"> (<!--{$arrReview.recommend_count}-->)</span>
							</p>
						<!--{/if}-->
					<!--{/foreach}-->

					<p class="sale_price">
						<span class="price">
							<!--{$arrProduct.price02_min_inctax|number_format}--> 円
						</span>
					</p>
				</div>
			</div>
		<!--{/foreach}-->
		</div>
	</div>
</div>
<!--{/if}-->
<!--{/strip}-->
