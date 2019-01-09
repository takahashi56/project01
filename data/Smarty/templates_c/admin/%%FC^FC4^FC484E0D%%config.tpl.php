<?php /* Smarty version 2.6.27, created on 2017-10-31 11:25:12
         compiled from /home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/MatrixFilterProducts/templates/config.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'script_escape', '/home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/MatrixFilterProducts/templates/config.tpl', 22, false),array('modifier', 'h', '/home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/MatrixFilterProducts/templates/config.tpl', 28, false),array('modifier', 'count', '/home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/MatrixFilterProducts/templates/config.tpl', 53, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TEMPLATE_ADMIN_REALDIR)."admin_popup_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="<?php echo ((is_array($_tmp=@PLUGIN_HTML_URLPATH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
MatrixFilterProducts/media/plg_MatrixFilterProducts_config.js"></script>
<style type="text/css">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@PLUGIN_HTML_REALDIR)."/MatrixFilterProducts/media/plg_MatrixFilterProducts_config.css", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</style>

<h1><span class="title"><?php echo ((is_array($_tmp=$this->_tpl_vars['tpl_subtitle'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</h1>
<form name="form1" id="form1" method="post" action="<?php echo ((is_array($_tmp=((is_array($_tmp=$_SERVER['REQUEST_URI'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
">
<input type="hidden" name="<?php echo ((is_array($_tmp=@TRANSACTION_ID_NAME)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['transactionid'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
<input type="hidden" id="mode" name="mode" value="edit">
<p style="padding:10px 0px">複数の検索条件を組み合わせた商品リストブロックを作成できます。</p>

<?php if (! ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) && count ( ((is_array($_tmp=$this->_tpl_vars['arrBlocs'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) )): ?>
<h2>ブロックリスト</h2>
<table border="0" cellspacing="1" cellpadding="8" summary=" " style="margin-bottom:5px">
	<tr>
		<th style="width:5%" class="center"><b>ID</b></th>
		<th style="" class="center"><b>ブロック名</b></th>
		<th style="width:17%" class="center"><b>デバイス</b></th>
		<th style="" class="center"><b>操作</b></th>
		<th style="width:20%" class="center" colspan="2"><b>フィルター</b></th>
	</tr>
<?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrBlocs'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['arrBlocs'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['arrBlocs']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['arrBloc']):
        $this->_foreach['arrBlocs']['iteration']++;
?>
	<?php $this->assign('mfp_id', ((is_array($_tmp=$this->_tpl_vars['arrBloc']['mfp_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))); ?>
	<tr>
		<td class="center"><b><?php echo ((is_array($_tmp=$this->_tpl_vars['mfp_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</b></td>
		<td><b><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrBloc']['mfp_bloc_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
</b></td>
		<td class="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrDEVICETYPE'][$this->_tpl_vars['arrBloc']['device_type_id']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</td>
		<td style="width:20%" class="center"><a href="javascript:;" onclick="window.opener.location.href='/admin/design/bloc.php?bloc_id=<?php echo ((is_array($_tmp=$this->_tpl_vars['arrBloc']['bloc_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
&device_type_id=<?php echo ((is_array($_tmp=$this->_tpl_vars['arrBloc']['device_type_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
';">[ブロックに移動]</a><br /><a href="javascript:;" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrBloc']['mfp_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" class="list-edit-action">[編集]</a> <a href="javascript:;" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrBloc']['mfp_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" class="list-delete-action">[削除]</a></td>
		<td>
			<?php $this->assign('arrFilters', ((is_array($_tmp=$this->_tpl_vars['arrAllFilters'][$this->_tpl_vars['arrBloc']['mfp_id']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))); ?>
			<?php if (((is_array($_tmp=$this->_tpl_vars['arrFilters'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
			<p class="center"><?php echo count(((is_array($_tmp=$this->_tpl_vars['arrFilters'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))); ?>
</p>
			<?php else: ?>
			<p class="center">未設定</p>
			<?php endif; ?>
		</td>
		<td style="width:10%" class="center"><a href="javascript:;" title="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrBloc']['mfp_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" class="list-filter-action">[編集]</a></td>
	</tr>
<?php endforeach; endif; unset($_from); ?>
</table>
<?php endif; ?>


<h2>ブロックを<?php if (((is_array($_tmp=$this->_tpl_vars['edited'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>編集<?php else: ?>作成<?php endif; ?></h2>

<?php if (count ( ((is_array($_tmp=$this->_tpl_vars['arrErr'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) )): ?>
<p class="attention" style="margin-bottom:1em"><b><?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrErr'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['err']):
?><?php echo ((is_array($_tmp=$this->_tpl_vars['err'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
<?php endforeach; endif; unset($_from); ?></b></p>
<?php endif; ?>

<p><span class="attention">*</span>は必須入力項目です。</p>
<input type="hidden" id="mfp_id" name="mfp_id" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
<input type="hidden" id="mfp_bloc_id" name="mfp_bloc_id" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_bloc_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
<input type="hidden" id="mfp_device_type_id" name="mfp_device_type_id" value="<?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_device_type_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_device_type_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
<?php else: ?><?php echo ((is_array($_tmp=@DEVICE_TYPE_PC)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
<?php endif; ?>" />
<table border="0" cellspacing="1" cellpadding="8" summary=" " style="margin-bottom:5px">
	<tr>
		<th style="width:25%">ブロック名 <span class="attention">*</span></th>
		<td><input type="text" id="mfp_bloc_name" name="mfp_bloc_name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_bloc_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" /></td>
	</tr>
	<tr>
		<th style="width:25%">ID名 <span class="attention">*</span></th>
		<td>
		<input type="text" id="mfp_bloc_elementid" name="mfp_bloc_elementid" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_bloc_elementid'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" /><br />
		<?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><small class="attention" style="font-family:monospace">※ID名を変更するとテンプレートファイル名も変更されます。</small><?php endif; ?></td>
	</tr>
	<tr>
		<th>タイトル</th>
		<td><input type="text" id="mfp_bloc_title" name="mfp_bloc_title" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_bloc_title'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" /></td>
	</tr>
	<tr>
		<th>説明文</th>
		<td><textarea id="mfp_bloc_exp" name="mfp_bloc_exp"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_bloc_exp'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</textarea></td>
	</tr>
	<tr>
		<th>デバイス</th>
		<td>
		<select id="mfp_device_type_id" name="mfp_device_type_id">
		<?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrDEVICETYPE'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['device_type_id'] => $this->_tpl_vars['device_type_name']):
?>
			<option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['device_type_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
"<?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_device_type_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) && ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_device_type_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ((is_array($_tmp=$this->_tpl_vars['device_type_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?> selected="selected"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['device_type_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select><br />
		<?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><small class="attention" style="font-family:monospace">※デバイスを変更すると配置されていたレイアウト情報が削除されます。</small><?php endif; ?>
		</td>
	</tr>
	<tr>
		<th>表示数 <span class="attention">*</span></th>
		<td>
		<select id="mfp_num" name="mfp_num">
		<?php unset($this->_sections['mfp_num']);
$this->_sections['mfp_num']['name'] = 'mfp_num';
$this->_sections['mfp_num']['loop'] = is_array($_loop=100) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['mfp_num']['show'] = true;
$this->_sections['mfp_num']['max'] = $this->_sections['mfp_num']['loop'];
$this->_sections['mfp_num']['step'] = 1;
$this->_sections['mfp_num']['start'] = $this->_sections['mfp_num']['step'] > 0 ? 0 : $this->_sections['mfp_num']['loop']-1;
if ($this->_sections['mfp_num']['show']) {
    $this->_sections['mfp_num']['total'] = $this->_sections['mfp_num']['loop'];
    if ($this->_sections['mfp_num']['total'] == 0)
        $this->_sections['mfp_num']['show'] = false;
} else
    $this->_sections['mfp_num']['total'] = 0;
if ($this->_sections['mfp_num']['show']):

            for ($this->_sections['mfp_num']['index'] = $this->_sections['mfp_num']['start'], $this->_sections['mfp_num']['iteration'] = 1;
                 $this->_sections['mfp_num']['iteration'] <= $this->_sections['mfp_num']['total'];
                 $this->_sections['mfp_num']['index'] += $this->_sections['mfp_num']['step'], $this->_sections['mfp_num']['iteration']++):
$this->_sections['mfp_num']['rownum'] = $this->_sections['mfp_num']['iteration'];
$this->_sections['mfp_num']['index_prev'] = $this->_sections['mfp_num']['index'] - $this->_sections['mfp_num']['step'];
$this->_sections['mfp_num']['index_next'] = $this->_sections['mfp_num']['index'] + $this->_sections['mfp_num']['step'];
$this->_sections['mfp_num']['first']      = ($this->_sections['mfp_num']['iteration'] == 1);
$this->_sections['mfp_num']['last']       = ($this->_sections['mfp_num']['iteration'] == $this->_sections['mfp_num']['total']);
?>
			<option value="<?php echo ((is_array($_tmp=$this->_sections['mfp_num']['iteration'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
"<?php if (( ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_num'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) && ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_num'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ((is_array($_tmp=$this->_sections['mfp_num']['iteration'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) ) || ( ! ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_num'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) && ((is_array($_tmp=$this->_sections['mfp_num']['iteration'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ((is_array($_tmp=@PLG_MFP_NUM_DEFAULT)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) )): ?> selected="selected"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_sections['mfp_num']['iteration'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</option>
		<?php endfor; endif; ?>
		</select>&nbsp;件
		</td>
	</tr>
	<tr>
		<th>ピックアップ順 <span class="attention">*</span></th>
		<td>
		<?php $this->assign('options', ((is_array($_tmp=$this->_tpl_vars['arrDimensionName'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))); ?>
		<select id="mfp_order_dimension" name="mfp_order_dimension">
		<?php $_from = ((is_array($_tmp=$this->_tpl_vars['options'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['options'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['options']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['opt']):
        $this->_foreach['options']['iteration']++;
?>
			<option value="<?php echo ((is_array($_tmp=$this->_tpl_vars['k'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
"<?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_order_dimension'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ((is_array($_tmp=$this->_tpl_vars['k'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?> selected="selected"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['opt'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>

		<?php $this->assign('options', ((is_array($_tmp=$this->_tpl_vars['arrDirectionName'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))); ?>
		<select id="mfp_order_direction" name="mfp_order_direction">
		<?php $_from = ((is_array($_tmp=$this->_tpl_vars['options'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['options'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['options']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['opt']):
        $this->_foreach['options']['iteration']++;
?>
			<option value="<?php echo ((is_array($_tmp=$this->_foreach['options']['iteration'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
"<?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_order_direction'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ((is_array($_tmp=$this->_foreach['options']['iteration'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?> selected="selected"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['opt'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</option>
		<?php endforeach; endif; unset($_from); ?>
		</select>
		
		<label><input type="checkbox" id="mfp_disp_random" name="mfp_disp_random" value="1" <?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_disp_random'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == 1): ?>checked="checked" <?php endif; ?>/>ランダム表示にする</label>
		</td>
	</tr>
	<tr>
		<th>商品画像の幅</th>
		<td><input type="text" id="mfp_image_width" name="mfp_image_width" value="<?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_image_width'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_image_width'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
<?php else: ?><?php echo ((is_array($_tmp=@SMALL_IMAGE_WIDTH)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
<?php endif; ?>" /> ピクセル</td>
	</tr>
	<tr>
		<th>商品画像の高さ</th>
		<td><input type="text" id="mfp_image_height" name="mfp_image_height" value="<?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_image_height'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_image_height'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
<?php else: ?><?php echo ((is_array($_tmp=@SMALL_IMAGE_HEIGHT)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
<?php endif; ?>" /> ピクセル</td>
	</tr>
</table>

<div class="btn-area">
    <ul>
		<?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['mfp_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
		<li><a class="btn-action" href="javascript:;" id="to-default"><span class="btn-prev">前の画面に戻る</span></a></li>
		<?php endif; ?>
        <li><a class="btn-action" href="javascript:;" onclick="document.form1.submit();return false;"><span class="btn-next">この内容で設定する</span></a></li>
    </ul>
</div>

</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TEMPLATE_ADMIN_REALDIR)."admin_popup_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>