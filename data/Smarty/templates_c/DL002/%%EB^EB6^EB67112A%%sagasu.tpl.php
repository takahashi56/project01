<?php /* Smarty version 2.6.27, created on 2018-09-21 10:37:39
         compiled from /home/joycurrent/joycurrent.xsrv.jp/public_html//data/Smarty/templates/DL002/frontparts/bloc/sagasu.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'script_escape', '/home/joycurrent/joycurrent.xsrv.jp/public_html//data/Smarty/templates/DL002/frontparts/bloc/sagasu.tpl', 3, false),)), $this); ?>
<div id="sagasu" class="top-listview">
	<ul>
		<li><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
user_data/search.php" id="bycategory">カテゴリーから探す</a></li>
		<li><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
user_data/model.php" id="bymodel">配信者一覧から探す</a></li>
		<li><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
user_data/ranking.php" id="byranking">ランキングから探す</a></li>
		<li><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
user_data/label.php" id="bylabel">シリーズから探す</a></li>
	</ul>
</div>