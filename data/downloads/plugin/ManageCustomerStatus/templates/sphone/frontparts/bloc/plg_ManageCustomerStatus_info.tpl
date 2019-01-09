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
 <style type="text/css">
#member_rank_info {
    margin-bottom: 20px;
}
#member_rank_info li {
    display: block;
    clear: both;
    padding: 10px;
    line-height: 1.3;
    background-color: #FEFEFE;
    background: -moz-linear-gradient(center top, #FEFEFE 0%,#EEEEEE 100%);
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0, #FEFEFE),color-stop(1, #EEEEEE));
    border-top: #FFF solid 1px;
    border-bottom: #CCC solid 1px;
}
</style>

<section id="member_rank_info">
<h2 class="title_block">会員情報</h2>
<ul>
	<!--{if $arrCustomer.status_id > 0}-->
	<li>
        現在の会員ランクは「<span style="color:#0000FF; font-weight:bold;"><!--{$arrStatus[$arrCustomer.status_id]}--></span>」です。
    </li>
    <!--{/if}-->
        <!--{if $arrCustomer.fixed_rank != 1}-->
        <!--{if $rankup > 0}-->
        <li>次回の更新で「<span style="color:#FF0000; font-weight:bold;"><!--{$arrStatus[$arrNextRank.status_id]}--></span>」にランクアップします！</li>
        <!--{/if}-->
        <!--{if $rankup_total > 0}-->
        <li>あと、<!--{$rankup_total|number_format}-->円で次のランクにアップします。</li>
        <!--{/if}-->
        
        <!--{if $rankup_times > 0}-->
        <li>あと、<!--{$rankup_times}-->回ご購入頂きますと次のランクにアップします。</li>
        <!--{/if}-->
        <!--{if $rankup_points > 0}-->
        <li>あと、<!--{$rankup_points}-->ポイント獲得されますと次のランクにアップします。</li>
        <!--{/if}-->
        <!--{/if}-->
	</li>
</ul>
</section>
<!--{/if}-->