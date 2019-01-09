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

<table border="0" cellspacing="1" cellpadding="8" summary=" ">
	<tr>
		<th rowspan="2" class="center">会員名</th>
		<th rowspan="2" class="center">会員費名</th>
		<th colspan="3" class="center">会員費</th>
		<th rowspan="2" class="center">支払更新</th>
	</tr>
	<tr>
		<th class="center">申請日</th>
		<th class="center">支払日</th>
		<th class="center">満期日</th>
	</tr>
	<!--{foreach from=$orders item=item name=item_loop}-->
	<tr>
		<td class="center"><!--{$item.order_name01}-->&nbsp;<!--{$item.order_name02}--></td>
		<td class="center"><!--{$item.name}--></td>
		<td class="center"><!--{$item.create_date}--></td>
		<td class="center">
			<!--{if $item.expire < 0}-->
			<span style='color: red;'><!--{$item.update_date}--></span>
			<!--{else}-->
			<!--{$item.update_date}-->
			<!--{/if}-->
		</td>
		<td class="center">
			<!--{if $item.expire < 0}-->
			<span style='color: red;'>支払必要</span>
			<!--{else}-->
			<!--{$item.expire}-->
			<!--{/if}-->
		</td>
		<td class="center">
			<form method="post" action="?">
				<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
				<input type="hidden" name="mode" value="update"/>
				<input type="hidden" name="order" value="<!--{$item.order_id}-->"/>
				<button type="submit">支払更新</button>
			</form>
		</td>
	</tr>
	<!--{/foreach}-->
</table>

