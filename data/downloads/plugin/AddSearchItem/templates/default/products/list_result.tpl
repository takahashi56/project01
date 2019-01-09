<!--{*
 * AddSearchItem
 * Copyright (C) 2012 Bratech CO.,LTD. All Rights Reserved.
 * http://wwww.bratech.co.jp/
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
 *}-->

<li><strong>キーワード：</strong><!--{$arrSearch.name|h}--></li>
<li><strong>在庫：</strong><!--{if $arrSearch.sf==1}-->在庫あり商品のみ<!--{else}-->在庫なしも表示<!--{/if}--></li>
<li><strong>レビュー：</strong><!--{if $arrSearch.rf==1}-->レビューあり商品のみ<!--{else}-->レビューなし商品も表示<!--{/if}--></li>
<!--{if $fs_enable}--><li><strong>送料無料：</strong><!--{if $arrSearch.fs==1}-->送料無料商品のみ<!--{else}-->対象商品以外も表示<!--{/if}--></li><!--{/if}-->
<!--{if $arrSearch.price_min|strlen > 0 || $arrSearch.price_max|strlen > 0}--><li><strong>価格帯：</strong><!--{if $arrSearch.price_min|strlen > 0}--><!--{$arrSearch.price_min|number_format}-->円<!--{/if}-->&nbsp;～&nbsp;<!--{if $arrSearch.price_max|strlen > 0}--><!--{$arrSearch.price_max|number_format}-->円<!--{/if}--></li><!--{/if}-->
<!--{if $arrSearch.product_status}--><li><strong>商品ステータス：</strong><!--{$arrSearch.product_status}--></li><!--{/if}-->