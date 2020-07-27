<?php /* Smarty version Smarty-3.1.21-dev, created on 2016-04-11 14:33:00
         compiled from "/var/www/pfa/templates/flash_error.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1462694098570b68443977b9-46656316%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ab4bc58435695c6ddea9ccfda43a55d7e34d474e' => 
    array (
      0 => '/var/www/pfa/templates/flash_error.tpl',
      1 => 1326318401,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1462694098570b68443977b9-46656316',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'msg' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21-dev',
  'unifunc' => 'content_570b68443b7f12_99011001',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_570b68443b7f12_99011001')) {function content_570b68443b7f12_99011001($_smarty_tpl) {?><!-- <?php echo basename($_smarty_tpl->source->filepath);?>
 -->
<br clear="all"/><br />
<?php if (isset($_SESSION['flash'])) {
if (isset($_SESSION['flash']['info'])) {?><ul class="flash-info"><?php  $_smarty_tpl->tpl_vars['msg'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['msg']->_loop = false;
 $_from = $_SESSION['flash']['info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['msg']->key => $_smarty_tpl->tpl_vars['msg']->value) {
$_smarty_tpl->tpl_vars['msg']->_loop = true;
?><li><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['msg']->value, ENT_QUOTES, 'UTF-8', true);?>
</li><?php } ?></ul><?php }
if (isset($_SESSION['flash']['error'])) {?><ul class="flash-error"><?php  $_smarty_tpl->tpl_vars['msg'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['msg']->_loop = false;
 $_from = $_SESSION['flash']['error']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['msg']->key => $_smarty_tpl->tpl_vars['msg']->value) {
$_smarty_tpl->tpl_vars['msg']->_loop = true;
?><li><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['msg']->value, ENT_QUOTES, 'UTF-8', true);?>
</li><?php } ?></ul><?php }
}?>
<?php }} ?>
