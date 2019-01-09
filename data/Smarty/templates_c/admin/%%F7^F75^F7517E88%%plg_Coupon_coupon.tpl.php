<?php /* Smarty version 2.6.27, created on 2018-02-23 18:40:51
         compiled from contents/plg_Coupon_coupon.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'script_escape', 'contents/plg_Coupon_coupon.tpl', 25, false),array('modifier', 'escape', 'contents/plg_Coupon_coupon.tpl', 68, false),array('modifier', 'number_format', 'contents/plg_Coupon_coupon.tpl', 78, false),array('modifier', 'sfDispDBDate', 'contents/plg_Coupon_coupon.tpl', 81, false),)), $this); ?>
<form name="form1" id="form1" method="post" action="">
<input type="hidden" name="<?php echo ((is_array($_tmp=@TRANSACTION_ID_NAME)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['transactionid'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
<input type="hidden" name="mode" value="">
<input type="hidden" name="coupon_id" value="">
<input type="hidden" name="search_pageno" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['tpl_pageno'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
">
<div id="system" class="contents-main">
    <!--▼クーポン一覧ここから-->
    <table class="list">
        <colgroup width="5%">
        <colgroup width="13%">
        <colgroup width="15%">
        <colgroup width="10%">
        <colgroup width="10%">
        <colgroup width="10%">
        <colgroup width="17%">
        <colgroup width="7%">
        <colgroup width="4%">
        <colgroup width="4%">
        <colgroup width="5%">
        <div class="btn">
          <a class="btn-action" href="#" onclick="location.href='./plg_Coupon_coupon_input.php'"><span class="btn-next">クーポンを新規作成</span></a>
          <br /><br />
          <!--▼ページ送り-->
          <span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['tpl_linemax'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
件</span>&nbsp;が該当しました。
          <?php if (count ( ((is_array($_tmp=$this->_tpl_vars['list_data'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) ) > 0): ?>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => ((is_array($_tmp=$this->_tpl_vars['tpl_pager'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)), 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
          <?php endif; ?>
          <!--▲ページ送り-->
        </div>
        <tr>
            <th>No.</th>
            <th>クーポンID</th>
            <th>メモ(非公開)</th>
            <th>割引額(率)</th>
            <th>対象</th>
            <th>利用可能<br />購入金額下限</th>
            <th>有効期限</th>
            <th>利用可能<br />回数制限</th>
            <th>編集</th>
            <th>削除</th>
            <th>使用回数</th>
        </tr>
        <?php $_from = ((is_array($_tmp=$this->_tpl_vars['list_data'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['data']):
        $this->_foreach['loop']['iteration']++;
?>
        <!--▼クーポン<?php echo ((is_array($_tmp=$this->_sections['data']['iteration'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
-->
        <?php $this->assign('enable_flg', ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data']['enable_flg'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp))); ?>
        <?php if (((is_array($_tmp=$this->_tpl_vars['enable_flg'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == 1 || ((is_array($_tmp=time())) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) > ((is_array($_tmp=$this->_tpl_vars['data']['end_date_timestamp'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
            <?php $this->assign('tr_color', '#B0B0B0'); ?>
        <?php else: ?>
            <?php $this->assign('tr_color', '#ffffff'); ?>
        <?php endif; ?>
        <tr bgcolor="<?php echo ((is_array($_tmp=$this->_tpl_vars['tr_color'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
">
            <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data']['coupon_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data']['coupon_id_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data']['memo'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td align="center"><?php if (((is_array($_tmp=$this->_tpl_vars['data']['discount_type'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == 0): ?>&yen;<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data']['discount_price'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
<?php elseif (((is_array($_tmp=$this->_tpl_vars['data']['discount_type'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == 2): ?>加算ポイント<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data']['discount_price'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
pt<?php else: ?><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data']['discount_percent'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
%<?php endif; ?></td>
            <td align="center"><?php if (((is_array($_tmp=$this->_tpl_vars['data']['coupon_target'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == 0): ?>全て<?php else: ?>限定<?php endif; ?></td>
            <td align="center">\<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data']['use_limit'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td align="center"><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data']['start_date'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('sfDispDBDate', true, $_tmp, false) : SC_Utils_Ex::sfDispDBDate($_tmp, false)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
～<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data']['end_date'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('sfDispDBDate', true, $_tmp, false) : SC_Utils_Ex::sfDispDBDate($_tmp, false)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
</td>
            <td align="center"><?php if (((is_array($_tmp=$this->_tpl_vars['data']['count_limit'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == 0): ?>無制限<?php elseif (((is_array($_tmp=$this->_tpl_vars['data']['count_limit'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == 2): ?>全体で1回限り<?php else: ?>1回限り<?php endif; ?></td>
            <td align="center"><a href="" onclick="eccube.changeAction('plg_Coupon_coupon_input.php', 'form1'); eccube.fnFormModeSubmit('form1', 'edit', 'coupon_id', <?php echo ((is_array($_tmp=$this->_tpl_vars['data']['coupon_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
); return false;">編集</a></td>
            <td align="center"><a href="" onclick="eccube.fnFormModeSubmit('form1', 'delete', 'coupon_id', <?php echo ((is_array($_tmp=$this->_tpl_vars['data']['coupon_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
); return false;">削除</a></td>
            <td align="center"><?php if (((is_array($_tmp=$this->_tpl_vars['data']['used_num'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['data']['used_num'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)))) ? $this->_run_mod_handler('number_format', true, $_tmp) : number_format($_tmp)); ?>
<?php else: ?>0<?php endif; ?>回</td>
        </tr>
        <!--▲クーポン<?php echo ((is_array($_tmp=$this->_sections['data']['iteration'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
-->
        <?php endforeach; else: ?>
        <tr bgcolor="#ffffff"><td colspan="11" align="center"> まだクーポンが登録されていません </td></tr>
        <?php endif; unset($_from); ?>
    </table>

    <div class="paging">
        <!--▼ページ送り-->
        <?php echo ((is_array($_tmp=$this->_tpl_vars['tpl_strnavi'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

        <!--▲ページ送り-->
    </div>
</div>
</form>