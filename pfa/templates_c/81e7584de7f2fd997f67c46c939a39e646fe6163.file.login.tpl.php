<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-04-11 14:33:00
         compiled from "/var/www/pfa/templates/login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:640179261570b68443b9980-27085878%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '81e7584de7f2fd997f67c46c939a39e646fe6163' => 
    array (
      0 => '/var/www/pfa/templates/login.tpl',
      1 => 1375040810,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '640179261570b68443b9980-27085878',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'logintype' => 0,
    'PALANG' => 0,
    'language_selector' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_570b68443cf7b2_30287078',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_570b68443cf7b2_30287078')) {function content_570b68443cf7b2_30287078($_smarty_tpl) {?><div id="login">
<form name="frmLogin" method="post" action="">
<table id="login_table" cellspacing="10">
	<tr>
		<th colspan="2">
<?php if ($_smarty_tpl->tpl_vars['logintype']->value=='admin') {
echo $_smarty_tpl->tpl_vars['PALANG']->value['pLogin_welcome'];?>

<?php } else {
echo $_smarty_tpl->tpl_vars['PALANG']->value['pUsersLogin_welcome'];?>

<?php }?>
	</th>
	</tr>
	<tr>
		<td class="label"><label><?php echo $_smarty_tpl->tpl_vars['PALANG']->value['pLogin_username'];?>
:</label></td>
		<td><input class="flat" type="text" name="fUsername" /></td>
	</tr>
	<tr>
		<td class="label"><label><?php echo $_smarty_tpl->tpl_vars['PALANG']->value['password'];?>
:</label></td>
		<td><input class="flat" type="password" name="fPassword" /></td>
	</tr>
	<tr>
		<td class="label"><label><?php echo $_smarty_tpl->tpl_vars['PALANG']->value['pLogin_language'];?>
:</label></td>
		<td><?php echo $_smarty_tpl->tpl_vars['language_selector']->value;?>
</td>
	</tr>
	<tr>
		<td class="label">&nbsp;</td>
		<td><input class="button" type="submit" name="submit" value="<?php echo $_smarty_tpl->tpl_vars['PALANG']->value['pLogin_button'];?>
" /></td>
	</tr>
<?php if ($_smarty_tpl->tpl_vars['logintype']->value=='admin') {?>
	<tr>
		<td colspan="2"><a href="users/"><?php echo $_smarty_tpl->tpl_vars['PALANG']->value['pLogin_login_users'];?>
</a></td>
	</tr>
<?php }?>
</table>
</form>

<?php echo '<script'; ?>
 type="text/javascript">
<!--
	document.frmLogin.fUsername.focus();
// -->
<?php echo '</script'; ?>
>

</div>

<?php }} ?>
