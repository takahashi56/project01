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

<script type="text/javascript">//<![CDATA[
    var sent = false;

    function fnCheckSubmit() {
        if (sent) {
            alert("只今、処理中です。しばらくお待ち下さい。");
            return false;
        }
        sent = true;
        return true;
    }
//]]></script>

<!--CONTENTS-->
<div id="undercolumn">
    <div id="undercolumn_shopping">
        <h2 class="title"><!--{$tpl_title|h}--></h2>
		    <img src="<!--{$TPL_URLPATH}-->img/icon/icon_step3.png" class="pc-tag" />
        <img class="sp-tag flow" src="<!--{$TPL_URLPATH}-->img/icon/step3.jpg" />

        <h3>こちらの商品を購入します</h3>

        <form name="form1" id="form1" method="post" action="?mode=confirm">
            <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
            <input type="hidden" name="mode" value="confirm" />
            <input type="hidden" name="uniqid" value="<!--{$tpl_uniqid}-->" />

            <div class="form_area">
  						<!--{if count($arrCartItems) > 1}-->
  							<div class="panel-heading">
  								<h3 class="margin-none padding-none"><!--{$arrProductType[$key]|h}--></h3>
  							</div>
  							<!--{assign var=purchasing_goods_name value=$arrProductType[$key]}-->
  						<!--{else}-->
  							<!--{assign var=purchasing_goods_name value="カートの中の商品"}-->
  						<!--{/if}-->
  						<div class="list-group">

  							<!--{foreach from=$arrCartItems item=item}-->
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
  										  <!--{if $cartKey != $smarty.const.PRODUCT_TYPE_DOWNLOAD}-->
  											価格:&nbsp;&nbsp;<strong><!--{$item.price_inctax|number_format|h}-->&nbsp;&nbsp;円</strong>
  										  <!--{else}-->
  											ポイント:&nbsp;&nbsp;<strong><!--{$item.price_inctax|number_format|h}-->&nbsp;ポイント</strong>
  										  <!--{/if}-->
  										</div>

  										<div class="delete-cart pc-tag">
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
  					</div>

            <!--{* ▼お届け先 *}-->
            <!--{if $arrShipping}-->
                <h3 class="margin-top-xl margin-bottom-md">
                    <span class="fa fa-caret-right"></span> お届け先
                    <div class="pull-right">
                        <a href="./payment.php?mode=return" class="btn btn-default btn-xs"><span class="fa fa-pencil"></span> 変更</a>
                    </div>
                </h3>
            <!--{/if}-->

            <!--{foreach item=shippingItem from=$arrShipping name=shippingItem}-->
                <div class="panel panel-default">
                    <div class="panel-heading text-bold">
                        お届け先
                    <!--{if $is_multiple}--><!--{$smarty.foreach.shippingItem.iteration}--><!--{/if}-->
                    </div>
                    <div class="list-group">
                        <div class="list-group-item">
                            <small>
                                〒<!--{$shippingItem.shipping_zip01|h}-->-<!--{$shippingItem.shipping_zip02|h}--><br />
                                <!--{$arrPref[$shippingItem.shipping_pref]}--><!--{$shippingItem.shipping_addr01|h}--><!--{$shippingItem.shipping_addr02|h}--><br />
                            <!--{if $smarty.const.FORM_COUNTRY_ENABLE}-->
                                <!--{$arrCountry[$shippingItem.shipping_country_id]|h}-->
                                &nbsp;ZIPCODE：<!--{$shippingItem.shipping_zipcode|h}--><br />
                            <!--{/if}-->
                            </small>
                            <!--{if $shippingItem.shipping_company_name}-->
                                会社名：<!--{$shippingItem.shipping_company_name|h}--><br />
                                担当者：<!--{$shippingItem.shipping_name01|h}--> <!--{$shippingItem.shipping_name02|h}--><br />
                            <!--{else}-->
                                お名前：<!--{$shippingItem.shipping_name01|h}--> <!--{$shippingItem.shipping_name02|h}-->（<!--{$shippingItem.shipping_kana01|h}--> <!--{$shippingItem.shipping_kana02|h}-->）<br />
                            <!--{/if}-->
                            <small>
                                TEL：<!--{$shippingItem.shipping_tel01}-->-<!--{$shippingItem.shipping_tel02}-->-<!--{$shippingItem.shipping_tel03}--><br />
                            <!--{if $shippingItem.shipping_fax01 > 0}-->
                                FAX：<!--{$shippingItem.shipping_fax01}-->-<!--{$shippingItem.shipping_fax02}-->-<!--{$shippingItem.shipping_fax03}--><br />
                            <!--{/if}-->
                            </small>
                        </div>
                        <!--{if $cartKey != $smarty.const.PRODUCT_TYPE_DOWNLOAD}-->
                        <div class="list-group-item">
                            <div class="row">
                                <div class="col-xs-6">
                                    <small><strong>お届け日：</strong><!--{$shippingItem.shipping_date|default:"指定なし"|h}--></small>
                                </div>
                                <div class="col-xs-6">
                                    <small><strong>お届け時間：</strong><!--{$shippingItem.shipping_time|default:"指定なし"|h}--></small>
                                </div>
                            </div>
                        </div>
                        <!--{/if}-->

                    <!--{if $is_multiple}-->
                        <div class="">
                            <!--{foreach item=item from=$shippingItem.shipment_item}-->
                                <div class="list-group-item clearfix">
                                    <div class="col-xs-3 col-sm-2 col-md-1 padding-none">
                                        <a
                                            <!--{if $item.productsClass.main_image|strlen >= 1}--> href="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$item.productsClass.main_image|sfNoImageMainList|h}-->" class="expansion" target="_blank"
                                            <!--{/if}-->
                                        >
                                            <img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$item.productsClass.main_image|sfNoImageMainList|h}-->" class="img-responsive" alt="<!--{$item.productsClass.name|h}-->" /></a>
                                    </div>
                                    <div class="col-xs-9 col-sm-10 col-md-11"><!--{* 商品名 *}--><strong><!--{$item.productsClass.name|h}--></strong><br />
                                        <!--{if $item.productsClass.classcategory_name1 != ""}-->
                                            <!--{$item.productsClass.class_name1}-->：<!--{$item.productsClass.classcategory_name1}--><br />
                                        <!--{/if}-->
                                        <!--{if $item.productsClass.classcategory_name2 != ""}-->
                                            <!--{$item.productsClass.class_name2}-->：<!--{$item.productsClass.classcategory_name2}-->
                                        <!--{/if}-->
                                    </div>
                                    <div class="col-xs-12 text-right padding-none">
                                        <div class="col-xs-4 col-xs-offset-3 col-sm-offset-5 col-md-offset-6 padding-none">
                                            <small>数量：</small><strong><!--{$item.quantity}--></strong>
                                        </div>
                                        <div class="col-xs-5 col-sm-3 col-md-2 padding-none">
                                            <!--{if $key != $smarty.const.PRODUCT_TYPE_DOWNLOAD}-->
                                                <small>小計：</small><strong><!--{$item.total_inctax|number_format}--> 円</strong>
                                            <!--{else}-->
                                                <small>小計：</small><strong><!--{$item.total_inctax|number_format}--> ポイント</strong>
                                            <!--{/if}-->
                                        </div>
                                    </div>
                                </div>
                            <!--{/foreach}-->
                        </div>
                    <!--{/if}-->

                    </div>
                </div><!--{* panel *}-->
            <!--{/foreach}-->
            <!--{* ▲お届け先 *}-->

            <div class="back-button pc-tag">
                    <a href="./payment.php" class="btn btn-default btn-block">戻る</a>
            </div>

        </form>

