<!--{if $arrRecommendify}-->

<link rel="stylesheet" type="text/css" href="<!--{$smarty.const.ROOT_URLPATH}-->plugin/Recommendify/jquery.dbpas.carousel.css" />

<h2 class="Recommendify">この商品を買った人はこんな商品も買っています</h2>
<!--{if count($arrRecommendify) > 4}-->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script type="text/javascript">
  var $jq2 = $.noConflict();
</script>
<script src="<!--{$smarty.const.ROOT_URLPATH}-->plugin/Recommendify/jquery.dbpas.carousel.js"></script>
<script>
  $jq2(document).ready(function(){
  $jq2('ul#Recommendify').dbpasCarousel(
  {autoSlide: 0, itemsVisible: 4, imgCaption: 0}
  );
  });
</script>

<ul id="Recommendify">
  <!--{foreach from=$arrRecommendify item=arrItem name="arrRecommendify"}-->
  <li style="width:150px;">
    <div>
      <a href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrItem.product_id|u}-->">
      <img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrItem.main_list_image|sfNoImageMainList|h}-->" alt="<!--{$arrItem.name|h}-->" />
      <h3><!--{$arrItem.name|h}--></h3>
      </a>
      <p><!--{$arrItem.price02_min_inctax|number_format}-->円</p>
    </div>
  </li>
  <!--{/foreach}-->
</ul>
<!--{else}-->

<div data-carousel-name="Recommendify" style="margin-left:0;">
  <div data-carousel-control="wrapper">
<ul id="Recommendify" data-carousel-control="wrapper">
  <!--{foreach from=$arrRecommendify item=arrItem name="arrRecommendify"}-->
  <li style="width:150px;">
    <div>
      <a href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$arrItem.product_id|u}-->">
      <img src="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$arrItem.main_list_image|sfNoImageMainList|h}-->" alt="<!--{$arrItem.name|h}-->" />
      <h3><!--{$arrItem.name|h}--></h3>
      </a>
      <p><!--{$arrItem.price02_min_inctax|number_format}-->円</p>
    </div>
  </li>
  <!--{/foreach}-->
</ul>
</div>
</div>

<!--{/if}-->


<!--{/if}-->
