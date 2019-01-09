<div class="detail_contents">
	<h1 class="heading-title"><!--{$arrProduct.name|h}--></h1>
	<div class="top-image centered">
		<div>
			<!--{assign var=key value="main_image"}-->
			<!--★画像★-->
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
		</div>
	</div>
	<div class="main_comment">
		<p class="sub sp-tag">詳細情報</p>
		<!--{$arrProduct.main_comment|nl2br_html}-->
	</div>

	<div class="sub-image-list clearfix">
		<!--{section name=cnt loop=$smarty.const.PRODUCTSUB_MAX}-->
			<!--{assign var=key value="sub_title`$smarty.section.cnt.index+1`"}-->
			<!--{assign var=ikey value="sub_image`$smarty.section.cnt.index+1`"}-->
			<!--{if $arrProduct[$key] != "" or $arrProduct[$ikey]|strlen >= 1}-->
				<!--{assign var=lkey value="sub_large_image`$smarty.section.cnt.index+1`"}-->
				<div class="sub-image centered" data-mh="sub-image-list">
					<div>
						<!--{if $arrProduct[$lkey]|strlen >= 1}-->
							<a
								href="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrProduct[$lkey]|h}-->" 
								class="cboxElement expansion" 
								target="_blank" >
						<!--{/if}-->
								<img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrProduct[$lkey]|h}-->" 
									alt="<!--{$arrProduct.name|h}-->" class="img-responsive" width="100%" />
						<!--{if $arrProduct[$lkey]|strlen >= 1}-->
							</a>
						<!--{/if}-->
						<!--▲サブ画像-->
					</div>
				</div>
			<!--{/if}-->
		<!--{/section}-->
	</div>

</div>

<div class="split-line pc-tag"></div>

<div class="product-info">
	<!--{if $actor_categorytree}-->
		<dl class="clearfix"><dt>出演：</dt><dd>
			<!--{foreach from=$actor_categorytree item=actor}-->
				<a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=<!--{$actor.category_id}-->"><!--{$actor.category_name|h}--></a>
			<!--{/foreach}-->
		</dd></dl>
	<!--{/if}-->

<!-- ここから
	<dl class="clearfix"><dt>モデルタイプ：</dt><dd>
		<!--{foreach from=$modeltype_categorytree item=model}-->
			<a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=<!--{$model.category_id}-->"><!--{$model.category_name|h}--></a>
		<!--{/foreach}-->
	</dd></dl>
	<dl class="clearfix"><dt>プレイスタイル：</dt><dd>
		<!--{foreach from=$playstyle_categorytree item=playstyle}-->
			<a href="<!--{$smarty.const.ROOT_URLPATH}-->products/list.php?category_id=<!--{$playstyle.category_id}-->"><!--{$playstyle.category_name|h}--></a>
		<!--{/foreach}-->
	</dd></dl>

ここまで -->


	<!--{if $arrProduct.papc4.value}-->
		<dl class="clearfix"><dt>収録時間：</dt><dd><!--{$arrProduct.papc4.value}--> 分</dd></dl>
	<!--{/if}-->
	<!--{if $arrProduct.papc6.value}-->
		<dl class="clearfix"><dt>配信形式：</dt><dd><!--{$arrProduct.papc6.value}--></dd></dl>
	<!--{/if}-->
	<!--{if $arrProduct.papc7.value}-->
		<dl class="clearfix"><dt>メディア形式：</dt><dd><!--{$arrProduct.papc7.value}--></dd></dl>
	<!--{/if}-->
	<!--{if $arrProduct.papc1.value}-->
		<dl class="clearfix"><dt>作品公開日：</dt><dd><!--{$arrProduct.papc1.value}--></dd></dl>
	<!--{/if}-->
	<!--{if $arrProduct.papc8.value}-->
		<dl class="clearfix"><dt>メーカー/レーベル：</dt><dd><!--{$arrProduct.papc8.value}--></dd></dl>
	<!--{/if}-->
		<dl class="clearfix"><dt>商品コード：</dt><dd>
		<!--{if $arrProduct.product_code_min == $arrProduct.product_code_max}-->
			<!--{$arrProduct.product_code_min|h}-->
		<!--{else}-->
			<!--{$arrProduct.product_code_min|h}-->～<!--{$arrProduct.product_code_max|h}-->
		<!--{/if}-->
	</dd></dl>
	<!--{if $arrProduct.comment3}-->
		<dl class="clearfix"><dt>キーワード：</dt><dd><!--{$arrProduct.comment3}--></dd></dl>
	<!--{/if}-->
	<dl class="clearfix"><dt>総合ランキング：</dt><dd><a href="/">ランキングを見る</a></dd></dl>
	<dl class="clearfix"><dt>特典サイト：</dt><dd><a href="/">特設特典ページへ行く</a></dd></dl>
	<dl class="clearfix"><dt>Twitter：</dt><dd><a href="javascript:void window.open('http://twitter.com/intent/tweet?text=<!--{$arrProduct.name|h}-->&url=http://stmingo-demo.mallento.com/products/detail.php?product_id=<!--{$arrProduct.product_id}-->','_blank','width=550,height=480,left=100,top=50,scrollbars=1,resizable=1',0);">Twitterでこの商品を紹介する</a></dd></dl>

</div>