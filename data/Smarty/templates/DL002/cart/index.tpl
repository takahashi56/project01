<!--{*
 * EC-CUBE on Bootstrap3. This file is part of EC-CUBE
 *
 * Copyright(c) 2014 clicktx. All Rights Reserved.
 *
 * http://perl.no-tubo.net/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *}-->

<div id="undercolumn">
	<div id="undercolumn_cart">
		<h2 class="title"><!--{$tpl_title|h}--></h2>
		<img class="pc-tag" src="<!--{$TPL_URLPATH}-->img/icon/icon_step1.png" />
		<img class="sp-tag flow" src="<!--{$TPL_URLPATH}-->img/icon/step1.jpg" />

		<p class="totalmoney_area">
			<!--{* カートの中に商品がある場合にのみ表示 *}-->
			<!--{if count($cartKeys) > 1}-->
				<div class="alert alert-danger">
					<span class="fa fa-warning"></span>
					<!--{foreach from=$cartKeys item=key name=cartKey}--><!--{$arrProductType[$key]|h}--><!--{if !$smarty.foreach.cartKey.last}-->、<!--{/if}--><!--{/foreach}-->は同時購入できません。
					お手数ですが、個別に購入手続きをお願い致します。
				</div>
			<!--{/if}-->

			<!--{if strlen($tpl_error) != 0}-->
				<div class="alert alert-danger"><span class="fa fa-warning"></span><!--{$tpl_error|h}--></div>
			<!--{/if}-->

			<!--{if strlen($tpl_message) != 0}-->
				<div class="alert alert-danger"><span class="fa fa-warning"></span><!--{$tpl_message|h|nl2br}--></div>
			<!--{/if}-->
		</p>

		<!--{if count($cartItems) > 0}-->
		  <h3>今すぐ買う</h3>
			<!--{foreach from=$cartKeys item=key}-->
				<form name="form<!--{$key|h}-->" id="form<!--{$key|h}-->" method="post" action="?">
					<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME|h}-->" value="<!--{$transactionid|h}-->" />
					<input type="hidden" name="mode" value="confirm" />
					<input type="hidden" name="cart_no" value="" />
					<input type="hidden" name="cartKey" value="<!--{$key|h}-->" />
					<input type="hidden" name="category_id" value="<!--{$tpl_category_id|h}-->" />
					<input type="hidden" name="product_id" value="<!--{$tpl_product_id|h}-->" />

					<div class="form_area">
						<!--{if count($cartKeys) > 1}-->
							<div class="panel-heading">
								<h3 class="margin-none padding-none"><!--{$arrProductType[$key]|h}--></h3>
							</div>
							<!--{assign var=purchasing_goods_name value=$arrProductType[$key]}-->
						<!--{else}-->
							<!--{assign var=purchasing_goods_name value="カートの中の商品"}-->
						<!--{/if}-->
						<div class="list-group">

							<!--{foreach from=$cartItems[$key] item=item}-->
							<div class="cart-tr" style="<!--{if $item.error}-->background-color: <!--{$smarty.const.ERR_COLOR|h}-->;<!--{/if}-->">

								<div class="clearfix">


									<div class="img-col">
									<!--{if $item.productsClass.main_image|strlen >= 1}-->
										<a class="expansion" target="_blank" href="<!--{$smarty.const.IMAGE_SAVE_URLPATH|h}--><!--{$item.productsClass.main_image|sfNoImageMainList|h}-->">
									<!--{/if}-->
											<img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$item.productsClass.main_image|sfNoImageMainList|h}-->" class="img-responsive" alt="<!--{$item.productsClass.name|h}-->" />
											<!--{if $item.productsClass.main_image|strlen >= 1}-->
										</a>
									<!--{/if}-->
									</div>
									<div class="item-description"><!--{* 商品名 *}-->
										<div class="cart-item-title">
											<a href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$item.productsClass.product_id|u}-->"><!--{$item.productsClass.name|h}--></a>
										</div>
										<!--{if $item.productsClass.classcategory_name1 != ""}-->
											<div><small><!--{$item.productsClass.class_name1|h}-->：<!--{$item.productsClass.classcategory_name1|h}--></small></div>
										<!--{/if}-->
										<!--{if $item.productsClass.classcategory_name2 != ""}-->
											<div><small><!--{$item.productsClass.class_name2|h}-->：<!--{$item.productsClass.classcategory_name2|h}--></small></div>
										<!--{/if}-->
										<div class="cart-item-price">
										  <!--{if $key != $smarty.const.PRODUCT_TYPE_DOWNLOAD}-->
											価格:&nbsp;&nbsp;<strong><!--{$item.price_inctax|number_format|h}-->&nbsp;&nbsp;円</strong>
										  <!--{else}-->
											ポイント:&nbsp;&nbsp;<strong><!--{$item.price_inctax|number_format|h}-->&nbsp;ポイント</strong>
										  <!--{/if}-->
										</div>
										<div class="delete-cart">
										  <a class="btn-delete" href="?" onclick="eccube.fnFormModeSubmit('form<!--{$key|h}-->', 'delete', 'cart_no', '<!--{$item.cart_no|h}-->'); return false;">
										  	削除
										  </a>
									</div>
									</div>
								</div>

							</div>
							<!--{/foreach}-->
							
						</div><!--{* list-group *}-->

						<!--{*panel-footer*}-->
						<a href="<!--{$tpl_prev_url|h}-->" class="btn btn-default btn-block btn-sm pc-tag">お買い物を続ける</a>
					</div>
				</form>
			<!--{/foreach}-->
			<!--{if $tpl_prev_url != ""}-->
			<div class="hidden-md hidden-lg">
				
			</div>
			<!--{/if}-->

			<div id="button-area">
				<div class="order-confirm">
					<!--{if strlen($tpl_error) == 0}-->
						<div class="">
							<a href="<!--{$tpl_prev_url|h}-->" class="sp-tag btn-style02 btn-elm">お買い物を続ける</a>
							<button class="command-button btn-style01 btn-elm" name="confirm" onclick="document.form<!--{$key|h}-->.submit()">ご注文手続きへ</button>
						</div>
						<div class="nortice">
							クーポンは次の画面で設定できます。
						</div>
					<!--{/if}-->
					<div class="price-area">
						  <!--{if $key != $smarty.const.PRODUCT_TYPE_DOWNLOAD}-->
  							<span class="title">合計金額（税込）：</span>
    						<span class="price"><!--{$arrData[$key].total-$arrData[$key].deliv_fee|number_format|h}-->&nbsp;&nbsp;円</span>
						  <!--{else}-->
    						<span class="title">合計ポイント：</span>
    						<span class="price"><!--{$arrData[$key].total-$arrData[$key].deliv_fee|number_format|h}-->&nbsp;ポイント</span>
						  <!--{/if}-->
					</div>
				</div>
			</div>
		<!--{else}-->
			<p class="empty alert alert-warning">※ 現在カート内に商品はございません。</p>
		<!--{/if}-->
	</div>
</div>
