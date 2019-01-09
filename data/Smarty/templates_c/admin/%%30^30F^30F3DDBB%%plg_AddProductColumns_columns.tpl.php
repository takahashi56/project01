<?php /* Smarty version 2.6.27, created on 2018-09-21 13:31:04
         compiled from /home/joycurrent/joycurrent.xsrv.jp/public_html//data/downloads/plugin/AddProductColumns/templates/admin/products/plg_AddProductColumns_columns.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'script_escape', '/home/joycurrent/joycurrent.xsrv.jp/public_html//data/downloads/plugin/AddProductColumns/templates/admin/products/plg_AddProductColumns_columns.tpl', 30, false),array('modifier', 'h', '/home/joycurrent/joycurrent.xsrv.jp/public_html//data/downloads/plugin/AddProductColumns/templates/admin/products/plg_AddProductColumns_columns.tpl', 32, false),array('modifier', 'sfGetErrorColor', '/home/joycurrent/joycurrent.xsrv.jp/public_html//data/downloads/plugin/AddProductColumns/templates/admin/products/plg_AddProductColumns_columns.tpl', 44, false),array('modifier', 'cat', '/home/joycurrent/joycurrent.xsrv.jp/public_html//data/downloads/plugin/AddProductColumns/templates/admin/products/plg_AddProductColumns_columns.tpl', 138, false),)), $this); ?>
 
<style type="text/css">
.column-id{
    text-align: center;
}
</style>
 
<div class="contents-main">
    <form name="form1" id="form1" method="post" action="?">
        <input type="hidden" name="<?php echo ((is_array($_tmp=@TRANSACTION_ID_NAME)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=$this->_tpl_vars['transactionid'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" />
        <input type="hidden" name="mode" value="add" />
        <input type="hidden" name="column_id" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrForm']['column_id']['value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
" />
        <table id="column">
            <?php $this->assign('key', 'name'); ?>
            <tr id="column-name">
                <th>
                    <?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']]['disp_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

                    <span class="attention">*</span>
                </th>
                <td>
                    <span class="attention">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

                    </span>
                    <input type="text" name="<?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']]['value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
" maxlength="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']]['length'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" class="box60" style="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrErr'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('sfGetErrorColor', true, $_tmp) : SC_Utils_Ex::sfGetErrorColor($_tmp)); ?>
" />
                    <small class="attention">
                        (上限<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']]['length'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
文字)
                    </small>
                </td>
            </tr>
            <?php $this->assign('key', 'type'); ?>
            <tr id="column-type">
                <th>
                    <?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']]['disp_name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

                    <span class="attention">*</span>
                </th>
                <td>
                    <span class="attention">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr'][$this->_tpl_vars['key']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

                    </span>
                    <label>
                        <input type="radio" name="<?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=@COLUMN_TYPE_TEXT)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" <?php if (((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']]['value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ((is_array($_tmp=@COLUMN_TYPE_TEXT)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) || ! ((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']]['value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>checked="checked"<?php endif; ?> />
                        テキストフォーム
                    </label>
                    <label>
                        <input type="radio" name="<?php echo ((is_array($_tmp=$this->_tpl_vars['key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=@COLUMN_TYPE_TEXTAREA)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" <?php if (((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key']]['value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ((is_array($_tmp=@COLUMN_TYPE_TEXTAREA)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>checked="checked"<?php endif; ?> />
                        テキストエリア (HTMLタグ利用可)
                    </label>
                </td>
            </tr>
            <?php $this->assign('key1', 'required'); ?>
            <?php $this->assign('key2', 'max_length'); ?>
            <tr id="column-restriction">
                <th>
                    入力制限
                    <span class="attention">*</span>
                </th>
                <td>
                    <span class="attention">
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr'][$this->_tpl_vars['key1']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

                        <?php echo ((is_array($_tmp=$this->_tpl_vars['arrErr'][$this->_tpl_vars['key2']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>

                    </span>
                    <input type="hidden" name="<?php echo ((is_array($_tmp=$this->_tpl_vars['key1'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="0" />
                    <label>
                        <input type="checkbox" name="<?php echo ((is_array($_tmp=$this->_tpl_vars['key1'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="1" <?php if (((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key1']]['value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == '1'): ?>checked="checked"<?php endif; ?> />
                        入力必須
                    </label>
                    <label>
                        <input type="text" name="<?php echo ((is_array($_tmp=$this->_tpl_vars['key2'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" value="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key2']]['value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
" maxlength="<?php echo ((is_array($_tmp=$this->_tpl_vars['arrForm'][$this->_tpl_vars['key2']]['length'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
" class="box40" style="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrErr'][$this->_tpl_vars['key2']])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('sfGetErrorColor', true, $_tmp) : SC_Utils_Ex::sfGetErrorColor($_tmp)); ?>
" />
                        文字以内
                    </label>
                </td>
            </tr>
        </table>
        <div class="btn-area">
            <ul>
                <li>
                    <a class="btn-action" href="javascript:;" onclick="document.form1.submit();">
                        <span class="btn-next">この内容で登録する</span>
                    </a>
                </li>
            </ul>
        </div>
        <table id="columns" class="list">
            <colgroup>
                <col width="5%" />
                <col width="20%" />
                <col width="20%" />
                <col width="20%" />
                <col width="15%" />
                <col width="20%" />
            </colgroup>
            <thead>
                <tr>
                    <th class="column-id">
                        ID
                    </th>
                    <th class="name">
                        項目名<br />
                        <small class="attention">(*は必須)</small>
                    </th>
                    <th class="name-tag">
                        項目名タグ
                    </th>
                    <th class="name-tag">
                        入力内容タグ
                    </th>
                    <th class="type">
                        入力パターン<br />
                        <small>(入力規則)</small>
                    </th>
                    <th class="actions center">
                        操作
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php $_from = ((is_array($_tmp=$this->_tpl_vars['arrColumns'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['arrColumn']):
?>
                    <?php $this->assign('papc_key', ((is_array($_tmp=((is_array($_tmp=@PAPC_PREFIX)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('cat', true, $_tmp, ((is_array($_tmp=$this->_tpl_vars['arrColumn']['column_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))) : smarty_modifier_cat($_tmp, ((is_array($_tmp=$this->_tpl_vars['arrColumn']['column_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))))); ?>
                    <?php $this->assign('editing', false); ?>
                    <?php if (((is_array($_tmp=$this->_tpl_vars['arrForm']['column_id']['value'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ((is_array($_tmp=$this->_tpl_vars['arrColumn']['column_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
                        <?php $this->assign('editing', true); ?>
                    <?php endif; ?>
                    <tr <?php if (((is_array($_tmp=$this->_tpl_vars['editing'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>style="background:#ffffdf;"<?php endif; ?>>
                        <td class="column-id">
                            <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrColumn']['column_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>

                        </td>
                        <td class="name">
                            <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrColumn']['name'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>

                            <span class="attention">
                                <?php if (((is_array($_tmp=$this->_tpl_vars['arrColumn']['required'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
                                    *
                                <?php endif; ?>
                            </span>
                        </td>
                        <td class="name-tag">
                            <input type="text" value="&lt;!--{$arrProduct.<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['papc_key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
.name|h}--&gt;" class="box40" onmouseover="this.select(0, this.value.length)" readonly="readonly" />
                        </td>
                        <td class="value-tag">
                            <?php if (((is_array($_tmp=$this->_tpl_vars['arrColumn']['type'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ((is_array($_tmp=@COLUMN_TYPE_TEXT)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
                                <input type="text" value="&lt;!--{$arrProduct.<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['papc_key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
.value|h}--&gt;" class="box40" onmouseover="this.select(0, this.value.length)" readonly="readonly" />
                            <?php elseif (((is_array($_tmp=$this->_tpl_vars['arrColumn']['type'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) == ((is_array($_tmp=@COLUMN_TYPE_TEXTAREA)) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
                                <input type="text" value="&lt;!--{$arrProduct.<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['papc_key'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
.value|nl2br}--&gt;" class="box40" onmouseover="this.select(0, this.value.length)" readonly="readonly" />
                            <?php endif; ?>
                        </td>
                        <td class="type">
                            <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrColumn']['type'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>

                            <?php if (strlen ( ((is_array($_tmp=$this->_tpl_vars['arrColumn']['max_length'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)) ) > 0): ?>
                                (<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['arrColumn']['max_length'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)))) ? $this->_run_mod_handler('h', true, $_tmp) : smarty_modifier_h($_tmp)); ?>
)
                            <?php endif; ?>
                        </td>
                        <td class="edit center">
                            <?php if (((is_array($_tmp=$this->_tpl_vars['editing'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp))): ?>
                            編集中
                            <?php else: ?>
                            <a href="javascript:void(0);" class="btn-tool" onclick="fnModeSubmit('edit', 'column_id', '<?php echo ((is_array($_tmp=$this->_tpl_vars['arrColumn']['column_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
');">
                                編集
                            </a>
                            <?php endif; ?>
                            <a href="javascript:void(0);" class="btn-tool" onclick="fnModeSubmit('delete', 'column_id', '<?php echo ((is_array($_tmp=$this->_tpl_vars['arrColumn']['column_id'])) ? $this->_run_mod_handler('script_escape', true, $_tmp) : smarty_modifier_script_escape($_tmp)); ?>
');">
                                削除
                            </a>
                        </td>
                    </tr>
                <?php endforeach; endif; unset($_from); ?>
            </tbody>
        </table>
    </form>
</div>