<!--{*
 * ManageCustomerStatus
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

<!--{if strlen($arrFavorite[cnt].plg_managecustomerstatus_price_min) > 0}-->
<br>
<span class="price" style="color:#0000FF;">
<!--{if $smarty.const.MEMBER_RANK_PRICE_TITLE_MODE == 1}--><!--{$arrCustomerRank[$customer_rank_id]}--><!--{/if}--><!--{$smarty.const.MEMBER_RANK_PRICE_TITLE}-->：
<!--{if $arrFavorite[cnt].plg_managecustomerstatus_price_min_inctax == $arrFavorite[cnt].plg_managecustomerstatus_price_max_inctax}-->
<!--{$arrFavorite[cnt].plg_managecustomerstatus_price_min_inctax|n2s}-->
<!--{else}-->
<!--{$arrFavorite[cnt].plg_managecustomerstatus_price_min_inctax|n2s}-->～<!--{$arrFavorite[cnt].plg_managecustomerstatus_price_max_inctax|n2s}-->
<!--{/if}-->
円</span>
<!--{/if}-->