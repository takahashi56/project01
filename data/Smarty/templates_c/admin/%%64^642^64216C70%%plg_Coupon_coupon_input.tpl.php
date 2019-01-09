<?php /* Smarty version 2.6.27, created on 2017-09-23 15:23:34
         compiled from contents/plg_Coupon_coupon_input.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'script_escape', 'contents/plg_Coupon_coupon_input.tpl', 76, false),array('modifier', 'default', 'contents/plg_Coupon_coupon_input.tpl', 79, false),array('modifier', 'escape', 'contents/plg_Coupon_coupon_input.tpl', 88, false),array('function', 'sfSetErrorStyle', 'contents/plg_Coupon_coupon_input.tpl', 88, false),array('function', 'html_radios', 'contents/plg_Coupon_coupon_input.tpl', 102, false),array('function', 'html_options', 'contents/plg_Coupon_coupon_input.tpl', 133, false),)), $this); ?>
<script type="text/javascript">
<!--
        // 定額・定率切替
        function onChangeDiscountType() {
            var e = document.getElementsByName("discount_type");
            var price   = document.getElementById("discount_price");
            var percent = document.getElementById("discount_percent");
            for(var i=0;i<e.length;i++) {
                if (e[i].checked)
                    switch(e[i].value) {
                        case '0': percent.disabled=true;  price.disabled=false; break;
                        case '1': percent.disabled=false; price.disabled=true;  break;
                    }
            }
        }

        // 対象商品表示切替
        function displayCouponTarget() {
            var e = document.getElementsByName("coupon_target");
            var div = document.getElementById("coupon_target_limited");
            for(var i=0;i<e.length;i++) {
                if (e[i].checked)
                    switch(e[i].value) {
                        case '0': div.style.display = "none"; break;
                        case '1': div.style.display = "block";  break;
                    }
            }
        }

        function fnFormRegistConfirm() {
          /*if (fnConfirm()) {
                document.form1.submit();
            }*/
            document.forms['form1']['mode'].value = 'regist';
            document.form1.submit();
        }

	// onload登録
        function fnFormInit() {
	    if (window.addEventListener) { //for W3C DOM
	        window.addEventListener("load", onChangeDiscountType, false);
	        window.addEventListener("load", displayCouponTarget, false);
	    } else if (window.attachEvent) { //for IE
	        window.attachEvent("onload", onChangeDiscountType);
	        window.attachEvent("onload", displayCouponTarget);
	    }
        }
//-->
</script>

