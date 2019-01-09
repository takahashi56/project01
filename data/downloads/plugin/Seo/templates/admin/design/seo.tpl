<!--{*
/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2013 LOCKON CO.,LTD. All Rights Reserved.
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

<script type="text/javascript">
<!--
function fnTargetSelf(){
    document.form_edit.target = "_self";
}
function copy_description() {
    $('input[name^=description\\[]').val(
        $('input[name=all_description]').val()
    );
}
function copy_keyword() {
    $('input[name^=keyword\\[]').val(
        $('input[name=all_keyword]').val()
    );
}
function copy_meta_robots() {
    $('select[name^=meta_robots_index\\[]').val(
        $('select[name=all_meta_robots_index]').val()
    );
    $('select[name^=meta_robots_follow\\[]').val(
        $('select[name=all_meta_robots_follow]').val()
    );
    $('input[name^=meta_robots\\[]').val(
        $('input[name=all_meta_robots]').val()
    );
}
//-->
</script>


<style>
h3 {
    margin-bottom: 0;
}
h3 .url {
    font-weight: normal;
}
h3 a:link,
h3 a:visited {
    color: #fff;
    font-weight: normal;
}
.edit_one {
    
}
.edit_one td,
.edit_one th {
    padding-top: 0;
    padding-bottom: 0;
}
.edit_one td {
    padding-left: 0;
}
.edit_one input {
    margin-top: 0;
    margin-bottom: 0;
}
.help {
    text-align: right;
}
.other_site {
    display: table;
    margin: 0 auto;
}
</style>

<!--{strip}-->
    <div class="help"><a href="" target="_blank">SEO管理 各種設定方法ヘルプ</a></div>
    <form name="form_edit" id="form_edit" method="post" action="?seo=1" >
    <input type="hidden" name="<!--{$smarty.const.TRANSACTION_ID_NAME}-->" value="<!--{$transactionid}-->" />
    <input type="hidden" name="mode" value="" />
    <input type="hidden" name="device_type_id" value="<!--{$device_type_id|h}-->" />

        <!--{if $arrErr.err != ""}-->
            <div class="message">
                <span class="attention"><!--{$arrErr.err}--></span>
            </div>
        <!--{/if}-->

        <h2><a name="list">画面一覧</a></h2>
        <table class="list">
            <col width="55%" />
            <col width="15%" />
            <col width="15%" />
            <col width="15%" />
            <tr>
                <th>名称</th>
                <th>キーワード数</th>
                <th>インデックス</th>
                <th>移動</th>
            </tr>
            <!--{foreach item=item from=$arrPageList}-->
                <tr>
                    <td>
                        <a href="#page_id_<!--{$item.page_id|h}-->"><!--{$item.page_name}--></a>
                    </td>
                    <td class="right">
                        <!--{$item.keyword_count|number_format|h}-->
                    </td>
                    <td class="center">
                        <!--{$arrMetaRobotsIndexView[$item.meta_robots_index]|mb_substr:0:1}-->
                    </td>
                    <td class="center">
                        <a href="#page_id_<!--{$item.page_id|h}-->">↓移動</a>
                    </td>
                </tr>
            <!--{/foreach}-->
        </table>

        <h2>一括編集</h2>
        <p style="margin: 1ex 0;">右の「反映」をクリックすると、下の「個別編集」の全画面に適用されます。<span class="attention">その段階では、まだ登録されません。</span>画面一番下の[登録する]ボタンをクリックしてください。</p>
        <table class="edit_one">
            <col width="20%" />
            <col width="70%" />
            <col width="10%" />
            <tr>
                <!--{assign var=key value="description"}-->
                <th><!--{$arrForm[$key].disp_name|h}--></th>
                <td>
                    <input type="text" name="all_<!--{$key|h}-->" value="" maxlength="<!--{$arrForm[$key].length|h}-->" size="60" class="box60" /><span class="attention"> (上限<!--{$arrForm[$key].length|h}-->文字)</span>
                </td>
                <td class="center">
                    <a href="javascript:;" onclick="copy_description();">↓反映</a>
                </td>
            </tr>
            <tr>
                <!--{assign var=key value="keyword"}-->
                <th><!--{$arrForm[$key].disp_name|h}--></th>
                <td>
                    <input type="text" name="all_<!--{$key}-->" value="" maxlength="<!--{$arrForm[$key].length|h}-->" size="60" class="box60" /><span class="attention"> (上限<!--{$arrForm[$key].length|h}-->文字)</span>
                </td>
                <td class="center">
                    <a href="javascript:;" onclick="copy_keyword();">↓反映</a>
                </td>
            </tr>
            <tr>
                <!--{assign var=key value="meta_robots"}-->
                <!--{assign var=key2 value="meta_robots_index"}-->
                <!--{assign var=key3 value="meta_robots_follow"}-->
                <th><!--{$arrForm[$key].disp_name|h}--></th>
                <td>
                    index
                    <select name="all_<!--{$key2|h}-->">
                        <!--{html_options options=$arrMetaRobotsIndexView selected=""}-->
                    </select>
                    &nbsp;
                    follow
                    <select name="all_<!--{$key3|h}-->">
                        <!--{html_options options=$arrMetaRobotsFollowView selected=""}-->
                    </select>
                    &nbsp;
                    他
                    <input type="text" name="all_<!--{$key}-->" value="" maxlength="<!--{$arrForm[$key].length|h}-->" style="ime-mode: disabled;" size="30" class="box30" /><span class="attention"> (上限<!--{$arrForm[$key].length|h}-->文字)</span>
                </td>
                <td class="center">
                    <a href="javascript:;" onclick="copy_meta_robots();">↓反映</a>
                </td>
            </tr>
        </table>

        <h2 style="margin-top: 1em;">個別編集</h2>
        <!--{foreach key=index item=item from=$arrPageList}-->
            <input type="hidden" name="page_id[<!--{$index|h}-->]" value="<!--{$arrForm.page_id.value[$index]|h}-->" />
            <h3>
                <a name="page_id_<!--{$item.page_id|h}-->">
                    <!--{$item.page_id}-->. <!--{$item.page_name}-->
                    &nbsp;
                    <span class="url">
                        <!--{$smarty.const.HTTP_URL|h}--><!--{$item.filename|h}-->.php
                    </span>
                </a>
                <div style="float: right; width: 15%; text-align: center;">
                    <a href="#list">↑移動</a>
                </div>
            </h3>
            <table class="edit_one">
                <col width="20%" />
                <col width="80%" />
                <!--{if $arrForm.edit_flg.value[$index] != 2}-->
                    <tr>
                        <!--{assign var=key value="page_name"}-->
                        <th><!--{$arrForm[$key].disp_name|h}--></th>
                        <td>
                            <input type="text" name="<!--{$key}-->[<!--{$index|h}-->]" value="<!--{$arrForm[$key].value[$index]|h}-->" maxlength="<!--{$arrForm[$key].length|h}-->" style="<!--{$arrErr[$key][$index]|sfGetErrorColor}-->" size="60" class="box60" /><span class="attention"> (上限<!--{$arrForm[$key].length|h}-->文字)</span>
                            <!--{if $arrErr[$key][$index] != ""}-->
                                <div class="message">
                                    <span class="attention"><!--{$arrErr[$key][$index]}--></span>
                                </div>
                            <!--{/if}-->
                        </td>
                    </tr>
                <!--{/if}-->
                <tr>
                    <!--{assign var=key value="description"}-->
                    <th><!--{$arrForm[$key].disp_name|h}--></th>
                    <td>
                        <input type="text" name="<!--{$key}-->[<!--{$index|h}-->]" value="<!--{$arrForm[$key].value[$index]|h}-->" maxlength="<!--{$arrForm[$key].length|h}-->" style="<!--{$arrErr[$key][$index]|sfGetErrorColor}-->" size="60" class="box60" /><span class="attention"> (上限<!--{$arrForm[$key].length|h}-->文字)</span>
                        <!--{if $arrErr[$key][$index] != ""}-->
                            <div class="attention"><!--{$arrErr[$key][$index]}--></div>
                        <!--{/if}-->
                    </td>
                </tr>
                <tr>
                    <!--{assign var=key value="keyword"}-->
                    <th><!--{$arrForm[$key].disp_name|h}--></th>
                    <td>
                        <input type="text" name="<!--{$key}-->[<!--{$index|h}-->]" value="<!--{$arrForm[$key].value[$index]|h}-->" maxlength="<!--{$arrForm[$key].length|h}-->" style="<!--{$arrErr[$key][$index]|sfGetErrorColor}-->" size="60" class="box60" /><span class="attention"> (上限<!--{$arrForm[$key].length|h}-->文字)</span>
                        <!--{if $arrErr[$key][$index] != ""}-->
                            <div class="attention"><!--{$arrErr[$key][$index]}--></div>
                        <!--{/if}-->
                    </td>
                </tr>
                <tr>
                    <!--{assign var=key value="meta_robots"}-->
                    <!--{assign var=key1 value="meta_robots_index"}-->
                    <!--{assign var=key2 value="meta_robots_follow"}-->
                    <!--{assign var=key3 value="meta_robots_other"}-->
                    <th><!--{$arrForm[$key].disp_name|h}--></th>
                    <td style="<!--{$arrErr[$key][$index]|sfGetErrorColor}-->">
                        index
                        <select name="<!--{$key1|h}-->[<!--{$index|h}-->]">
                            <!--{html_options options=$arrMetaRobotsIndexView selected=$arrForm[$key1].value[$index]}-->
                        </select>
                        &nbsp;
                        follow
                        <select name="<!--{$key2|h}-->[<!--{$index|h}-->]">
                            <!--{html_options options=$arrMetaRobotsFollowView selected=$arrForm[$key2].value[$index]}-->
                        </select>
                        &nbsp;
                        他
                        <input type="text" name="<!--{$key3}-->[<!--{$index|h}-->]" value="<!--{$arrForm[$key3].value[$index]|h}-->" maxlength="<!--{$arrForm[$key3].length|h}-->" style="ime-mode: disabled; <!--{$arrErr[$key3][$index]|sfGetErrorColor}-->" size="30" class="box30" /><span class="attention"> (上限<!--{$arrForm[$key].length|h}-->文字)</span>
                        <!--{if $arrErr[$key][$index] != ""}-->
                            <div class="attention"><!--{$arrErr[$key][$index]}--></div>
                        <!--{/if}-->
                        <!--{if $arrErr[$key1][$index] != ""}-->
                            <div class="attention"><!--{$arrErr[$key1][$index]}--></div>
                        <!--{/if}-->
                        <!--{if $arrErr[$key2][$index] != ""}-->
                            <div class="attention"><!--{$arrErr[$key2][$index]}--></div>
                        <!--{/if}-->
                        <!--{if $arrErr[$key3][$index] != ""}-->
                            <div class="attention"><!--{$arrErr[$key3][$index]}--></div>
                        <!--{/if}-->
                    </td>
                </tr>
            </table>
        <!--{/foreach}-->

        <div class="other_site">
            <!--{assign var=key value="apply_other_site"}-->
            <!--{html_checkboxes name=$key options=$arrApplyOtherSite selected=$arrForm[$key].value separator="<br />"}-->
            <!--{if $arrErr[$key] != ""}-->
                <div class="attention"><!--{$arrErr[$key]}--></div>
            <!--{/if}-->
        </div>

        <div class="btn-area">
            <ul>
                <li><a class="btn-action" href="javascript:;" name='subm' onclick="fnTargetSelf(); fnFormModeSubmit('form_edit','confirm','',''); return false;"><span class="btn-next">登録する</span></a></li>
            </ul>
        </div>
    </form>
<!--{/strip}-->
