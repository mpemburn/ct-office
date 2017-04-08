<?php /* Smarty version Smarty-3.1.1, created on 2012-02-10 14:15:34
         compiled from "application/views/members/member_history.php" */ ?>
<?php /*%%SmartyHeaderCode:14054806394f356934377a74-78427995%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7195e801f2ac1ff5e8a3ff3b35234fb9c28e0295' => 
    array (
      0 => 'application/views/members/member_history.php',
      1 => 1328901266,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14054806394f356934377a74-78427995',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_4f35693441d92',
  'variables' => 
  array (
    'clear_x' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f35693441d92')) {function content_4f35693441d92($_smarty_tpl) {?><div id="detail_title">Change History</div>
<div id="no_data">
	No Records Found
</div>
<div id="history_container">	
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