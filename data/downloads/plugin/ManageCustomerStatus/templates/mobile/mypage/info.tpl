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

            <!--{if $smarty.const.USE_POINT !== false && $CustomerPoint > 0 && $expired_date}-->&nbsp;
        		<br>
                ポイントの有効期限は<font color="#FF0000"><!--{$expired_date|date_format:"%Y/%m/%d"}--></font>です。
            <!--{/if}-->
            	<!--{if $new_status_id}-->
                会員ランクが「<font color="#ff0000"><!--{$arrStatus[$new_status_id]}--></font>」にランクアップしました！
                <!--{elseif $arrCustomer.status_id > 0}-->
            	現在の会員ランクは「<font color="#0000ff"><!--{$arrStatus[$arrCustomer.status_id]}--></font>」です。<br>
                <!--{if $arrCustomer.fixed_rank != 1}-->
                <!--{if $rankup > 0}-->
                <br>次回の更新で「<font color="#ff0000"><!--{$arrStatus[$arrNextRank.status_id]}--></font>」にランクアップします！
                <br>
                <!--{/if}-->
                <!--{/if}-->
                <!--{/if}-->
                <!--{if $arrCustomer.fixed_rank != 1}-->
                <!--{if $rankup_total > 0}-->
                <br>あと、<!--{$rankup_total|number_format}-->円で次のランクにアップします。
                <!--{/if}-->
                
                <!--{if $rankup_times > 0}-->
                <br>あと、<!--{$rankup_times}-->回ご購入頂きますと次のランクにアップします。
                <!--{/if}-->
                <!--{if $rankup_points > 0}-->
                <br>あと、<!--{$rankup_points}-->ポイント獲得されますと次のランクにアップします。
                <!--{/if}-->
                <!--{/if}-->