<!--★★メインコンテンツ★★-->
<form name="form1" id="form1" method="post" action="?" enctype="multipart/form-data">
  <input type="hidden" name="<?php echo ((is_array($_tmp=@TRANSACTION_ID_NAME)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['transactionid'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
  <input type="hidden" name="mode" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['mode'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
">
  <input type="hidden" name="coupon_id" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm']['coupon_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
">
  <input type="hidden" name="product_id" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['product_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('default', true, $_tmp, '') : smarty_modifier_default($_tmp, '')); ?>
" />
  <?php $_from = ((is_array($_tmp=$this->_tpl_vars['prodcuts_list'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
  <input type="hidden" name="prodcuts_list[]" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['val'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
">
  <?php endforeach; endif; unset($_from); ?>
  <table class="form">
    <tr>
      <th colspan="1">クーポンID<span class="red">*</span></th>
      <td colspan="3">
        <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['coupon_id_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><span class="red"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['coupon_id_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span><?php endif; ?>
        <input type="text" name="coupon_id_name" size="65" class="box20" <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['coupon_id_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><?php echo SC_Utils_Ex::sfSetErrorStyle(array(), $this);?>
<?php endif; ?> value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrForm']['coupon_id_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />(半角英数字20文字以下)
      </td>
    </tr>
    <tr>
      <th colspan="1">メモ(非公開)</th>
      <td colspan="3">
        <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['memo'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><span class="red12"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['memo'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span><br><?php endif; ?>
        <input type="text" name="memo" size="65" class="box65" <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['memo'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><?php echo SC_Utils_Ex::sfSetErrorStyle(array(), $this);?>
<?php endif; ?> value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrForm']['memo'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />
      </td>
    </tr>
    <tr>
      <th>定率・定額<span class="red">*</span></th>
      <td>
        <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['discount_type'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><span class="red"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['discount_type'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span><?php endif; ?>
        <span <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['discount_type'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><?php echo SC_Utils_Ex::sfSetErrorStyle(array(), $this);?>
<?php endif; ?>><?php echo smarty_function_html_radios(array('name' => 'discount_type','options' => ((is_array($_tmp=$this->_tpl_vars['arrDiscountType'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'separator' => "&nbsp;",'selected' => ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrForm']['discount_type'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'onclick' => "onChangeDiscountType()"), $this);?>
</span>
      </td>
      <th>値引き<span class="red">*</span></th>
      <td>
        <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['discount_price'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><span class="red"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['discount_price'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span><?php endif; ?>
        <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['discount_percent'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><span class="red"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['discount_percent'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span><?php endif; ?>
        <input type="text" name="discount_price" id="discount_price" size="65" class="box6" maxlength="5" <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['discount_price'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><?php echo SC_Utils_Ex::sfSetErrorStyle(array(), $this);?>
<?php endif; ?> value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrForm']['discount_price'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />円&nbsp;
        <input type="text" name="discount_percent" id="discount_percent" size="65" class="box3" maxlength="2" <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['discount_percent'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><?php echo SC_Utils_Ex::sfSetErrorStyle(array(), $this);?>
<?php endif; ?> value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrForm']['discount_percent'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />％
      </td>
    </tr>
    <tr>
      <th colspan="1">利用可能購入金額下限<span class="red">*</span></th>
      <td colspan="3">
        <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['use_limit'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><span class="red"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['use_limit'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span><?php endif; ?>
        <input type="text" name="use_limit" id="use_limit" size="65" class="box6" maxlength="5" <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['use_limit'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><?php echo SC_Utils_Ex::sfSetErrorStyle(array(), $this);?>
<?php endif; ?> value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrForm']['use_limit'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" />円
      </td>
    </tr>
    <tr>
      <th colspan="1">有効/無効<span class="red">*</span></th>
      <td colspan="3">
        <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['enable_flg'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><span class="red12"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['enable_flg'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span><br><?php endif; ?>
        <span <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['enable_flg'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><?php echo SC_Utils_Ex::sfSetErrorStyle(array(), $this);?>
<?php endif; ?>><?php echo smarty_function_html_radios(array('name' => 'enable_flg','options' => ((is_array($_tmp=$this->_tpl_vars['arrEnable'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'separator' => "&nbsp;",'selected' => ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrForm']['enable_flg'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0))), $this);?>
</span>
      </td>
    </tr>
    <tr>
      <th colspan="1">有効期限<span class="red">*</span></th>
      <td colspan="3">
        <span class="red"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['start_year'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['start_month'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['start_day'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
        <span class="red"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['end_year'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['end_month'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
<?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['end_day'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span>
        <select name="start_year" <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['start_year'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) || ((is_array($_tmp=$this->_tpl_vars['arrErr']['start_month'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) || ((is_array($_tmp=$this->_tpl_vars['arrErr']['start_day'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>style="background-color:<?php echo ((is_array($_tmp=((is_array($_tmp=@ERR_COLOR)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"<?php endif; ?>>
          <option value="" selected>----</option>
          <?php echo smarty_function_html_options(array('options' => ((is_array($_tmp=$this->_tpl_vars['arrYear'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'selected' => ((is_array($_tmp=$this->_tpl_vars['start_selected_year'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))), $this);?>

        </select>年
        <select name="start_month" <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['start_year'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) || ((is_array($_tmp=$this->_tpl_vars['arrErr']['start_month'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) || ((is_array($_tmp=$this->_tpl_vars['arrErr']['start_day'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>style="background-color:<?php echo ((is_array($_tmp=((is_array($_tmp=@ERR_COLOR)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"<?php endif; ?>>
          <option value="" selected>--</option>
          <?php echo smarty_function_html_options(array('options' => ((is_array($_tmp=$this->_tpl_vars['arrMonth'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'selected' => ((is_array($_tmp=$this->_tpl_vars['start_selected_month'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))), $this);?>

        </select>月
        <select name="start_day" <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['start_year'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) || ((is_array($_tmp=$this->_tpl_vars['arrErr']['start_month'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) || ((is_array($_tmp=$this->_tpl_vars['arrErr']['start_day'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>style="background-color:<?php echo ((is_array($_tmp=((is_array($_tmp=@ERR_COLOR)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"<?php endif; ?>>
          <option value="" selected>--</option>
          <?php echo smarty_function_html_options(array('options' => ((is_array($_tmp=$this->_tpl_vars['arrDay'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'selected' => ((is_array($_tmp=$this->_tpl_vars['start_selected_day'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))), $this);?>

        </select>日
        &nbsp;～&nbsp;
        <select name="end_year" <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['end_year'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) || ((is_array($_tmp=$this->_tpl_vars['arrErr']['end_month'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) || ((is_array($_tmp=$this->_tpl_vars['arrErr']['end_day'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>style="background-color:<?php echo ((is_array($_tmp=((is_array($_tmp=@ERR_COLOR)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"<?php endif; ?>>
          <option value="" selected>----</option>
          <?php echo smarty_function_html_options(array('options' => ((is_array($_tmp=$this->_tpl_vars['arrYear'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'selected' => ((is_array($_tmp=$this->_tpl_vars['end_selected_year'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))), $this);?>

        </select>年
        <select name="end_month" <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['end_year'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) || ((is_array($_tmp=$this->_tpl_vars['arrErr']['end_month'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) || ((is_array($_tmp=$this->_tpl_vars['arrErr']['end_day'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>style="background-color:<?php echo ((is_array($_tmp=((is_array($_tmp=@ERR_COLOR)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"<?php endif; ?>>
          <option value="" selected>--</option>
          <?php echo smarty_function_html_options(array('options' => ((is_array($_tmp=$this->_tpl_vars['arrMonth'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'selected' => ((is_array($_tmp=$this->_tpl_vars['end_selected_month'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))), $this);?>

        </select>月
        <select name="end_day" <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['end_year'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) || ((is_array($_tmp=$this->_tpl_vars['arrErr']['end_month'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) || ((is_array($_tmp=$this->_tpl_vars['arrErr']['end_day'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>style="background-color:<?php echo ((is_array($_tmp=((is_array($_tmp=@ERR_COLOR)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
"<?php endif; ?>>
          <option value="" selected>--</option>
          <?php echo smarty_function_html_options(array('options' => ((is_array($_tmp=$this->_tpl_vars['arrDay'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'selected' => ((is_array($_tmp=$this->_tpl_vars['end_selected_day'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))), $this);?>

        </select>日
      </td>
    </tr>
    <tr>
      <th colspan="1">対象商品<span class="red">*</span></th>
      <td colspan="3">
        <span <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['coupon_target'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><?php echo SC_Utils_Ex::sfSetErrorStyle(array(), $this);?>
<?php endif; ?>><?php echo smarty_function_html_radios(array('name' => 'coupon_target','options' => ((is_array($_tmp=$this->_tpl_vars['arrCouponTarget'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'separator' => "&nbsp;",'selected' => ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrForm']['coupon_target'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('default', true, $_tmp, 0) : smarty_modifier_default($_tmp, 0)),'onclick' => "displayCouponTarget()"), $this);?>
</span>
        <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['coupon_target'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><span class="red"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['coupon_target'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span><br><?php endif; ?>
        <div id="coupon_target_limited">
          <input type="button" onclick="win03('./plg_Coupon_product_select.php', 'coupon_target_select', '615', '500'); " value="選択" /><br/>
          <?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrProducts'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
            <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['val']['name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
 [<a href="<?php echo ((is_array($_tmp=((is_array($_tmp=$_SERVER['PHP_SELF'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" onclick="fnFormModeSubmit('form1','delete_product','product_id','<?php echo ((is_array($_tmp=$this->_tpl_vars['val']['product_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
'); return false;" >削除</a>] <br>
          <?php endforeach; endif; unset($_from); ?>
        </div>
      </td>
    </tr>
    <tr>
      <th colspan="1">回数制限<span class="red">*</span></th>
      <td colspan="3">
        <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['count_limit'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><span class="red"><?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr']['count_limit'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
</span><?php endif; ?>
        <span <?php if (((is_array($_tmp=$this->_tpl_vars['arrErr']['count_limit'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?><?php echo SC_Utils_Ex::sfSetErrorStyle(array(), $this);?>
<?php endif; ?>><?php echo smarty_function_html_radios(array('name' => 'count_limit','options' => ((is_array($_tmp=$this->_tpl_vars['arrCountLimit'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)),'separator' => "&nbsp;",'selected' => ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrForm']['count_limit'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('default', true, $_tmp, 1) : smarty_modifier_default($_tmp, 1))), $this);?>
</span>
      </td>
    </tr>
  </table>
  <center><div class="btn-area">
    <ul><li><a class="btn-action" href="<?php echo ((is_array($_tmp=((is_array($_tmp=$_SERVER['PHP_SELF'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('escape', true, $_tmp) : smarty_modifier_escape($_tmp)); ?>
" onclick="fnFormRegistConfirm(); return false;"><span class="btn-next">この内容で登録する</span></a></li></ul>
  </div></center>
</form>
<!--★★メインコンテンツ★★-->
