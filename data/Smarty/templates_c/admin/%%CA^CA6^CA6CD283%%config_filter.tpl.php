<?php /* Smarty version 2.6.27, created on 2017-10-31 11:26:27
         compiled from /home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/MatrixFilterProducts/templates/config_filter.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'script_escape', '/home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/MatrixFilterProducts/templates/config_filter.tpl', 25, false),array('modifier', 'h', '/home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/MatrixFilterProducts/templates/config_filter.tpl', 26, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TEMPLATE_ADMIN_REALDIR)."admin_popup_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
$(document).ready(function(){
	$.arrSTATUS = [];
	<?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrSTATUS'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['status_id'] => $this->_tpl_vars['status']):
?>
	$.arrSTATUS.push([<?php echo ((is_array($_tmp=$this->_tpl_vars['status_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
,"<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['status'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
"]);
	<?php endforeach; endif; unset($_from); ?>
	$.arrCATTREE = [];
	<?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrCATTREE'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['category_id'] => $this->_tpl_vars['category_path']):
?>
	$.arrCATTREE.push([<?php echo ((is_array($_tmp=$this->_tpl_vars['category_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
,"<?php echo ((is_array($_tmp=$this->_tpl_vars['category_path'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
"]);
	<?php endforeach; endif; unset($_from); ?>
	$.arrURLPARAM = {};
	<?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrURLPARAM'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['id'] => $this->_tpl_vars['urlparam']):
?>
	$.arrURLPARAM.<?php echo ((is_array($_tmp=$this->_tpl_vars['id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
 = '<?php echo ((is_array($_tmp=$this->_tpl_vars['urlparam'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
';
	<?php endforeach; endif; unset($_from); ?>
	$.arrDbFields = [];
	<?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrDbFields'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['fld']):
?>
	$.arrDbFields.push('<?php echo ((is_array($_tmp=$this->_tpl_vars['fld'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
');
	<?php endforeach; endif; unset($_from); ?>
});
</script>
<script type="text/javascript" src="<?php echo ((is_array($_tmp=@PLUGIN_HTML_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
MatrixFilterProducts/media/plg_MatrixFilterProducts_config.js"></script>
<style type="text/css">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@PLUGIN_HTML_REALDIR)."/MatrixFilterProducts/media/plg_MatrixFilterProducts_config.css", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</style>

<h1><span class="title">「<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrBloc']['bloc_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
」<?php echo ((is_array($_tmp=$this->_tpl_vars['tpl_subtitle'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span></h1>
<form name="form1" id="form1" method="post" action="<?php echo ((is_array($_tmp=((is_array($_tmp=$_SERVER['REQUEST_URI'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
">
<input type="hidden" name="<?php echo ((is_array($_tmp=@TRANSACTION_ID_NAME)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['transactionid'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
<input type="hidden" id="mode" name="mode" value="edit">
<p style="padding:10px 0px">「<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrBloc']['bloc_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
」へ表示させる商品絞り込み用のフィルターを作成できます。<br />フィルターの組み合わせで商品をAND検索します。</p>

<?php if (! ((is_array($_tmp=$this->_tpl_vars['edited'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) && count ( ((is_array($_tmp=$this->_tpl_vars['arrFilters'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) )): ?>
<h2>フィルターリスト</h2>
<table border="0" cellspacing="1" cellpadding="8" summary=" " style="margin-bottom:5px">
	<tr>
		<th style="width:20%" class="center"><b>ターゲット</b></th>
		<th style="width:20%" class="center"><b>条件</b></th>
		<th style="width:45%" class="center"><b>値</b></th>
        <th style="width:5%" class="center"><b>OR</b></th>
		<th style="width:10%" class="center">&nbsp;</th>
	</tr>
<?php $this->assign('or_connect_str', ""); ?>
<?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrFilters'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['arrFilters'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['arrFilters']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['arrFilter']):
        $this->_foreach['arrFilters']['iteration']++;
?>

		<?php if (((is_array($_tmp=$this->_tpl_vars['arrFilter']['mfp_filter_or_connect'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
    	<?php if (! ((is_array($_tmp=$this->_tpl_vars['or_connect_str'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
        	<?php if (((is_array($_tmp=($this->_foreach['arrFilters']['iteration'] == $this->_foreach['arrFilters']['total']))) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
            	<?php $this->assign('or_connect_str', ""); ?>
            <?php else: ?>
    			<?php $this->assign('or_connect_str', "┓"); ?>
            <?php endif; ?>
        <?php else: ?>
        	<?php if (((is_array($_tmp=($this->_foreach['arrFilters']['iteration'] == $this->_foreach['arrFilters']['total']))) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
            	<?php if (((is_array($_tmp=$this->_tpl_vars['or_connect_str'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) != "┛"): ?>
            		<?php $this->assign('or_connect_str', "┛"); ?>
                <?php else: ?>
                	<?php $this->assign('or_connect_str', ""); ?>
                <?php endif; ?>
            <?php else: ?>
				<?php if (((is_array($_tmp=$this->_tpl_vars['or_connect_str'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == "┛"): ?>
					<?php $this->assign('or_connect_str', "┓"); ?>
				<?php else: ?>
        			<?php $this->assign('or_connect_str', "┃"); ?>
				<?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
        <?php else: ?>
    	<?php if (((is_array($_tmp=$this->_tpl_vars['or_connect_str'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
        	<?php if (((is_array($_tmp=($this->_foreach['arrFilters']['iteration'] == $this->_foreach['arrFilters']['total']))) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
            	<?php if (((is_array($_tmp=$this->_tpl_vars['or_connect_str'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) != "┛"): ?>
            		<?php $this->assign('or_connect_str', "┛"); ?>
                <?php else: ?>
                	<?php $this->assign('or_connect_str', ""); ?>
                <?php endif; ?>
            <?php else: ?>
    			<?php $this->assign('or_connect_str', "┛"); ?>
            <?php endif; ?>
        <?php else: ?>
        	<?php $this->assign('or_connect_str', ""); ?>
        <?php endif; ?>
    <?php endif; ?>
    
	<tr>
		<td style="border-right-width:0px"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrTargetName'][$this->_tpl_vars['arrFilter']['mfp_filter_target']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</td>
		<td class="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrConditionName'][$this->_tpl_vars['arrFilter']['mfp_filter_condition']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</td>
		<td style="font-family:monospace">
			<b>
						<?php if (((is_array($_tmp=$this->_tpl_vars['arrFilter']['mfp_filter_valuetype'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ((is_array($_tmp=@PLG_MFP_FILTER_VALUETYPE_DEFAULT)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
								<?php if (((is_array($_tmp=$this->_tpl_vars['arrFilter']['mfp_filter_target'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ((is_array($_tmp=@PLG_MFP_FILTER_TARGET_CATEGORY_ID)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
					<?php echo ((is_array($_tmp=$this->_tpl_vars['arrCATTREE'][$this->_tpl_vars['arrFilter']['mfp_filter_value']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

				<?php elseif (((is_array($_tmp=$this->_tpl_vars['arrFilter']['mfp_filter_target'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ((is_array($_tmp=@PLG_MFP_FILTER_TARGET_STATUS_ID)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
					<?php echo ((is_array($_tmp=$this->_tpl_vars['arrSTATUS'][$this->_tpl_vars['arrFilter']['mfp_filter_value']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

				<?php endif; ?>
			<?php else: ?>
				<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrFilter']['mfp_filter_value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>

			<?php endif; ?>
			</b>
			(<?php echo ((is_array($_tmp=$this->_tpl_vars['arrFilterValuetypeName'][$this->_tpl_vars['arrFilter']['mfp_filter_valuetype']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
)
		</td>
        <td class="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['or_connect_str'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</td>
		<td style="" class="center"><a href="javascript:;" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrFilter']['mfp_filter_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" class="list-filter-edit-action">[編集]</a> <a href="javascript:;" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrFilter']['mfp_filter_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" class="list-filter-delete-action">[削除]</a></td>
	</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>


<h2>フィルターを<?php if (((is_array($_tmp=$this->_tpl_vars['edited'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>編集<?php else: ?>追加<?php endif; ?></h2>

<?php if (count ( ((is_array($_tmp=$this->_tpl_vars['arrErr'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) )): ?>
<p class="attention" style="margin-bottom:1em"><b><?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrErr'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['err']):
?><?php echo ((is_array($_tmp=$this->_tpl_vars['err'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
<?php endforeach; endif; unset($_from); ?></b></p>
<?php endif; ?>

<p><span class="attention">*</span>は必須入力項目です。</p>
<input type="hidden" id="mfp_filter_id" name="mfp_filter_id" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_filter_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
<input type="hidden" id="mfp_id" name="mfp_id" value="<?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
<?php elseif (((is_array($_tmp=$_GET['mfp_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><?php echo ((is_array($_tmp=$_GET['mfp_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
<?php endif; ?>" />
<table border="0" cellspacing="1" cellpadding="8" summary=" " id="mfp_filter_list_table">
	<tr>
		<th style="width:15%">ターゲット <span class="attention">*</span></th>
		<td>
			<?php $this->assign('options', ((is_array($_tmp=$this->_tpl_vars['arrTargetName'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))); ?>
			<select id="mfp_filter_target" name="mfp_filter_target">
			<?php $_from = ((is_array($_tmp=$this->_tpl_vars['options'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['options'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['options']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['option']):
        $this->_foreach['options']['iteration']++;
?>
				<option value="<?php echo ((is_array($_tmp=$this->_foreach['options']['iteration'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
"<?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_filter_target'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ((is_array($_tmp=$this->_foreach['options']['iteration'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?> selected="selected"<?php endif; ?>><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['option'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
</option>
			<?php endforeach; endif; unset($_from); ?>
			</select>
		</td>
	</tr>
	<tr>
		<th>条件 <span class="attention">*</span></th>
		<td>
		<?php $this->assign('options', ((is_array($_tmp=$this->_tpl_vars['arrConditionName'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))); ?>
		<select id="mfp_filter_condition" name="mfp_filter_condition">
		<?php $_from = ((is_array($_tmp=$this->_tpl_vars['options'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['options'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['options']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['option']):
        $this->_foreach['options']['iteration']++;
?>
			<option value="<?php echo ((is_array($_tmp=$this->_foreach['options']['iteration'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
"<?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_filter_condition'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ((is_array($_tmp=$this->_foreach['options']['iteration'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?> selected="selected"<?php endif; ?>><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['option'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
		</td>
	</tr>
	<tr>
		<th>値 <span class="attention">*</span></th>
		<td>
		<?php $this->assign('options', ((is_array($_tmp=$this->_tpl_vars['arrFilterValuetypeName'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))); ?>
		<select id="mfp_filter_valuetype" name="mfp_filter_valuetype">
		<?php $_from = ((is_array($_tmp=$this->_tpl_vars['options'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['options'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['options']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['option']):
        $this->_foreach['options']['iteration']++;
?>
			<option value="<?php echo ((is_array($_tmp=$this->_foreach['options']['iteration'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
"<?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_filter_valuetype'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ((is_array($_tmp=$this->_foreach['options']['iteration'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?> selected="selected"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['option'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select> 
		<input type="hidden" id="mfp_filter_value" name="mfp_filter_value" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_filter_value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
		<input style="display:none;font-family:monospace" type="text" id="mfp_filter_value_text" name="mfp_filter_value_text" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_filter_value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" disabled="disabled"/>
		<select style="display:none" id="mfp_filter_value_select" name="mfp_filter_value_select" disabled="disabled"></select> 
		<label id="mfp_filter_except_self_label"><input style="vertical-align:middle" type="checkbox" id="mfp_filter_except_self" name="mfp_filter_except_self" value="1" <?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_filter_except_self'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>checked="checked"<?php endif; ?>/>ページの商品は除外</label>
		</td>
	</tr>
    <tr>
		<th>ORグループ</th>
		<td>
		<label id="mfp_filter_or_connect_label"><input style="vertical-align:middle" type="checkbox" id="mfp_filter_or_connect" name="mfp_filter_or_connect" value="1" <?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_filter_or_connect'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>checked="checked"<?php endif; ?>/>次のフィルターとOR条件でグループ化</label><br>
        <small>※最後のフィルターでは無視されます</small>
		</td>
	</tr>
</table>

<div class="btn-area">
    <ul>
		<?php if (((is_array($_tmp=$this->_tpl_vars['edited'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
		<li><a class="btn-action" href="javascript:;" id="to-filter-default"><span class="btn-prev">フィルター一覧画面に戻る</span></a></li>
		<?php else: ?>
		<li><a class="btn-action" href="javascript:;" id="to-default"><span class="btn-prev">前の画面に戻る</span></a></li>
		<?php endif; ?>
        <li><a class="btn-action" href="javascript:;" id="submit"><span class="btn-next">この内容で設定する</span></a></li>
    </ul>
</div>

</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TEMPLATE_ADMIN_REALDIR)."admin_popup_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>