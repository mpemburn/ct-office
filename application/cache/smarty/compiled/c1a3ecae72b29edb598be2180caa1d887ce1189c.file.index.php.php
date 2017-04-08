<?php /* Smarty version Smarty-3.1.1, created on 2012-02-22 16:47:29
         compiled from "application/views/members/index.php" */ ?>
<?php /*%%SmartyHeaderCode:6838400254f219a4f55eaf2-60916422%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c1a3ecae72b29edb598be2180caa1d887ce1189c' => 
    array (
      0 => 'application/views/members/index.php',
      1 => 1329947244,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6838400254f219a4f55eaf2-60916422',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_4f219a4f59d26',
  'variables' => 
  array (
    'clear_x' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f219a4f59d26')) {function content_4f219a4f59d26($_smarty_tpl) {?><div class="head_face" id="title">Membership Contact Manager</div>

<div id="container">
	<div id="vspace"></div>
	<div id="top_container">
		<div id="search_container">
		<table width="50%">
			<td align="left">
				<input type="text" id="search" title="Enter search terms" autocomplete="off"><img id="clear_search" src="<?php echo $_smarty_tpl->tpl_vars['clear_x']->value;?>
">
			</td>
			<td align="left">
				<div id="found"></div>
			</td>
		</table>
		</div>
	</div>
	<div id="list_container"></div>
</div>
<?php }} ?>