<script type="text/javascript">//<![CDATA[
    // 規格2に選択肢を割り当てる。
    function fnSetClassCategories(form, classcat_id2_selected) {
        var $form = $(form);
        var product_id = $form.find('input[name=product_id]').val();
        var $sele1 = $form.find('select[name=classcategory_id1]');
        var $sele2 = $form.find('select[name=classcategory_id2]');
        eccube.setClassCategories($form, product_id, $sele1, $sele2, classcat_id2_selected);
    }
//]]></script>

<div class="order-block ">
	<div class="contents">
		<div class="pc-tag">
			<div class="indicator-row">
				<!--{foreach from=$productStatusIcon[$tpl_product_id] item=foo}-->
				<img src="<!--{$TPL_URLPATH}--><!--{$foo}-->">
				<!--{/foreach}-->
			</div>
		</div>

		<div class="video-column">
			<div class="centered video-area"><div>
			<a
				<!--{if $arrProduct.main_large_image|strlen >= 1}-->
					href="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrProduct.main_large_image|h}-->"
				<!--{else}-->
					href="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrProduct.main_image|h}-->"
				<!--{/if}-->
				class="cboxElement expansion"
				target="_blank"
			>
				<img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrProduct.main_image|h}-->">
			</a>
			</div></div>
		</div>

		<form name="form1" id="form1" method="post" action="?">
		<div class="detail-column">
			<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
			<input type="hidden" name="mode" value="cart" />
			<input type="hidden" name="product_id" value="<!--{$tpl_product_id}-->" />
			<input type="hidden" name="product_class_id" value="<!--{$tpl_product_class_id}-->" id="product_class_id" />
			<input type="hidden" name="favorite_product_id" value="" />
			<input type="hidden" name="quantity" value="1" />

			<div class="pc-tag">
				<img src="<!--{$TPL_URLPATH}-->img/icon/icon_cart_w.png">ご購入はこちらから
			</div>

			<h1 class="detail-title sp-tag"><!--{$arrProduct.name|h}--></h1>

			<div class="rank-price">
				<!--{if $rank_price[8]}--><dl <!--{if $smarty.session.customer.plg_managecustomerstatus_status == 8}-->class="myrank"<!--{/if}-->><dt>VIP会員</dt><dd><!--{$rank_price[8]}-->ポイント</dd> ←BEST PRICE!!</dl><!--{/if}-->
				<!--{if $rank_price[6]}--><dl <!--{if $smarty.session.customer.plg_managecustomerstatus_status == 6}-->class="myrank"<!--{/if}-->><dt>PL会員</dt><dd><!--{$rank_price[6]}-->ポイント</dd></dl><!--{/if}-->
				<!--{if $rank_price[7]}--><dl <!--{if $smarty.session.customer.plg_managecustomerstatus_status == 7}-->class="myrank"<!--{/if}-->><dt>BR会員</dt><dd><!--{$rank_price[7]}-->ポイント</dd></dl><!--{/if}-->
			</div>

			<div class="sp-price-area clearfix">
				<div class="sp-tag">
					<div class="indicator-row">
						<!--{foreach from=$productStatusIcon[$tpl_product_id] item=foo}-->
						<img src="<!--{$TPL_URLPATH}--><!--{$foo}-->">
						<!--{/foreach}-->
					</div>
				</div>

				<div id="price">
				<!--{$CustomerName1|h}--> <!--{$CustomerName2|h}--> 様は現在<!--{$customer_rank[$smarty.session.customer.plg_managecustomerstatus_status]}-->なので<br/ >
				<img src="<!--{$TPL_URLPATH}-->img/icon/icon_price.png" />
					<!--{$arrProduct.plg_managecustomerstatus_price_max_inctax|number_format}-->
					<!--{if $tpl_product_type == 1}-->
						円 （税込）
					<!--{else}-->
						ポイント
					<!--{/if}-->
					で購入できます。
				</div>
			</div>

			<div id="buy-button">
				<p class="sp-tag">ダウンロード&ストリーミング再生購入</p>
				<a href="javascript:void(document.form1.submit())" class="btn-style01 btn-cart btn-elm">カートに入れる</a>
			</div>

			<div class="clearfix btn-area">
				<div id="bookmark-button">
					<!--{if $smarty.const.OPTION_FAVORITE_PRODUCT == 1 && $tpl_login === true}-->
						<!--{assign var=add_favorite value="add_favorite`$product_id`"}-->
						<!--{if $arrErr[$add_favorite]}-->
							<div class="attention"><!--{$arrErr[$add_favorite]}--></div>
						<!--{/if}-->
						<!--{if !$is_favorite}-->
							<a href="javascript:eccube.changeAction('?product_id=<!--{$arrProduct.product_id|h}-->'); eccube.setModeAndSubmit('add_favorite','favorite_product_id','<!--{$arrProduct.product_id|h}-->');" class="btn-style03 btn-favorite btn-elm">お気に入りに追加する</a>
						<!--{else}-->
							<span class="btn-style03 btn-favorite btn-disable">お気に入り追加済み</span>
						<!--{/if}-->
					<!--{else}-->
						<!--{if false}--><img src="<!--{$TPL_URLPATH}-->img/button/btn_add_bookmark.png" style="opacity:0.5"><!--{/if}-->
					<!--{/if}-->
				</div>
				<div id="point-button">
					<a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=2" class="btn-style03 btn-point btn-elm">ポイントを購入する</a>
				</div>
			</div>

			<div class="nortice">
				Pマークの付くプレミアム商品はプレミアム会員のみご購入可能です。<br />
				動画商品は○日間ダウンロード・ストリーミング再生が可能です。<br />
				ダウンロード方法は <a href="#">コチラ</a> からご確認お願いします。<br />
			</div>
		</div>

		<div class="point-info">
		<!--{if $tpl_login !== false}-->
			<!--{if $smarty.const.USE_POINT !== false}-->&nbsp;
			<span class="user_name"><!--{$CustomerName1|h}--><!--{$CustomerName2|h}--> 様</span>&nbsp;は現在&nbsp;<span class="point st"><!--{$CustomerPoint|number_format|default:"0"|h}--></span>&nbsp;ポイント保有されています。（ポイントは <a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=2">こちら</a> からご購入いただけます。）
			<!--{/if}-->
		<!--{/if}-->
		</div>

		</form>

	</div>
</div>

<script>
	$(document).ready(function(){
		if($(window).width() > 767) {
			var divw = $('.order-block').width();
			var ofsx = (3000 - divw) / 2;
			$('.order-block').css("width", "3000px");
			$('.order-block').css("margin-top", "-10px");
			$('.order-block').css("margin-left", -1 * ofsx + "px");
			$('.breadcrumb-lite').css("width", "3000px");
			$('.breadcrumb-lite').css("margin-top", "-10px");
			$('.breadcrumb-lite').css("margin-left", -1 * ofsx + "px");
		}
	});
</script>