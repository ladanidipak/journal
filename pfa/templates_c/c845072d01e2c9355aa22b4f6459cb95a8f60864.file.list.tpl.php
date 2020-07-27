<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-04-11 14:34:16
         compiled from "/var/www/pfa/templates/list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:799173951570b6890bdd5c4-11246851%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c845072d01e2c9355aa22b4f6459cb95a8f60864' => 
    array (
      0 => '/var/www/pfa/templates/list.tpl',
      1 => 1428359220,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '799173951570b6890bdd5c4-11246851',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'admin_list' => 0,
    'admin_selected' => 0,
    'PALANG' => 0,
    'msg' => 0,
    'search' => 0,
    'key' => 0,
    'struct' => 0,
    'searchmode' => 0,
    'field' => 0,
    'table' => 0,
    'colcount' => 0,
    'items' => 0,
    'id_field' => 0,
    'item' => 0,
    'linkto' => 0,
    'tmpkey' => 0,
    'field2' => 0,
    'quota_level' => 0,
    'linktext' => 0,
    'RAW_items' => 0,
    'formconf' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_570b6890d36ea6_23980745',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_570b6890d36ea6_23980745')) {function content_570b6890d36ea6_23980745($_smarty_tpl) {?><?php if (!is_callable('smarty_function_html_options')) include '/var/www/pfa/smarty/libs/plugins/function.html_options.php';
if (!is_callable('smarty_modifier_replace')) include '/var/www/pfa/smarty/libs/plugins/modifier.replace.php';
?><div id="overview">
<form name="frmOverview" method="post" action="">
    <?php if ((count($_smarty_tpl->tpl_vars['admin_list']->value)>1)) {?>
        <?php echo smarty_function_html_options(array('name'=>'username','output'=>$_smarty_tpl->tpl_vars['admin_list']->value,'values'=>$_smarty_tpl->tpl_vars['admin_list']->value,'selected'=>$_smarty_tpl->tpl_vars['admin_selected']->value,'onchange'=>"this.form.submit();"),$_smarty_tpl);?>

        <noscript><input class="button" type="submit" name="go" value="<?php echo $_smarty_tpl->tpl_vars['PALANG']->value['go'];?>
" /></noscript>
    <?php }?>
</form>
<?php if ($_smarty_tpl->tpl_vars['msg']->value['show_simple_search']) {?>
    <?php echo $_smarty_tpl->getConfigVariable('form_search');?>

<?php }?>
</div>

<?php if ($_smarty_tpl->tpl_vars['msg']->value['show_simple_search']) {?>
    <?php if ((count($_smarty_tpl->tpl_vars['search']->value)>0)) {?>
        <div class='searchparams'>
            <p><?php echo $_smarty_tpl->tpl_vars['PALANG']->value['searchparams'];?>

            <?php  $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['search']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field']->key => $_smarty_tpl->tpl_vars['field']->value) {
$_smarty_tpl->tpl_vars['field']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['field']->key;
?>
                <span><?php if ($_smarty_tpl->tpl_vars['struct']->value[$_smarty_tpl->tpl_vars['key']->value]['label']) {
echo $_smarty_tpl->tpl_vars['struct']->value[$_smarty_tpl->tpl_vars['key']->value]['label'];
} else {
echo $_smarty_tpl->tpl_vars['key']->value;
}?>
                    <?php if (isset($_smarty_tpl->tpl_vars['searchmode']->value[$_smarty_tpl->tpl_vars['key']->value])) {
echo $_smarty_tpl->tpl_vars['searchmode']->value[$_smarty_tpl->tpl_vars['key']->value];
} else { ?>=<?php }?> <?php echo $_smarty_tpl->tpl_vars['field']->value;?>

                </span>
            <?php } ?>
            <span><a href="list.php?table=<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
&reset_search=1">[x]</a></span>
        </div>
    <?php }?>
<?php }?>



<div id="list">
<table border=0 id='admin_table'><!-- TODO: 'admin_table' needed because of CSS for table header -->

<?php if ($_smarty_tpl->tpl_vars['msg']->value['list_header']) {?>
	<?php $_smarty_tpl->tpl_vars["colcount"] = new Smarty_variable(2, null, 0);?>
    <?php  $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['struct']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field']->key => $_smarty_tpl->tpl_vars['field']->value) {
$_smarty_tpl->tpl_vars['field']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['field']->key;
?>
        <?php if ($_smarty_tpl->tpl_vars['field']->value['display_in_list']==1&&$_smarty_tpl->tpl_vars['field']->value['label']) {?>
			<?php $_smarty_tpl->tpl_vars["colcount"] = new Smarty_variable($_smarty_tpl->tpl_vars['colcount']->value+1, null, 0);?>
        <?php }?>
    <?php } ?>
	<tr>
		<th colspan="<?php echo $_smarty_tpl->tpl_vars['colcount']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['PALANG']->value[$_smarty_tpl->tpl_vars['msg']->value['list_header']];?>
</th>
	</tr>
<?php }?>

