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
<input type="hidden" name="sf" value="<!--{$arrSearchData.sf|h}-->" />
<input type="hidden" name="rf" value="<!--{$arrSearchData.rf|h}-->" />
<input type="hidden" name="fs" value="<!--{$arrSearchData.fs|h}-->" />
<input type="hidden" name="price_min" value="<!--{$arrSearchData.price_min|h}-->" />
<input type="hidden" name="price_max" value="<!--{$arrSearchData.price_max|h}-->" />
<!--{foreach from=$arrSearchData.product_status_id item=status_id}-->
<input type="hidden" name="product_status_id[]" value="<!--{$status_id|h}-->" />
<!--{/foreach}-->