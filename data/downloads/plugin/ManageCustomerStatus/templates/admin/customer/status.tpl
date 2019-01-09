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

<form name="form1" id="form1" method="post" action="<!--{$smarty.server.REQUEST_URI|h}-->">
<input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
<input type="hidden" name="mode" value="edit">
<input type="hidden" name="status_id" value="<!--{$arrForm.status_id}-->">

<table border="0" cellspacing="1" cellpadding="8" summary=" ">
<tr>
<th>名称<span class="attention">※</span></th>
<td><span class="attention"><!--{$arrErr.name}--></span>
<input type="text" class="box30" name="name" value="<!--{$arrForm.name}-->" /></td>
</tr>
<tr>
<th>ランク<span class="attention">※</span></th>
<td><span class="attention"><!--{$arrErr.priority}--></span>
<input type="text" class="box6" name="priority" value="<!--{$arrForm.priority}-->" />&nbsp;数字で入力（高い値ほど高いランクになります）</td>
</tr>
<tr>
<th colspan="2" style="text-align:center;">会員特典</th>
</tr>
<tr>
<th>割引・値引き</th>
<td>
<span class="attention"><!--{$arrErr.discount_rate}--></span>
割引率：<input type="text" name="discount_rate" size="6" class="box6" value="<!--{$arrForm.discount_rate}-->" />%
<br>
商品登録の際に会員価格が設定されていない場合はここで設定された割引率を適用した価格が会員価格となります。<br><br>
<span class="attention"><!--{$arrErr.discount_value}--></span>
値引き：<input type="text" name="discount_value" size="6" class="box6" value="<!--{$arrForm.discount_value}-->" />円
<br>
合計額から設定した額の値引きを行います。
</td>
</tr>
<tr>
<th>増加ポイント</th>
<td><span class="attention"><!--{$arrErr.point_rate}--></span>
<span class="attention"><!--{$arrErr.point_value}--></span>
増加率：<input type="text" name="point_rate" size="6" class="box6" value="<!--{$arrForm.point_rate}-->" />%&nbsp;&nbsp;&nbsp; OR &nbsp;&nbsp;&nbsp;
増加ポイント：<input type="text" name="point_value" size="6" class="box6" value="<!--{$arrForm.point_value}-->" />pt<br>
</td>
</tr>
<tr>
<th>送料値引き</th>
<td><span class="attention"><!--{$arrErr.discount_fee}--></span>
<input type="text" name="discount_fee" size="6" class="box6" value="<!--{$arrForm.discount_fee}-->" />円&nbsp;
<input type="checkbox" name="free_fee" value="1" <!--{if $arrForm.free_fee == 1}-->checked<!--{/if}-->/>送料無料にする
</td>
</tr>
<tr>
<th colspan="2" style="text-align:center;">昇格条件</th>
</tr>
<tr>
<th>購入金額</th>
<td><span class="attention"><!--{$arrErr.total_amount}--></span>
<input type="text" name="total_amount" size="6" class="box6" value="<!--{$arrForm.total_amount}-->" />円以上
</td>
</tr>
<tr>
<th>購入回数</th>
<td><span class="attention"><!--{$arrErr.buy_times}--></span>
<input type="text" name="buy_times" size="6" class="box6" value="<!--{$arrForm.buy_times}-->" />回以上
</td>
</tr>
<tr>
<th>保有ポイント</th>
<td><span class="attention"><!--{$arrErr.total_point}--></span>
<input type="text" name="total_point" size="6" class="box6" value="<!--{$arrForm.total_point}-->" />pt以上
</td>
</tr>
<tr>
<th colspan="2" style="text-align:center;">加入時ランク設定</th>
</tr>
<tr>
<th>会員登録時の初期ランクとして設定</th>
<td><span class="attention"><!--{$arrErr.initial_rank}--></span>
<input type="checkbox" name="initial_rank" value="1" <!--{if $arrForm.initial_rank == 1}-->checked<!--{/if}-->/>初期ランクとして設定する
</td>
</tr>
<tr>
<th colspan="2" style="text-align:center;">固定ランク設定</th>
</tr>
<tr>
<th>自動更新処理の対象外ランクに設定</th>
<td><span class="attention"><!--{$arrErr.fixed_rank}--></span>
<input type="checkbox" name="fixed_rank" value="1" <!--{if $arrForm.fixed_rank == 1}-->checked<!--{/if}-->/>固定ランクとして設定する
</td>
</tr>
</table>


