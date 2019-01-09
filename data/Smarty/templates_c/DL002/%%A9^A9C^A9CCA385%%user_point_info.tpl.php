<?php /* Smarty version 2.6.27, created on 2018-09-21 10:37:39
         compiled from /home/joycurrent/joycurrent.xsrv.jp/public_html//data/Smarty/templates/DL002/frontparts/bloc/user_point_info.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'script_escape', '/home/joycurrent/joycurrent.xsrv.jp/public_html//data/Smarty/templates/DL002/frontparts/bloc/user_point_info.tpl', 3, false),array('modifier', 'h', '/home/joycurrent/joycurrent.xsrv.jp/public_html//data/Smarty/templates/DL002/frontparts/bloc/user_point_info.tpl', 5, false),array('modifier', 'number_format', '/home/joycurrent/joycurrent.xsrv.jp/public_html//data/Smarty/templates/DL002/frontparts/bloc/user_point_info.tpl', 5, false),array('modifier', 'default', '/home/joycurrent/joycurrent.xsrv.jp/public_html//data/Smarty/templates/DL002/frontparts/bloc/user_point_info.tpl', 5, false),)), $this); ?>
<div class="clearfix"></div>
<div class="point-info">
<?php if (((is_array($_tmp=$this->_tpl_vars['tpl_login'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) !== false): ?>
	<?php if (((is_array($_tmp=@USE_POINT)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) !== false): ?>&nbsp;
	<span class="user_name"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['CustomerName1'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
 <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['CustomerName2'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
 様</span>&nbsp;は現在&nbsp;<span class="point st"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['CustomerPoint'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)))) ? $this->_run_mod_handler('default', true, $_tmp, '0') : smarty_modifier_default($_tmp, '0')))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
</span>&nbsp;ポイント保有されています。（ポイントは <a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=2">こちら</a> からご購入いただけます。）
	<?php endif; ?>
<?php else: ?>
	<?php if (((is_array($_tmp=@USE_POINT)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) !== false): ?>&nbsp;
	<span class="user_name">ゲスト 様</span>&nbsp;は現在&nbsp;<span class="point st">0</span>&nbsp;ポイント保有されています。（ポイントは <a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=2">こちら</a> からご購入いただけます。）
	<?php endif; ?>
<?php endif; ?>
</div>