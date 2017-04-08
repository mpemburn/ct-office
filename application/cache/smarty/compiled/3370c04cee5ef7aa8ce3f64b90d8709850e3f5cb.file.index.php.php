<?php /* Smarty version Smarty-3.1.1, created on 2012-01-26 13:56:32
         compiled from "application/views/rules/index.php" */ ?>
<?php /*%%SmartyHeaderCode:17935092434f219f8bcb4978-28225767%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3370c04cee5ef7aa8ce3f64b90d8709850e3f5cb' => 
    array (
      0 => 'application/views/rules/index.php',
      1 => 1327604177,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17935092434f219f8bcb4978-28225767',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_4f219f8bd35be',
  'variables' => 
  array (
    'js_vars' => 0,
    'css' => 0,
    'scripts' => 0,
    'vendors' => 0,
    'vendor' => 0,
    'back_arrow' => 0,
    'fwd_arrow' => 0,
    'spinner' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f219f8bd35be')) {function content_4f219f8bd35be($_smarty_tpl) {?><script type="text/javascript">
<?php echo $_smarty_tpl->tpl_vars['js_vars']->value;?>
	
</script>
<?php echo $_smarty_tpl->tpl_vars['css']->value;?>

<?php echo $_smarty_tpl->tpl_vars['scripts']->value;?>

<div id="container">
	<div id="vspace"></div>
	<div id="resource_heading"></div>
	<div id="form_container">
		<div id="list_container">
			<select id="vendor_list">
				<?php  $_smarty_tpl->tpl_vars['vendor'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['vendor']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['vendors']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['vendor']->key => $_smarty_tpl->tpl_vars['vendor']->value){
$_smarty_tpl->tpl_vars['vendor']->_loop = true;
?>
				    <option value="<?php echo $_smarty_tpl->tpl_vars['vendor']->value['vendor_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vendor']->value['vendor_name'];?>
</option>
				<?php } ?>
				<!--<<?php ?>?php foreach ($vendors as $vendor): ?<?php ?>>
					<option value="<?php echo $_smarty_tpl->tpl_vars['vendor']->value['vendor_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['vendor']->value['vendor_name'];?>
</option>
				<<?php ?>?php endforeach ?<?php ?>>-->
			</select>
			<img class="arrow" src="<?php echo $_smarty_tpl->tpl_vars['back_arrow']->value;?>
" id="prev">
			<select id="vendor_resource_list">
			</select>
			<img class="arrow" src="<?php echo $_smarty_tpl->tpl_vars['fwd_arrow']->value;?>
" id="next">
			<img class="arrow" src="<?php echo $_smarty_tpl->tpl_vars['back_arrow']->value;?>
" id="prev_subcat">
			<select id="subcategory_list">
			</select>
			<img class="arrow" src="<?php echo $_smarty_tpl->tpl_vars['fwd_arrow']->value;?>
" id="next_subcat">
			<img id="wait" src="<?php echo $_smarty_tpl->tpl_vars['spinner']->value;?>
">
			<input type="hidden" id="current_id" value="">
			<input type="hidden" id="current_subcat_id" value="">
		</div>
		<div id="years_container">
			Fiscal Year <select id="years"></select>
		</div>
	</div>
	<div id="rules_container"></div>
</div>
<?php }} ?>