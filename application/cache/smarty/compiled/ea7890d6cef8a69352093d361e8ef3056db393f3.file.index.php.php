<?php /* Smarty version Smarty-3.1.1, created on 2013-06-25 14:40:49
         compiled from "application/views/generate_mvc/index.php" */ ?>
<?php /*%%SmartyHeaderCode:18316829751c9e43111b461-67045832%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ea7890d6cef8a69352093d361e8ef3056db393f3' => 
    array (
      0 => 'application/views/generate_mvc/index.php',
      1 => 1354045684,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18316829751c9e43111b461-67045832',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'output' => 0,
    'config_snippet' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_51c9e4316dbbb',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51c9e4316dbbb')) {function content_51c9e4316dbbb($_smarty_tpl) {?><div class="grid_12" id="title" align="center"><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</div>
<div style="padding: 20px; font-family: Courier New;">
	<div><?php echo $_smarty_tpl->tpl_vars['output']->value;?>
</div>

	<div class="js"><?php echo $_smarty_tpl->tpl_vars['config_snippet']->value;?>
</div>
</div>
<script>

$(document).ready(function() {

	$("pre.js").snippet('javascript');

});

</script>

<?php }} ?>