<div class="btn-area" style="text-align:center;">
    <ul>
        <li>
            <a class="btn-action" href="javascript:;" onclick="fnModeSubmit('edit','','');return false;"><span class="btn-next">この内容で登録する</span></a>
        </li>
    </ul>
</div>
<br>

<table border="0" cellspacing="1" cellpadding="8" summary=" ">
<col width="4%"/>
<col width="14%"/>
<col width="5%" />
<col width="12%" />
<col width="12%" />
<col width="12%" />
<col width="10%" />
<col width="10%" />
<col width="10%" />
<col width="6%" />    
<col width="6%" />
<tr>
<th rowspan="2" class="center">ID</th>
<th rowspan="2" class="center">名称</th>
<th rowspan="2" class="center">ランク</th>
<th colspan="3" class="center">特典</th>
<th colspan="3" class="center">昇格条件</th>
<th colspan="2"></th>
</tr>
<tr>
<th class="center">割引・値引</th>
<th class="center">ポイント</th>
<th class="center">送料</th>
<th class="center">購入金額</th>
<th class="center">購入回数</th>
<th class="center">保有ポイント</th>
<th class="center">編集</th>
<th class="center">削除</th>
</tr>
<!--{foreach from=$arrItems item=item name=item_loop}-->
<tr <!--{if $item.status_id == $arrForm.status_id}-->style="background-color:<!--{$smarty.const.SELECT_RGB}-->;"<!--{/if}-->>
<td class="center"><!--{$item.status_id|h}--></td>
<td><!--{$item.name|h}--><!--{if $item.initial_rank == 1}-->(初期)<!--{/if}--><!--{if $item.fixed_rank == 1}-->(固定)<!--{/if}--></td>
<td class="center"><!--{$item.priority}--></td>
<td class="right"><!--{if $item.discount_rate > 0}--><!--{$item.discount_rate}-->%割引<br><!--{/if}--><!--{if $item.discount_value > 0}--><!--{$item.discount_value}-->円値引<!--{/if}--></td>
<td class="right"><!--{if strlen($item.point_rate) > 0}--><!--{$item.point_rate}-->%増<!--{elseif strlen($item.point_value) > 0}--><!--{$item.point_value}-->pt増<!--{/if}--></td>
<td class="right"><!--{if $item.free_fee == 1}-->送料無料<!--{elseif $item.discount_fee > 0}--><!--{$item.discount_fee}-->円引<!--{/if}--></td>
<td class="right">
<!--{if $item.total_amount|strlen > 0}--><!--{$item.total_amount}-->&nbsp;円<!--{/if}-->
</td>
<td class="right">
<!--{if $item.buy_times|strlen > 0}--><!--{$item.buy_times}-->&nbsp;回<!--{/if}-->
</td>
<td class="right">
<!--{if $item.total_point|strlen > 0}--><!--{$item.total_point}-->&nbsp;pt<!--{/if}-->
</td>
<td class="center"><a href="javascript:;" onclick="fnModeSubmit('pre_edit','status_id','<!--{$item.status_id}-->');return false;">編集</a></td>
<td class="center"><a href="javascript:;" onclick="fnModeSubmit('delete','status_id','<!--{$item.status_id}-->');return false;">削除</a></td>
</tr>
<!--{/foreach}-->
</table>


</form>