<div id="button-area">
				<div class="order-confirm">
					<div class="">
            <a href="./payment.php" class="sp-tag btn-style02 btn-elm">戻る</a>
						<button class="command-button next" name="next" id="next" onclick="document.form1.submit()">ご注文を確定する</button>
					</div>
					<!--{if $cartKey != $smarty.const.PRODUCT_TYPE_DOWNLOAD}-->
					<div class="nortice">
						<div class="tr">
							<span class="title">商品(税込)</span>
							<span class="price"><!--{$arrForm.subtotal|number_format}--> 円</span>
						</div>

					</div>
					<div class="price-area">
						<span class="title">合計金額(税込)：</span>
						<span class="price"><!--{$arrForm.subtotal|number_format}--> 円</span>
					</div>
					<!--{else}-->
					<div class="nortice">
						<div class="tr">
							<span class="title">商品</span>
							<span class="price"><!--{$arrForm.subtotal|number_format}--> PT</span>
						</div>
						<div class="tr">
							<span class="title">ポイント利用</span>
							<span class="price"><!--{$arrForm.subtotal|number_format}--> PT</span>
						</div>
					</div>
					<div class="price-area">
						<span class="title">合計ポイント：</span>
						<span class="price"><!--{$arrForm.subtotal|number_format}--> ポイント</span>
					</div>
					<!--{/if}-->
				</div>
			</div>
    </div>
</div>
