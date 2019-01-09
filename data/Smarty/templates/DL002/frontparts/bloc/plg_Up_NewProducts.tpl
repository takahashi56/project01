<!--{*
/*
 * Up_NewProducts
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
<!--{if count($arrNewProducts) > 0}-->
<style>
#plg_Up_NewProducts_area .block_title {
font-size: 20px;
color: #232F3E;
font-weight: bold;
border-bottom: 1px solid #232F3E;
padding: 5px 0px;
margin-bottom: 15px;
}
#plg_Up_NewProducts_area .item_panel {
display: inline-block;
vertical-align: top;
margin-right: 15px;		/* ボックス横マージン */
margin-bottom: 20px;	/* ボックス下マージン */
}
#plg_Up_NewProducts_area .item_image {
margin-bottom: 5px;		/* 画像下マージン */
}
#plg_Up_NewProducts_area .review {
color: #E1C030;			/* ☆の色  */
}
#plg_Up_NewProducts_area .review .count {
color: #2A67C7;			/* レビュー数の色  */
}
</style>
<div class="clearfix"></div>
<div class="block_outer">
	<div id="plg_Up_NewProducts_area">
		<h2 class="block_title">
                    <!--{$arrPlugin.free_field1}-->
                        <small class="pull-right all-item">
                            <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php">
                                もっとみる
                            </a>
                        </small>
                </h2>
		<div class="content_panel">

			<!--{*
				新着商品取得数はデフォルトで5まで取得、変更する場合はプラグイン設定から行う
			*}-->
			<!--{foreach from=$arrNewProducts item=arrProduct key="key" name="new_products"}-->


				<div class="item_panel">
					<div class="item_image">
						<a href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrProduct.product_id|u}-->">
								<img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrProduct.main_list_image|sfNoImageMainList|h}-->" alt="<!--{$arrProduct.name|h}-->" />
						</a>
					</div>
					<div class="item_meta">
						<p class="title">
							<a class="ellipsis multiline" href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrProduct.product_id|u}-->"><!--{$arrProduct.main_comment|h}--></a>
						</p>
						<!--{*
							レビュー数の表示、プラグイン設定でONの場合のみ表示
							$arrReviewListの値を検索し、現在のproduct_idと同じなら、そのidのおすすめ度を出力
						*}-->
						<!--{if $arrPlugin.free_field3 == 0}-->
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
						<!--{/if}-->
                        <!--{foreach from=$productStatus[$id] item=status}-->
                        <!--{if $status == 6}-->
                        <img class="prime-banner" src="<!--{$TPL_URLPATH}--><!--{$arrSTATUS_IMAGE[$status]}-->" width="50" height="13" alt="<!--{$arrSTATUS[$status]}-->" id="icon<!--{$status}-->" />
                        <!--{/if}-->
                        <!--{/foreach}-->

<!--
						<p class="sale_price">
							<span class="price">
								<!--{$arrProduct.price02_min_inctax|number_format}--> ポイント
							</span>
						</p>
-->
						<p class="mini comment"><!--{$arrProduct.comment|h|nl2br}--></p>
					</div>
				</div>
			<!--{/foreach}-->
		</div>
	</div>
</div>
<!--{/if}-->
<!--{/strip}-->
