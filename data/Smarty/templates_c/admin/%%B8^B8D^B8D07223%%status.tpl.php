<?php /* Smarty version 2.6.27, created on 2018-02-23 02:34:00
         compiled from /home/oomaekunccb/mallento.com/public_html/stmingo-demo//data/downloads/plugin/ManageCustomerStatus/templates/admin/customer/status.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'script_escape', '/home/oomaekunccb/mallento.com/public_html/stmingo-demo//data/downloads/plugin/ManageCustomerStatus/templates/admin/customer/status.tpl', 21, false),array('modifier', 'h', '/home/oomaekunccb/mallento.com/public_html/stmingo-demo//data/downloads/plugin/ManageCustomerStatus/templates/admin/customer/status.tpl', 21, false),array('modifier', 'strlen', '/home/oomaekunccb/mallento.com/public_html/stmingo-demo//data/downloads/plugin/ManageCustomerStatus/templates/admin/customer/status.tpl', 158, false),)), $this); ?>

<form name="form1" id="form1" method="post" action="<?php echo ((is_array($_tmp=((is_array($_tmp=$_SERVER['REQUEST_URI'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
">
<input type="hidden" name="<?php echo ((is_array($_tmp=@TRANSACTION_ID_NAME)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['transactionid'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
<input type="hidden" name="mode" value="edit">
<input type="hidden" name="status_id" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['status_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
">

<table border="0" cellspacing="1" cellpadding="8" summary=" ">
<tr>
<th>名称<span class="attention">※</span></th>
<td><span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
<input type="text" class="box30" name="name" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" /></td>
</tr>
<tr>
<th>ランク<span class="attention">※</span></th>
<td><span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['priority'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
<input type="text" class="box6" name="priority" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['priority'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />&nbsp;数字で入力（高い値ほど高いランクになります）</td>
</tr>
<tr>
<th colspan="2" style="text-align:center;">会員特典</th>
</tr>
<tr>
<th>割引・値引き</th>
<td>
<span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['discount_rate'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
割引率：<input type="text" name="discount_rate" size="6" class="box6" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['discount_rate'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />%
<br>
商品登録の際に会員価格が設定されていない場合はここで設定された割引率を適用した価格が会員価格となります。<br><br>
<span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['discount_value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
値引き：<input type="text" name="discount_value" size="6" class="box6" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['discount_value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />円
<br>
合計額から設定した額の値引きを行います。
</td>
</tr>
<tr>
<th>増加ポイント</th>
<td><span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['point_rate'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
<span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['point_value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
増加率：<input type="text" name="point_rate" size="6" class="box6" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['point_rate'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />%&nbsp;&nbsp;&nbsp; OR &nbsp;&nbsp;&nbsp;
増加ポイント：<input type="text" name="point_value" size="6" class="box6" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['point_value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />pt<br>
</td>
</tr>
<tr>
<th>送料値引き</th>
<td><span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['discount_fee'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
<input type="text" name="discount_fee" size="6" class="box6" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['discount_fee'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />円&nbsp;
<input type="checkbox" name="free_fee" value="1" <?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['free_fee'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == 1): ?>checked<?php endif; ?>/>送料無料にする
</td>
</tr>
<tr>
<th colspan="2" style="text-align:center;">昇格条件</th>
</tr>
<tr>
<th>購入金額</th>
<td><span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['total_amount'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
<input type="text" name="total_amount" size="6" class="box6" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['total_amount'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />円以上
</td>
</tr>
<tr>
<th>購入回数</th>
<td><span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['buy_times'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
<input type="text" name="buy_times" size="6" class="box6" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['buy_times'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />回以上
</td>
</tr>
<tr>
<th>保有ポイント</th>
<td><span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['total_point'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
<input type="text" name="total_point" size="6" class="box6" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['total_point'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />pt以上
</td>
</tr>
<tr>
<th colspan="2" style="text-align:center;">加入時ランク設定</th>
</tr>
<tr>
<th>会員登録時の初期ランクとして設定</th>
<td><span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['initial_rank'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
<input type="checkbox" name="initial_rank" value="1" <?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['initial_rank'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == 1): ?>checked<?php endif; ?>/>初期ランクとして設定する
</td>
</tr>
<tr>
<th colspan="2" style="text-align:center;">固定ランク設定</th>
</tr>
<tr>
<th>自動更新処理の対象外ランクに設定</th>
<td><span class="attention"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['fixed_rank'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
<input type="checkbox" name="fixed_rank" value="1" <?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['fixed_rank'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == 1): ?>checked<?php endif; ?>/>固定ランクとして設定する
</td>
</tr>
</table>


<div class="btn-area" style="text-align:center;">
    <ul>
        <li>
            <a class="btn-action" href="javascript:;" onclick="fnModeSubmit('edit','','');return false;"><span class="btn-next">この内容で登録する</span></a>
        </li>
    </ul>
</div>
<br>

<table border="0" cellspacing="1" cellpadding="8" summary=" ">
<col width="4%"/>
<col width="14%"/>
<col width="5%" />
<col width="12%" />
<col width="12%" />
<col width="12%" />
<col width="10%" />
<col width="10%" />
<col width="10%" />
<col width="6%" />    
<col width="6%" />
<tr>
<th rowspan="2" class="center">ID</th>
<th rowspan="2" class="center">名称</th>
<th rowspan="2" class="center">ランク</th>
<th colspan="3" class="center">特典</th>
<th colspan="3" class="center">昇格条件</th>
<th colspan="2"></th>
</tr>
<tr>
<th class="center">割引・値引</th>
<th class="center">ポイント</th>
<th class="center">送料</th>
<th class="center">購入金額</th>
<th class="center">購入回数</th>
<th class="center">保有ポイント</th>
<th class="center">編集</th>
<th class="center">削除</th>
</tr>
<?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrItems'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['item_loop'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['item_loop']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['item']):
        $this->_foreach['item_loop']['iteration']++;
?>
<tr <?php if (((is_array($_tmp=$this->_tpl_vars['item']['status_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ((is_array($_tmp=$this->_tpl_vars['arrForm']['status_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>style="background-color:<?php echo ((is_array($_tmp=@SELECT_RGB)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
;"<?php endif; ?>>
<td class="center"><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['status_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
</td>
<td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
<?php if (((is_array($_tmp=$this->_tpl_vars['item']['initial_rank'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == 1): ?>(初期)<?php endif; ?><?php if (((is_array($_tmp=$this->_tpl_vars['item']['fixed_rank'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == 1): ?>(固定)<?php endif; ?></td>
<td class="center"><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['priority'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</td>
<td class="right"><?php if (((is_array($_tmp=$this->_tpl_vars['item']['discount_rate'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) > 0): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['discount_rate'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
%割引<br><?php endif; ?><?php if (((is_array($_tmp=$this->_tpl_vars['item']['discount_value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) > 0): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['discount_value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
円値引<?php endif; ?></td>
<td class="right"><?php if (strlen ( ((is_array($_tmp=$this->_tpl_vars['item']['point_rate'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) ) > 0): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['point_rate'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
%増<?php elseif (strlen ( ((is_array($_tmp=$this->_tpl_vars['item']['point_value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) ) > 0): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['point_value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
pt増<?php endif; ?></td>
<td class="right"><?php if (((is_array($_tmp=$this->_tpl_vars['item']['free_fee'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == 1): ?>送料無料<?php elseif (((is_array($_tmp=$this->_tpl_vars['item']['discount_fee'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) > 0): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['discount_fee'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
円引<?php endif; ?></td>
<td class="right">
<?php if (((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['total_amount'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('strlen', true, $_tmp) : strlen($_tmp)) > 0): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['total_amount'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
&nbsp;円<?php endif; ?>
</td>
<td class="right">
<?php if (((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['buy_times'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('strlen', true, $_tmp) : strlen($_tmp)) > 0): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['buy_times'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
&nbsp;回<?php endif; ?>
</td>
<td class="right">
<?php if (((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['item']['total_point'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('strlen', true, $_tmp) : strlen($_tmp)) > 0): ?><?php echo ((is_array($_tmp=$this->_tpl_vars['item']['total_point'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
&nbsp;pt<?php endif; ?>
</td>
<td class="center"><a href="javascript:;" onclick="fnModeSubmit('pre_edit','status_id','<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['status_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
');return false;">編集</a></td>
<td class="center"><a href="javascript:;" onclick="fnModeSubmit('delete','status_id','<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['status_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
');return false;">削除</a></td>
</tr>
<?php endforeach; endif; unset($_from); ?>
</table>


</form>