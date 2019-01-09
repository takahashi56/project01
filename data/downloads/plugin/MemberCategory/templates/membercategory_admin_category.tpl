<!--{*
 * MemberCategory
 * Copyright (C) 2012 UAssist CO.,LTD. All Rights Reserved.
 * http://www.uassist.co.jp/
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

<div class="now_dir">
        <!--{if $arrErr.category_name}-->
        <span class="attention"><!--{$arrErr.category_name}--></span>
        <!--{/if}-->
        <input type="text" name="category_name" value="<!--{$arrForm.category_name|h}-->" size="30" class="box30" maxlength="<!--{$smarty.const.STEXT_LEN}-->" />
        <input type="checkbox" name="plg_membercategory_member_flg" value="1" <!--{if $arrForm.plg_membercategory_member_flg == 1}-->checked="checked"<!--{/if}--> />会員限定
        <a class="btn-normal" href="javascript:;" onclick="fnModeSubmit('edit','',''); return false;"><span class="btn-next">登録</span></a><span class="attention">&nbsp;（上限<!--{$smarty.const.STEXT_LEN}-->文字）</span>
</div>
