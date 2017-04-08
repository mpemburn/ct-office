<?php /* Smarty version Smarty-3.1.1, created on 2012-02-10 12:34:51
         compiled from "application/views/members/detail.php" */ ?>
<?php /*%%SmartyHeaderCode:18735325064f2195a2535dd4-70484470%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '97a9ca45d665b5011924c8d9b29375314d9025ea' => 
    array (
      0 => 'application/views/members/detail.php',
      1 => 1328895281,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18735325064f2195a2535dd4-70484470',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_4f2195a2736a9',
  'variables' => 
  array (
    'member_info' => 0,
    'member_display_url' => 0,
    'member_notes_url' => 0,
    'purchasing_url' => 0,
    'history_url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f2195a2736a9')) {function content_4f2195a2736a9($_smarty_tpl) {?><div id="detail_title"><?php echo $_smarty_tpl->tpl_vars['member_info']->value['member_name'];?>
</div>

<div id="member_tabs">
	<!-- the tabs -->
	<ul>
		<li id="tab_general"><a href="#general">General</a></li>
		<li id="tab_purchases"><a href="#notes">Notes</a></li>
		<li id="tab_purchases"><a href="#purchases">Purchases</a></li>
		<li id="tab_history"><a href="#history">History</a></li>
	</ul>
	
	<!-- tab "panes" -->
	<div class="panes">
		<div class="pane" id="general">
			<iframe class="tab_frame" src="<?php echo $_smarty_tpl->tpl_vars['member_display_url']->value;?>
"></iframe>
		</div>
		<div class="pane" id="notes">
			<iframe class="tab_frame" src="<?php echo $_smarty_tpl->tpl_vars['member_notes_url']->value;?>
"></iframe>
		</div>
		<div class="pane" id="purchases">
			<iframe class="tab_frame" src="<?php echo $_smarty_tpl->tpl_vars['purchasing_url']->value;?>
"></iframe>
		</div>
		<div class="pane" id="history">
			<iframe class="tab_frame" src="<?php echo $_smarty_tpl->tpl_vars['history_url']->value;?>
"></iframe>
		</div>
	</div>	
</div>
<?php }} ?>