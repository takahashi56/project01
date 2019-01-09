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
 
<!--{if $arrProduct.plg_managecustomerstatus_hidden_flg > 0}-->
                <div class="cartin">
                    <div class="cartin_btn">
						<span class="attention">
                        <!--{if $arrProduct.plg_managecustomerstatus_hidden_flg == 2}-->
                        この商品はランクによる購入制限がかかっております。<br>
                        ログイン後にもう1度ご確認下さい。
                        <!--{else}-->
                        この商品は現在のランクではご購入頂けません。
                        <!--{/if}-->
                        </span>
                    </div>
                </div>
<!--{else}-->
                <div class="cartin">
                    <div class="cartin_btn">
                        <div id="cartbtn_default">
                            <!--★カゴに入れる★-->
                            <a href="javascript:void(document.form1.submit())" onmouseover="chgImg('<!--{$TPL_URLPATH}-->img/button/btn_cartin_on.jpg','cart');" onmouseout="chgImg('<!--{$TPL_URLPATH}-->img/button/btn_cartin.jpg','cart');">
                                <img src="<!--{$TPL_URLPATH}-->img/button/btn_cartin.jpg" alt="カゴに入れる" name="cart" id="cart" /></a>
                        </div>
                    </div>
                </div>
<!--{/if}-->