<?php /* Smarty version 2.6.27, created on 2017-10-18 15:59:25
         compiled from /home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/ManageCustomerStatus/templates/config.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'script_escape', '/home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/ManageCustomerStatus/templates/config.tpl', 25, false),array('modifier', 'h', '/home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/ManageCustomerStatus/templates/config.tpl', 26, false),array('modifier', 'default', '/home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/ManageCustomerStatus/templates/config.tpl', 37, false),array('function', 'html_options', '/home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/ManageCustomerStatus/templates/config.tpl', 37, false),array('function', 'html_radios', '/home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/ManageCustomerStatus/templates/config.tpl', 44, false),array('function', 'html_checkboxes', '/home/oomaekunccb/rchs-studio.com/public_html/video//data/downloads/plugin/ManageCustomerStatus/templates/config.tpl', 59, false),)), $this); ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TEMPLATE_ADMIN_REALDIR)."admin_popup_header.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript">
</script>

<h2><?php echo ((is_array($_tmp=$this->_tpl_vars['tpl_subtitle'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</h2>
<form name="form1" id="form1" method="post" action="<?php echo ((is_array($_tmp=((is_array($_tmp=$_SERVER['REQUEST_URI'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
">
<input type="hidden" name="<?php echo ((is_array($_tmp=@TRANSACTION_ID_NAME)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['transactionid'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
<input type="hidden" name="mode" value="edit">

<h3>設定</h3>
<table border="0" cellspacing="1" cellpadding="8" summary=" ">
        <col width="30%" />
        <col width="70%" />
    <tr >
        <th>会員価格タイトル<span class="attention">※</span></th>
        <td><span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['member_rank_price_title_mode'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
        会員ランク名をタイトルに<?php echo smarty_function_html_options(array('name' => 'member_rank_price_title_mode','options' => ((is_array($_tmp=$this->_tpl_vars['arrMode'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'selected' => ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrForm']['member_rank_price_title_mode'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

        <br><span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['member_rank_price_title'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
        固定表示タイトル：<input type="text" class="box160" name="member_rank_price_title" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['member_rank_price_title'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" style="<?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['member_rank_price_title'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) != ""): ?>background-color: <?php echo ((is_array($_tmp=@ERR_COLOR)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
;<?php endif; ?>">
        </td>
    </tr>
    <tr >
        <th>会員価格の表示設定<span class="attention">※</span></th>
        <td><span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['login_disp'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span><?php echo smarty_function_html_radios(array('options' => ((is_array($_tmp=$this->_tpl_vars['arrLoginDisp'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'name' => 'login_disp','selected' => ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrForm']['login_disp'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>
</td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">更新期間</td>
        <td>
        	<?php $this->assign('key', 'term'); ?>
            <span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
			<?php echo smarty_function_html_options(array('name' => ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'options' => ((is_array($_tmp=$this->_tpl_vars['arrTerm'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'selected' => ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>

        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">対象受注ステータス設定<br><span style="font-size:10px; color:#0000FF;">昇格条件の購入金額、購入回数のカウント対象とする受注ステータスを設定します</span></td>
        <td>
        	<?php $this->assign('key', 'target_id'); ?>
            <span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
        	<?php echo smarty_function_html_checkboxes(array('options' => ((is_array($_tmp=$this->_tpl_vars['arrORDERSTATUS'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'name' => ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'selected' => ((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'separator' => "<br>"), $this);?>

        </td>
    </tr>
    <tr >
        <td bgcolor="#f3f3f3">ポイント有効期限設定</td>
        <td>        
        	<?php $this->assign('key', 'point_term'); ?>
            <span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
			<input type="text" name="point_term" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" class="box10">日間
        </td>
    </tr>
</table>

<div class="btn-area">
    <ul>
        <li>
            <a class="btn-action" href="javascript:;" onclick="document.form1.submit();return false;"><span class="btn-next">この内容で登録する</span></a>
        </li>
    </ul>
</div>

</form>

<h3>手動チェック</h3>
<form name="form2" id="form2" method="post" action="<?php echo ((is_array($_tmp=((is_array($_tmp=$_SERVER['REQUEST_URI'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
">
<input type="hidden" name="<?php echo ((is_array($_tmp=@TRANSACTION_ID_NAME)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['transactionid'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
<input type="hidden" name="mode" value="rank_check">
<div class="btn-area">
    <ul>
        <li>
            <a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form2','rank_check','','');return false;"><span class="btn-next">全会員のランクチェックを行う</span></a>
        </li>
        <br><br>
        <li>
            <a class="btn-action" href="javascript:;" onclick="fnFormModeSubmit('form2','rank_reset','','');return false;"><span class="btn-next">更新期間内のランクチェックフラグをリセットする</span></a>
        </li>
    </ul>
</div>
</form>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => (@TEMPLATE_ADMIN_REALDIR)."admin_popup_footer.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
