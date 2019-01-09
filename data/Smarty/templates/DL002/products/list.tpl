<!--{*
 * EC-CUBE on Bootstrap3. This file is part of EC-CUBE
 *
 * Copyright(c) 2014 clicktx. All Rights Reserved.
 *
 * http://perl.no-tubo.net/
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
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA	02111-1307, USA.
 *}-->

<style>
.picture-block-wrap {
	height: 139px;
	display: block;
	background-color: #000;
	text-align: center;
}
.picture-block-wrap-point {
	background-color: transparent;
}
.picture-block-wrap > *{
	display: inline-block;
	vertical-align: middle;
}
.picture-block-wrap::before {
	content: "";
	height: 100%;
	vertical-align: middle;
	width: 0px;
	display: inline-block;
}
</style>

<script type="text/javascript">//<![CDATA[
		function fnSetClassCategories(form, classcat_id2_selected) {
				var $form = $(form);
				var product_id = $form.find('input[name=product_id]').val();
				var $sele1 = $form.find('select[name=classcategory_id1]');
				var $sele2 = $form.find('select[name=classcategory_id2]');
				eccube.setClassCategories($form, product_id, $sele1, $sele2, classcat_id2_selected);
		}
		// 並び順を変更
		function fnChangeOrderby(orderby) {
				eccube.setValue('orderby', orderby);
				eccube.setValue('pageno', 1);
				eccube.submitForm();
		}
		// 表示件数を変更
		function fnChangeDispNumber(dispNumber) {
				eccube.setValue('disp_number', dispNumber);
				eccube.setValue('pageno', 1);
				eccube.submitForm();
		}
		// カートに入れる
		function fnInCart(productForm) {
				var searchForm = $("#form1");
				var cartForm = $(productForm);
				// 検索条件を引き継ぐ
				var hiddenValues = ['mode','category_id','maker_id','name','orderby','disp_number','pageno','rnd'];
				$.each(hiddenValues, function(){
						// 商品別のフォームに検索条件の値があれば上書き
						if (cartForm.has('input[name='+this+']').length != 0) {
								cartForm.find('input[name='+this+']').val(searchForm.find('input[name='+this+']').val());
						}
						// なければ追加
						else {
								cartForm.append($('<input type="hidden" />').attr("name", this).val(searchForm.find('input[name='+this+']').val()));
						}
				});
				// 商品別のフォームを送信
				cartForm.submit();
		}
//]]></script>

<div id="undercolumn">

</div>

