<?php /* Smarty version Smarty-3.1.1, created on 2013-06-26 11:33:07
         compiled from "application/views/templates/header.php" */ ?>
<?php /*%%SmartyHeaderCode:20178622194f219bcfa1f519-05051677%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '95c6f86fee816eb318b58b4e94b9cf9e41dd7b7f' => 
    array (
      0 => 'application/views/templates/header.php',
      1 => 1372260779,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20178622194f219bcfa1f519-05051677',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_4f219bcfa4b66',
  'variables' => 
  array (
    'app_name' => 0,
    'menu_array' => 0,
    'link' => 0,
    'title' => 0,
    'user_full_name' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f219bcfa4b66')) {function content_4f219bcfa4b66($_smarty_tpl) {?><div class="container_12">  
	<div class="grid_12" id="header_panel">
		<h1 class="head_face"><?php echo $_smarty_tpl->tpl_vars['app_name']->value;?>
</h1>	
	</div>
	<div class="clear"></div>  
	<div class="grid_12 head_face"  id="nav_panel">
		<ul class="grid_10" id="nav">
<?php  $_smarty_tpl->tpl_vars['link'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['link']->_loop = false;
 $_smarty_tpl->tpl_vars['title'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['menu_array']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['link']->key => $_smarty_tpl->tpl_vars['link']->value){
$_smarty_tpl->tpl_vars['link']->_loop = true;
 $_smarty_tpl->tpl_vars['title']->value = $_smarty_tpl->tpl_vars['link']->key;
?>
			<li><a href="<?php echo $_smarty_tpl->tpl_vars['link']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
&nbsp;&nbsp;</a></li>
<?php } ?>
		</ul>
		<div id="logged_in" class="grid_1 grid_right">Logged in: <?php echo $_smarty_tpl->tpl_vars['user_full_name']->value;?>
</div>
	</div>
	<div class="clear"></div>  
<?php }} ?>