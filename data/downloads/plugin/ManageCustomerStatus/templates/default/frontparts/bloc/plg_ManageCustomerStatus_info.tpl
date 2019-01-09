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


<!--{if $smarty.session.customer}-->
<style>
#customerStatusInfo h2 {
  padding: 0.5em;
  border: 1px solid #CCCCCC;
  background: #F7F7F7;
}
#customerStatusInfo .block_body {
  padding: 9px;
}
#customerStatusInfo .block_body div {
  margin: 1em 0 0;
  padding: 0.3em;
  border:1px solid #CCCCCC;
  background: #FFFAF0;
}
#customerStatusInfo ul {
  margin: 0.3em 0 0 0.8em;
}
#customerStatusInfo span {
  color:#FF0000;
}
</style>


<div class="block_outer">
  <div id="customerStatusInfo">
  <h2>会員ランク</h2>
    <div class="block_body">
      <!--{if $arrCustomer.status_id > 0}-->
      <p>現在の会員ランクは</p>
      <p style="text-align: center;">「<b style="color:#0000FF;"><!--{$arrStatus[$arrCustomer.status_id]}--></b>」</p>
      <p style="text-align: right;">です。</p>
      <!--{/if}-->
      <!--{if $arrCustomer.fixed_rank != 1}-->
      <!--{if $rankup > 0}-->
      <p>次回の更新で</p>
      <p style="text-align: center;">「<b style="color:#FF0000;"><!--{$arrStatus[$arrNextRank.status_id]}--></b>」</p>
      <p style="text-align: right;">にランクアップします!</p>
      <!--{/if}-->
      <!--{if $rankup_total > 0 || $rankup_times > 0 || $rankup_points > 0}-->
      <div>
        <p>次のランクアップまで…</p>
        <ul>
        <!--{if $rankup_total > 0}-->
        <li>あと <span><!--{$rankup_total|number_format}--></span>円!</li>
        <!--{/if}-->

        <!--{if $rankup_times > 0}-->
        <li>あと <span><!--{$rankup_times}--></span>回!</li>
        <!--{/if}-->
        <!--{if $rankup_points > 0}-->
        <li>あと <span><!--{$rankup_points}--></span>ポイント!</li>
        <!--{/if}-->
        </ul>
      </div>
      <!--{/if}-->
      <!--{/if}-->
    </div>
  </div>
</div>
<!--{/if}-->