<?php /* Smarty version 2.6.27, created on 2018-09-21 10:37:39
         compiled from /home/joycurrent/joycurrent.xsrv.jp/public_html//data/Smarty/templates/DL002/frontparts/bloc/lnav-cart.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'script_escape', '/home/joycurrent/joycurrent.xsrv.jp/public_html//data/Smarty/templates/DL002/frontparts/bloc/lnav-cart.tpl', 3, false),)), $this); ?>
<div class="nav lnav lnav-cart">
	<ul>
		<li><span class="navicon icon_cart"></span><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=2">ポイント購入</a></li>
		<li><span class="navicon icon_cart"></span><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=102">プレミアム会員</a></li>
	</ul>
</div>
<div class="separator"></div>