<tr class="header">
    <?php  $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['struct']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field']->key => $_smarty_tpl->tpl_vars['field']->value) {
$_smarty_tpl->tpl_vars['field']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['field']->key;
?>
        <?php if ($_smarty_tpl->tpl_vars['field']->value['display_in_list']==1&&$_smarty_tpl->tpl_vars['field']->value['label']) {?>
            <td><?php echo $_smarty_tpl->tpl_vars['field']->value['label'];?>
</td>
        <?php }?>
    <?php } ?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>

<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['items']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value) {
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
    <?php echo $_smarty_tpl->getConfigVariable('tr_hilightoff');?>


    <?php  $_smarty_tpl->tpl_vars['field'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['struct']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field']->key => $_smarty_tpl->tpl_vars['field']->value) {
$_smarty_tpl->tpl_vars['field']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['field']->key;
?>
        <?php if ($_smarty_tpl->tpl_vars['field']->value['display_in_list']==1&&$_smarty_tpl->tpl_vars['field']->value['label']) {?>

            <?php if ($_smarty_tpl->tpl_vars['field']->value['linkto']!=''&&($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['id_field']->value]!=''||$_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['id_field']->value]>0)) {?>
                <?php ob_start();?><?php echo rawurlencode($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['id_field']->value]);?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();
echo smarty_modifier_replace($_smarty_tpl->tpl_vars['field']->value['linkto'],'%s',$_tmp1);
$_tmp2=ob_get_clean();?><?php $_smarty_tpl->tpl_vars["linkto"] = new Smarty_variable($_tmp2, null, 0);?> 
                <?php $_smarty_tpl->tpl_vars["linktext"] = new Smarty_variable("<a href='".((string)$_smarty_tpl->tpl_vars['linkto']->value)."'>".((string)$_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['key']->value])."</a>", null, 0);?>
            <?php } else { ?>
                <?php $_smarty_tpl->tpl_vars["linktext"] = new Smarty_variable($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['key']->value], null, 0);?>
            <?php }?>

            <?php if ($_smarty_tpl->tpl_vars['table']->value=='foo'&&$_smarty_tpl->tpl_vars['key']->value=='bar') {?>
                <td>Special handling (complete table row) for <?php echo $_smarty_tpl->tpl_vars['table']->value;?>
 / <?php echo $_smarty_tpl->tpl_vars['key']->value;?>
</td></tr>
            <?php } else { ?>
                <td>
                    <?php if ($_smarty_tpl->tpl_vars['table']->value=='foo'&&$_smarty_tpl->tpl_vars['key']->value=='bar') {?>
                        Special handling (td content) for <?php echo $_smarty_tpl->tpl_vars['table']->value;?>
 / <?php echo $_smarty_tpl->tpl_vars['key']->value;?>

                    <?php } elseif ($_smarty_tpl->tpl_vars['table']->value=='aliasdomain'&&$_smarty_tpl->tpl_vars['key']->value=='target_domain'&&$_smarty_tpl->tpl_vars['struct']->value['target_domain']['linkto']=='target') {?>
                        <a href="list-virtual.php?domain=<?php echo rawurlencode($_smarty_tpl->tpl_vars['item']->value['target_domain']);?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['target_domain'];?>
</a>

                    <?php } elseif ($_smarty_tpl->tpl_vars['key']->value=='active') {?>
                        <?php if ($_smarty_tpl->tpl_vars['item']->value['_can_edit']) {?>
                            <a href="<?php echo $_smarty_tpl->getConfigVariable('url_editactive');
echo $_smarty_tpl->tpl_vars['table']->value;?>
&amp;id=<?php echo rawurlencode($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['id_field']->value]);?>
&amp;active=<?php if (($_smarty_tpl->tpl_vars['item']->value['active']==0)) {?>1<?php } else { ?>0<?php }?>&amp;token=<?php echo rawurlencode($_SESSION['PFA_token']);?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['_active'];?>
</a>
                        <?php } else { ?>
                            <?php echo $_smarty_tpl->tpl_vars['item']->value['_active'];?>

                        <?php }?>
                    <?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type']=='bool') {?>
                        <?php $_smarty_tpl->tpl_vars["tmpkey"] = new Smarty_variable("_".((string)$_smarty_tpl->tpl_vars['key']->value), null, 0);
echo $_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['tmpkey']->value];?>

                    <?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type']=='list') {?>
                        <?php  $_smarty_tpl->tpl_vars['field2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field2']->_loop = false;
 $_smarty_tpl->tpl_vars['key2'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['key']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field2']->key => $_smarty_tpl->tpl_vars['field2']->value) {
$_smarty_tpl->tpl_vars['field2']->_loop = true;
 $_smarty_tpl->tpl_vars['key2']->value = $_smarty_tpl->tpl_vars['field2']->key;
echo $_smarty_tpl->tpl_vars['field2']->value;?>
<br> <?php } ?>
                    <?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type']=='pass') {?>
                        (hidden)
                    <?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type']=='quot') {?>
                        <?php $_smarty_tpl->tpl_vars["tmpkey"] = new Smarty_variable("_".((string)$_smarty_tpl->tpl_vars['key']->value)."_percent", null, 0);?>

                        <?php if ($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['tmpkey']->value]>90) {?>
                            <?php $_smarty_tpl->tpl_vars["quota_level"] = new Smarty_variable("high", null, 0);?>
                        <?php } elseif ($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['tmpkey']->value]>55) {?>
                            <?php $_smarty_tpl->tpl_vars["quota_level"] = new Smarty_variable("mid", null, 0);?>
                        <?php } else { ?> 
                            <?php $_smarty_tpl->tpl_vars["quota_level"] = new Smarty_variable("low", null, 0);?>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['tmpkey']->value]>-1) {?>
                            <div class="quota quota_<?php echo $_smarty_tpl->tpl_vars['quota_level']->value;?>
" style="width:<?php echo $_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['tmpkey']->value]*1.2;?>
px;"></div>
                            <div class="quota_bg"></div></div>
                            <div class="quota_text quota_text_<?php echo $_smarty_tpl->tpl_vars['quota_level']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['linktext']->value;?>
