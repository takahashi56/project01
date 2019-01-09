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
                    <div class="cartin_btn">
                        <div class="attention">
                        <!--{if $arrProduct.plg_managecustomerstatus_hidden_flg == 2}-->
                        この商品はランクによる購入制限がかかっております。<br>
                        ログイン後にもう1度ご確認下さい。
                        <!--{else}-->
                        この商品は現在のランクではご購入頂けません。
                        <!--{/if}-->
                        </div>
                    </div>                
<!--{else}-->
                    <div class="cartin_btn">
                        <dl>
                            <dt>数量</dt>
                            <dd>
                                <input type="number" name="quantity" class="quantitybox" value="<!--{$arrForm.quantity.value|default:1|h}-->" max="<!--{$smarty.const.INT_LEN}-->" style="<!--{$arrErr.quantity|sfGetErrorColor}-->" />
                                <!--{if $arrErr.quantity != ""}-->
                                    <br /><span class="attention"><!--{$arrErr.quantity}--></span>
                                <!--{/if}-->
                            </dd>
                        </dl>

                        <!--★カートに入れる★-->
                        <div id="cartbtn_default">
                            <a rel="external" href="javascript:void(document.form1.submit());" class="btn cartbtn_default">カートに入れる</a>
                        </div>
                        <div class="attention" id="cartbtn_dynamic"></div>
                    </div>
<!--{/if}-->