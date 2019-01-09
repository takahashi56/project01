<!--{*
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2014 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
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
 */
*}-->
<link href="http://vjs.zencdn.net/5.16.0/video-js.css" rel="stylesheet">
<script src="http://vjs.zencdn.net/ie8/1.1.2/videojs-ie8.min.js"></script>
  
<div id="mypagecolumn">
    <h2 class="title"><!--{$tpl_title|h}--></h2>
    <!--{include file=$tpl_navi}-->
    <div id="mycontents_area">
        <h3><!--{$tpl_subtitle|h}--></h3>
            <!--{if $objNavi->all_row > 0}-->

<div class="well">
  ストリーミングは現在、FIrefoxとGoogle ChromeのPC版にのみ対応しております。<br>
  ダウンロードは「購入履歴一覧」の「購入履歴詳細」からご利用いただけます。
</div>

                <p><span class="attention"><!--{$objNavi->all_row}-->件</span>の購入履歴があります。</p>
                <div class="pagenumber_area">
                    <!--▼ページナビ-->
                    <!--{$objNavi->strnavi}-->
                    <!--▲ページナビ-->
                </div>
        <form name="form1" id="form1" method="post" action="?">
            <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
            <input type="hidden" name="order_id" value="" />
            <input type="hidden" name="pageno" value="<!--{$objNavi->nowpage}-->" />
        </form>
        <table summary="購入商品詳細" class="videolist">
            <col width="50%" />
            <col width="50%" />
            <!--{foreach from=$tpl_arrOrderDetail item=orderDetail}-->
                <tr>
                    <td><!--{$orderDetail.product_code|h}--><br />
                    <a<!--{if $orderDetail.enable}--> href="<!--{$smarty.const.P_DETAIL_URLPATH}--><!--{$orderDetail.product_id|u}-->"<!--{/if}-->><!--{$orderDetail.product_name|h}--></a><br />
                        <!--{if $orderDetail.classcategory_name1 != ""}-->
                            <!--{$orderDetail.classcategory_name1|h}--><br />
                        <!--{/if}-->
                        <!--{if $orderDetail.classcategory_name2 != ""}-->
                            <!--{$orderDetail.classcategory_name2|h}-->
                        <!--{/if}-->
                    </td>
                    <td class="alignC">
                    <!--{if $orderDetail.product_type_id == $smarty.const.PRODUCT_TYPE_DOWNLOAD}-->
                        <!--{if $orderDetail.is_downloadable}-->
                    <video  class="video-js vjs-big-play-centered" controls preload="none" width="320" height="200" poster="<!--{$smarty.const.IMAGE_SAVE_URLPATH}--><!--{$orderDetail.main_list_image|sfNoImageMainList|h}-->"  data-setup="{}">
                        <source src="<!--{$orderDetail.down_videourl}-->" type="video/mp4" />
                    </video>
                        <!--{else}-->
                            <!--{if $orderDetail.payment_date == "" && $orderDetail.effective == "0"}-->
                                <!--{$arrProductType[$orderDetail.product_type_id]}--><BR />（入金確認中）
                            <!--{else}-->
                                <!--{$arrProductType[$orderDetail.product_type_id]}--><BR />（期限切れ）
                            <!--{/if}-->
                        <!--{/if}-->
                    <!--{else}-->
                        <!--{$arrProductType[$orderDetail.product_type_id]}-->
                    <!--{/if}-->
                    </td>
                </tr>
            <!--{/foreach}-->
        </table>
            <!--{else}-->
                <p>購入履歴はありません。</p>
            <!--{/if}-->
  <script src="http://vjs.zencdn.net/5.16.0/video.js"></script>


    </div>
</div>