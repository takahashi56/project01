<?php /* Smarty version 2.6.27, created on 2018-09-21 10:37:39
         compiled from /home/joycurrent/joycurrent.xsrv.jp/public_html//data/Smarty/templates/DL002/frontparts/bloc/lnav-item.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'script_escape', '/home/joycurrent/joycurrent.xsrv.jp/public_html//data/Smarty/templates/DL002/frontparts/bloc/lnav-item.tpl', 4, false),array('modifier', 'u', '/home/joycurrent/joycurrent.xsrv.jp/public_html//data/Smarty/templates/DL002/frontparts/bloc/lnav-item.tpl', 35, false),array('modifier', 'h', '/home/joycurrent/joycurrent.xsrv.jp/public_html//data/Smarty/templates/DL002/frontparts/bloc/lnav-item.tpl', 36, false),)), $this); ?>
<div class="nav lnav lnav-item">
	<ul>
		<li class="right-drop" id="menu1">
			<span class="navicon icon_geta chiled"></span><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=48">最新作</a>
			<ul class="sub-menu" style="display:none">
				<?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrSaisin'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrChild']):
?>
				<li><a class="outbox-parent" href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=<?php echo ((is_array($_tmp=$this->_tpl_vars['arrChild']['category_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrChild']['category_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</li>
		<li>
		  <span class="navicon icon_geta"></span><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=161">近々配信終了する作品</a>
		</li>
		<li class="right-drop">
			<span class="navicon icon_user"></span><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=101">メインジャンル一覧</a>
			<ul class="sub-menu" style="display:none">
				<?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrFetchType'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrChild']):
?>
				<li><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=<?php echo ((is_array($_tmp=$this->_tpl_vars['arrChild']['category_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrChild']['category_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</li>
		<li class="right-drop">
			<span class="navicon icon_video"></span><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
user_data/label.php">シリーズ一覧</a>
			<ul class="sub-menu" style="display:none">
				<?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrLabel'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrChild']):
?>
				<li><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/list.php?category_id=<?php echo ((is_array($_tmp=$this->_tpl_vars['arrChild']['category_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrChild']['category_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</a></li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
			</li>
		<li class="right-drop">
			<span class="navicon icon_graph"></span><a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
user_data/ranking.php">ランキング</a>
			<ul class="sub-menu" style="display:none">
				<?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrBestProducts'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['bestseller'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['bestseller']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['arrProduct']):
        $this->_foreach['bestseller']['iteration']++;
?>
				<li>
				<a href="<?php echo ((is_array($_tmp=@ROOT_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
products/detail.php?product_id=<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrProduct']['product_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('u', true, $_tmp) : smarty_modifier_u($_tmp)); ?>
">ランキング<?php echo ((is_array($_tmp=$this->_foreach['bestseller']['iteration'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
位</a>
				<div class="outbox" style="display:none"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrProduct']['name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
</div>
				</li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
			</li>
	</ul>
</div>
<div class="separator"></div>