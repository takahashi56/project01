<?php /* Smarty version 2.6.27, created on 2017-08-30 23:21:52
         compiled from /home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/OperateProductSTrial/templates/admin/products/plg_OperateProductSTrial_edit_products.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'script_escape', '/home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/OperateProductSTrial/templates/admin/products/plg_OperateProductSTrial_edit_products.tpl', 51, false),array('modifier', 'h', '/home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/OperateProductSTrial/templates/admin/products/plg_OperateProductSTrial_edit_products.tpl', 55, false),array('modifier', 'sfGetErrorColor', '/home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/OperateProductSTrial/templates/admin/products/plg_OperateProductSTrial_edit_products.tpl', 133, false),array('modifier', 'in_array', '/home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/OperateProductSTrial/templates/admin/products/plg_OperateProductSTrial_edit_products.tpl', 174, false),array('function', 'html_radios', '/home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/OperateProductSTrial/templates/admin/products/plg_OperateProductSTrial_edit_products.tpl', 76, false),)), $this); ?>
 
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TEMPLATE_ADMIN_REALDIR)."admin_popup_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<script type="text/javascript">
$(function(){
    $('#edit-products')
        .click(function(){
            if(confirm('選択した全ての商品に適用されます。よろしいですか？')){
                fnModeSubmit('edit_products','','');
                $(this).closest('form').trigger('submit');
            }
        });
        
    $('.form.disabled :input').attr('disabled', 'disabled');
})
function checkChangeStock(){
    $('#change-stock').attr('checked','checked');
}
</script>

<style>
#product-list .select{
    text-align:center;
}
#product-list .id{
    text-align:right;
}
</style>

<form name="form1" id="form1" method="post" action="?">
    <input type="hidden" name="<?php echo ((is_array($_tmp=@TRANSACTION_ID_NAME)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['transactionid'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
    <input type="hidden" name="mode" value="edit_products" />
    <?php $this->assign('key', 'product_ids'); ?>
    <?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']]['value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['product_id']):
?>
        <input type="hidden" name=<?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
[]" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['product_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
" />
    <?php endforeach; endif; unset($_from); ?>
    <table class="form">
        <colgroup>
            <col width="20%" />
            <col width="80%" />
        </colgroup>
        <tbody>
            <?php $this->assign('key', 'status'); ?>
            <tr>
                <th>
                    公開・非公開
                </th>
                <td>
                    <span class="attention">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

                    </span>
                    <label>
                        <input type="radio" value="" name="<?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" <?php if (((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']]['value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ""): ?>checked="checked"<?php endif; ?> />
                        変更なし
                    </label>
                    <?php echo smarty_function_html_radios(array('options' => ((is_array($_tmp=$this->_tpl_vars['arrDisplayStatuses'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'name' => ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'selected' => ((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']]['value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))), $this);?>

                </td>
            </tr>
        </tbody>
    </table>
    <p class="attention">
        製品版では下記の機能も使用できます。
    </p>
    <table class="form disabled">
        <colgroup>
            <col width="20%" />
            <col width="80%" />
        </colgroup>
        <tbody>
            <?php $this->assign('key', 'product_status'); ?>
            <?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrStatuses'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['status_key'] => $this->_tpl_vars['name']):
?>
            <tr>
                <th>
                    <img src="<?php echo ((is_array($_tmp=$this->_tpl_vars['TPL_URLPATH_DEFAULT'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['arrStatusImages'][$this->_tpl_vars['status_key']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" alt="<?php echo ((is_array($_tmp=$this->_tpl_vars['name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
">
                </th>
                <td>
                    <span class="attention">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

                    </span>
                    <label>
                        <input type="radio" value="" name="<?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
[<?php echo ((is_array($_tmp=$this->_tpl_vars['status_key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
]" <?php if (((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']]['value'][$this->_tpl_vars['status_key']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ""): ?>checked="checked"<?php endif; ?> />
                        変更なし
                    </label>
                    <label>
                        <input type="radio" value="1" name="<?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
[<?php echo ((is_array($_tmp=$this->_tpl_vars['status_key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
]" <?php if (((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']]['value'][$this->_tpl_vars['status_key']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == '1'): ?>checked="checked"<?php endif; ?> />
                        ON
                    </label>
                    <label>
                        <input type="radio" value="0" name="<?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
[<?php echo ((is_array($_tmp=$this->_tpl_vars['status_key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
]" <?php if (((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']]['value'][$this->_tpl_vars['status_key']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == '0'): ?>checked="checked"<?php endif; ?> />
                        OFF
                    </label>
                </td>
            </tr>
            <?php endforeach; endif; unset($_from); ?>
            <?php $this->assign('key1', 'change_stock'); ?>
            <?php $this->assign('key2', 'stock'); ?>
            <?php $this->assign('key3', 'stock_unlimited'); ?>
            <tr>
                <th>
                    在庫数
                </th>
                <td>
                    <span class="attention">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr'][$this->_tpl_vars['key1']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

                        <?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr'][$this->_tpl_vars['key2']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

                        <?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr'][$this->_tpl_vars['key3']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

                    </span>
                    <label>
                        <input type="radio" value="" name="<?php echo ((is_array($_tmp=$this->_tpl_vars['key1'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" <?php if (((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key1']]['value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ""): ?>checked="checked"<?php endif; ?> />
                        変更なし
                    </label>
                    <input id="change-stock" type="radio" value="1" name="<?php echo ((is_array($_tmp=$this->_tpl_vars['key1'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" <?php if (((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key1']]['value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) != ""): ?>checked="checked"<?php endif; ?> />
                    <input id="stock-number" type="text" name="<?php echo ((is_array($_tmp=$this->_tpl_vars['key2'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key2']]['value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" size="6" class="box6" maxlength="<?php echo ((is_array($_tmp=@AMOUNT_LEN)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" onfocus="checkChangeStock();" style="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrErr'][$this->_tpl_vars['key2']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('sfGetErrorColor', true, $_tmp) : SC_Utils_Ex::sfGetErrorColor($_tmp)); ?>
" />
                    <label>
                        <input type="checkbox" name="<?php echo ((is_array($_tmp=$this->_tpl_vars['key3'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="1" onchange="if(this.checked) checkChangeStock(); eccube.checkStockLimit('<?php echo ((is_array($_tmp=@DISABLED_RGB)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
');" <?php if (((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key3']]['value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == '1'): ?>checked="checked"<?php endif; ?>/>
                        無制限
                    </label>
                </td>
            </tr>
        </tbody>
    </table>
                        
    <h2>
        選択中の商品
    </h2>
    <p class="attention">
        <?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['edit_product_ids'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

    </p>
    <table id="product-list" class="list">
        <colgroup>
            <col width="10%" />
            <col width="10%" />
            <col width="90%" />
        </colgroup>
        <thead>
            <tr>
                <th>
                    選択
                </th>
                <th>
                    ID
                </th>
                <th>
                    商品名
                </th>
            </tr>
        </thead>
        <tbody>
            <?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrProducts'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrProduct']):
?>
                <?php $this->assign('product_id', ((is_array($_tmp=$this->_tpl_vars['arrProduct']['product_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))); ?>
                <tr>
                    <?php $this->assign('key', 'edit_product_ids'); ?>
                    <td class="select">
                        <input type="checkbox" name="<?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
[]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['product_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" <?php if (in_array(((is_array($_tmp=$this->_tpl_vars['product_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)), ((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']]['value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))): ?>checked="checked"<?php endif; ?> />
                    </td>
                    <td class="id">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['arrProduct']['product_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

                    </td>
                    <td class="name">
                        <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrProduct']['name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>

                    </td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
        </tbody>
    </table>

    <div class="btn-area">
        <ul>
            <li><a id="edit-products" class="btn-action" href="javascript:;" ><span class="btn-next">この内容で登録する</span></a></li>
        </ul>
    </div>
</form>