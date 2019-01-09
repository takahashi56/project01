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

<!--{else}-->
                        <div class="cart_area">
                            <dl>
                                <!--▼規格1-->
                                <dt><!--{$tpl_class_name1|h}--></dt>
                                <dd>
                                    <select name="classcategory_id1"
                                        style="<!--{$arrErr.classcategory_id1|sfGetErrorColor}-->"
                                        class="data-role-none">
                                        <!--{html_options options=$arrClassCat1 selected=$arrForm.classcategory_id1.value}-->
                                    </select>
                                    <!--{if $arrErr.classcategory_id1 != ""}-->
                                        <br /><span class="attention">※ <!--{$tpl_class_name1}-->を入力して下さい。</span>
                                    <!--{/if}-->
                                </dd>
                                <!--▲規格1-->

                                <!--{if $tpl_classcat_find2}-->
                                    <!--▼規格2-->
                                    <dt><!--{$tpl_class_name2|h}--></dt>
                                    <dd>
                                        <select name="classcategory_id2"
                                            style="<!--{$arrErr.classcategory_id2|sfGetErrorColor}-->"
                                            class="data-role-none">
                                        </select>
                                        <!--{if $arrErr.classcategory_id2 != ""}-->
                                            <br /><span class="attention">※ <!--{$tpl_class_name2}-->を入力して下さい。</span>
                                        <!--{/if}-->
                                    </dd>
                                    <!--▲規格2-->
                                <!--{/if}-->
                            </dl>
                        </div>
<!--{/if}-->