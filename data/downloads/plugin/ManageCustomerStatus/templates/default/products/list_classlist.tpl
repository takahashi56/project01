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
                            <div class="classlist">
                                <dl class="size01 clearfix">
                                        <!--▼規格1-->
                                        <dt><!--{$tpl_class_name1[$id]|h}-->：</dt>
                                        <dd>
                                            <select name="classcategory_id1" style="<!--{$arrErr.classcategory_id1|sfGetErrorColor}-->">
                                                <!--{html_options options=$arrClassCat1[$id] selected=$arrProduct.classcategory_id1}-->
                                            </select>
                                            <!--{if $arrErr.classcategory_id1 != ""}-->
                                                <p class="attention">※ <!--{$tpl_class_name1[$id]}-->を入力して下さい。</p>
                                            <!--{/if}-->
                                        </dd>
                                        <!--▲規格1-->
                                </dl>
                                <!--{if $tpl_classcat_find2[$id]}-->
                                    <dl class="size02 clearfix">
                                        <!--▼規格2-->
                                        <dt><!--{$tpl_class_name2[$id]|h}-->：</dt>
                                        <dd>
                                            <select name="classcategory_id2" style="<!--{$arrErr.classcategory_id2|sfGetErrorColor}-->">
                                            </select>
                                            <!--{if $arrErr.classcategory_id2 != ""}-->
                                                <p class="attention">※ <!--{$tpl_class_name2[$id]}-->を入力して下さい。</p>
                                            <!--{/if}-->
                                        </dd>
                                        <!--▲規格2-->
                                    </dl>
                                <!--{/if}-->
                            </div>
<!--{/if}-->