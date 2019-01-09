<!--{*
 * OperateProductSTrial
 * Copyright(c) 2015 DAISY Inc. All Rights Reserved.
 *
 * http://www.daisy.link/
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
 
<script type="text/javascript">
$(function(){
    
    var form = $('#form1');
    var originalOptions = {
        target: form.attr('target'),
        action: form.attr('action')
    };
    
    $('#edit-products')
        .click(function(){
            if(productsAreSelected()){
                var options = {
                    target: 'edit-products',
                    action: '<!--{$smarty.const.PLUGIN_HTML_URLPATH}-->OperateProductSTrial/admin/products/plg_OperateProductSTrial_edit_products.php'
                };
                fnOpenWindow('', options.target, '600', '650');
                form.attr(options);
                fnModeSubmit('pre_edit', '', '');
                form.attr(originalOptions);
            }
        });
        
    $('#edit-windows')
        .click(function(){
            if(productsAreSelected()){
                if(allowsToOpenWindows()){
                    form
                        .attr('action', './product.php')
                        .find('.product-id:checked')
                            .each(function(){
                                var product_id = $(this).attr('value');
                                var target = 'edit-window'+product_id;
                                fnOpenWindow('', target, '', '');
                                form.attr('target', target);
                                fnModeSubmit('pre_edit', 'product_id', $(this).attr('value'));
                            });
                }
                form.attr(originalOptions);
            }
        });
        
    function productsAreSelected(){
        var length = form.find('.product-id:checked').length;
        if(length == 0){
            alert('商品が選択されていません。');
            return false;
        }
        return true;
    }
    
    function allowsToOpenWindows(){
        var length = form.find('.product-id:checked').length;
        if(length > 1)
            return confirm(length+'個のウィンドウを開こうとしています。\n環境によっては処理に時間がかかりますがよろしいですか？');
        else
            return true;
    }
})
</script>

<a id="edit-products" class="btn-tool" href="javascript:void(0);">
    ☆ 一発編集
</a>
<a id="edit-windows" class="btn-tool" href="javascript:void(0);">
    ☆ 編集
</a>
<span class="attention">
    以降は製品版機能です。
</span>
<a id="confirm-windows" class="btn-tool" href="javascript:void(0);">
    ☆ 確認
</a>
<a id="class-windows" class="btn-tool" href="javascript:void(0);">
    ☆ 規格
</a>