</div>
                        <?php } else { ?>
                            <div class="quota_bg quota_no_border"></div></div>
                            <div class="quota_text"><?php echo $_smarty_tpl->tpl_vars['linktext']->value;?>
</div>
                        <?php }?>

                    <?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type']=='txtl') {?>
                        <?php  $_smarty_tpl->tpl_vars['field2'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['field2']->_loop = false;
 $_smarty_tpl->tpl_vars['key2'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['key']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['field2']->key => $_smarty_tpl->tpl_vars['field2']->value) {
$_smarty_tpl->tpl_vars['field2']->_loop = true;
 $_smarty_tpl->tpl_vars['key2']->value = $_smarty_tpl->tpl_vars['field2']->key;
echo $_smarty_tpl->tpl_vars['field2']->value;?>
<br> <?php } ?>
                    <?php } elseif ($_smarty_tpl->tpl_vars['field']->value['type']=='html') {?>
						<?php echo $_smarty_tpl->tpl_vars['RAW_items']->value[$_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['msg']->value['id_field']]][$_smarty_tpl->tpl_vars['key']->value];?>

                    <?php } else { ?>
                        <?php echo $_smarty_tpl->tpl_vars['linktext']->value;?>

                    <?php }?>
                </td>
            <?php }?>
        <?php }?>
    <?php } ?>

    <td><?php if ($_smarty_tpl->tpl_vars['item']->value['_can_edit']) {?><a href="edit.php?table=<?php echo rawurlencode($_smarty_tpl->tpl_vars['table']->value);?>
&amp;edit=<?php echo rawurlencode($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['id_field']->value]);?>
"><?php echo $_smarty_tpl->tpl_vars['PALANG']->value['edit'];?>
</a><?php } else { ?>&nbsp;<?php }?></td>
    <td><?php if ($_smarty_tpl->tpl_vars['item']->value['_can_delete']) {?><a href="<?php echo $_smarty_tpl->getConfigVariable('url_delete');?>
?table=<?php echo $_smarty_tpl->tpl_vars['table']->value;?>
&amp;delete=<?php echo rawurlencode($_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['id_field']->value]);?>
&amp;token=<?php echo rawurlencode($_SESSION['PFA_token']);?>
" 
        onclick="return confirm ('<?php echo smarty_modifier_replace($_smarty_tpl->tpl_vars['PALANG']->value[$_smarty_tpl->tpl_vars['msg']->value['confirm_delete']],'%s',$_smarty_tpl->tpl_vars['item']->value[$_smarty_tpl->tpl_vars['id_field']->value]);?>
')"><?php echo $_smarty_tpl->tpl_vars['PALANG']->value['del'];?>
</a><?php } else { ?>&nbsp;<?php }?></td>
    </tr>
<?php } ?>

</table>

<?php if ($_smarty_tpl->tpl_vars['msg']->value['can_create']) {?>
<br /><a href="edit.php?table=<?php echo rawurlencode($_smarty_tpl->tpl_vars['table']->value);?>
" class="button"><?php echo $_smarty_tpl->tpl_vars['PALANG']->value[$_smarty_tpl->tpl_vars['formconf']->value['create_button']];?>
</a><br />
<br />
<?php }?>
<br /><a href="list.php?table=<?php echo rawurlencode($_smarty_tpl->tpl_vars['table']->value);?>
&amp;output=csv"><?php echo $_smarty_tpl->tpl_vars['PALANG']->value['download_csv'];?>
</a>

</div>
<?php }} ?>
