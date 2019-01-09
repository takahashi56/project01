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
<script type="text/javascript">//<![CDATA[
/**
 * 規格の選択状態に応じて, フィールドを設定する.
 */
function checkStock($form, product_id, classcat_id1, classcat_id2) {

    classcat_id2 = classcat_id2 ? classcat_id2 : '';

    var classcat2;

    // 商品一覧時
    if (typeof productsClassCategories != 'undefined') {
        classcat2 = productsClassCategories[product_id][classcat_id1]['#' + classcat_id2];
    }
    // 詳細表示時
    else {
        classcat2 = classCategories[classcat_id1]['#' + classcat_id2];
    }

    // 商品コード
    var $product_code_default = $form.find('[id^=product_code_default]');
    var $product_code_dynamic = $form.find('[id^=product_code_dynamic]');
    if (classcat2
        && typeof classcat2['product_code'] != 'undefined') {
        $product_code_default.hide();
        $product_code_dynamic.show();
        $product_code_dynamic.text(classcat2['product_code']);
    } else {
        $product_code_default.show();
        $product_code_dynamic.hide();
    }

    // 在庫(品切れ)
    var $cartbtn_default = $form.find('[id^=cartbtn_default]');
    var $cartbtn_dynamic = $form.find('[id^=cartbtn_dynamic]');
    if (classcat2 && classcat2['stock_find'] === false) {

        $cartbtn_dynamic.text('申し訳ございませんが、只今品切れ中です。').show();
        $cartbtn_default.hide();
    } else {
        $cartbtn_dynamic.hide();
        $cartbtn_default.show();
    }

    // 通常価格
    var $price01_default = $form.find('[id^=price01_default]');
    var $price01_dynamic = $form.find('[id^=price01_dynamic]');
    if (classcat2
        && typeof classcat2['price01'] != 'undefined'
        && String(classcat2['price01']).length >= 1) {

        $price01_dynamic.text(classcat2['price01']).show();
        $price01_default.hide();
    } else {
        $price01_dynamic.hide();
        $price01_default.show();
    }

    // 販売価格
    var $price02_default = $form.find('[id^=price02_default]');
    var $price02_dynamic = $form.find('[id^=price02_dynamic]');
    if (classcat2
        && typeof classcat2['price02'] != 'undefined'
        && String(classcat2['price02']).length >= 1) {

        $price02_dynamic.text(classcat2['price02']).show();
        $price02_default.hide();
    } else {
        $price02_dynamic.hide();
        $price02_default.show();
    }
	
    // 会員価格
    var $price03_default = $form.find('[id^=price03_default]');
    var $price03_dynamic = $form.find('[id^=price03_dynamic]');
    if (classcat2
        && typeof classcat2['plg_managecustomerstatus_price'] != 'undefined'
        && String(classcat2['plg_managecustomerstatus_price']).length >= 1) {

        $price03_dynamic.text(classcat2['plg_managecustomerstatus_price']).show();
        $price03_default.hide();
    } else {
        $price03_dynamic.hide();
        $price03_default.show();
    }

    // ポイント
    var $point_default = $form.find('[id^=point_default]');
    var $point_dynamic = $form.find('[id^=point_dynamic]');
    if (classcat2
        && typeof classcat2['point'] != 'undefined'
        && String(classcat2['point']).length >= 1) {

        $point_dynamic.text(classcat2['point']).show();
        $point_default.hide();
    } else {
        $point_dynamic.hide();
        $point_default.show();
    }

    // 商品規格
    var $product_class_id_dynamic = $form.find('[id^=product_class_id]');
    if (classcat2
        && typeof classcat2['product_class_id'] != 'undefined'
        && String(classcat2['product_class_id']).length >= 1) {

        $product_class_id_dynamic.val(classcat2['product_class_id']);
    } else {
        $product_class_id_dynamic.val('');
    }
}
//]]></script>