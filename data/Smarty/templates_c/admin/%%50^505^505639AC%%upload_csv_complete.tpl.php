<?php /* Smarty version 2.6.27, created on 2018-02-23 14:03:43
         compiled from products/upload_csv_complete.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'script_escape', 'products/upload_csv_complete.tpl', 29, false),array('modifier', 'h', 'products/upload_csv_complete.tpl', 45, false),)), $this); ?>

<div id="products" class="contents-main">
    <div class="message">
        <span>CSV登録を実行しました。</span>
    </div>
    <?php if (((is_array($_tmp=$this->_tpl_vars['arrRowErr'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
        <table class="form">
            <tr>
                <td>
                    <?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrRowErr'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['err']):
?>
                        <span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['err'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span><br/>
                    <?php endforeach; endif; unset($_from); ?>
                </td>
            </tr>
        </table>
    <?php endif; ?>
    <?php if (((is_array($_tmp=$this->_tpl_vars['arrRowResult'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
        <table class="form">
            <tr>
                <td>
                    <?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrRowResult'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['result']):
?>
                    <span><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['result'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
<br/></span>
                    <?php endforeach; endif; unset($_from); ?>
                </td>
            </tr>
        </table>
    <?php endif; ?>
    <div class="btn-area">
        <ul>
            <li><a class="btn-action" href="?"><span class="btn-prev">戻る</span></a></li>
        </ul>
    </div>
</div>