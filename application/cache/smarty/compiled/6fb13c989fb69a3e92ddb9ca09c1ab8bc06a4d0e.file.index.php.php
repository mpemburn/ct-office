<?php /* Smarty version Smarty-3.1.1, created on 2012-04-06 13:04:32
         compiled from "application/views/sales/index.php" */ ?>
<?php /*%%SmartyHeaderCode:480690824f5018ada10b57-60919705%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6fb13c989fb69a3e92ddb9ca09c1ab8bc06a4d0e' => 
    array (
      0 => 'application/views/sales/index.php',
      1 => 1333731828,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '480690824f5018ada10b57-60919705',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_4f5018ada700b',
  'variables' => 
  array (
    'contract_links' => 0,
    'value' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f5018ada700b')) {function content_4f5018ada700b($_smarty_tpl) {?><div class="head_face" id="title">Sales Force Tool Kit</div>
<div id="container">
	<div id="vspace"></div>
	<div class="container_12">
		<div class="grid_5"></div>
		<br /><br /><br />
		<div class="container_12 grid_12" align="center"><a href="#"><button class="big" id="new_contract">New Contract</button></a></div>
		<div id="contract_links">
			<ul>
<?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['contract_links']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
?>
				<a href="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
"><li><?php echo $_smarty_tpl->tpl_vars['value']->key;?>
</li></a>
<?php } ?>
			</ul>
		</div>
	</div>
</div>
<?php }} ?>