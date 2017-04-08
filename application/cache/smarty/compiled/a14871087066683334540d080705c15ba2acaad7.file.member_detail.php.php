<?php /* Smarty version Smarty-3.1.1, created on 2012-02-10 15:24:02
         compiled from "application/views/members/member_detail.php" */ ?>
<?php /*%%SmartyHeaderCode:20418170524f356856b9ae70-03563661%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a14871087066683334540d080705c15ba2acaad7' => 
    array (
      0 => 'application/views/members/member_detail.php',
      1 => 1328905393,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20418170524f356856b9ae70-03563661',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_4f356856bf4c1',
  'variables' => 
  array (
    'member_info' => 0,
    'member_display_url' => 0,
    'member_notes_url' => 0,
    'member_purchasing_url' => 0,
    'member_history_url' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f356856bf4c1')) {function content_4f356856bf4c1($_smarty_tpl) {?><div id="detail_title"><?php echo $_smarty_tpl->tpl_vars['member_info']->value['member_name'];?>
</div>

<div id="member_tabs">
	<!-- the tabs -->
	<ul class="tabs">
		<li id="tab_general"><a href="#general">General</a></li>
		<li id="tab_purchases"><a href="#notes">Notes</a></li>
		<li id="tab_purchases"><a href="#purchases">Purchases</a></li>
		<li id="tab_history"><a href="#history">History</a></li>
	</ul>
	
	<!-- tab "panes" -->
	<div class="panes">
		<div class="pane" id="general">
			<iframe class="tab_frame" src="<?php echo $_smarty_tpl->tpl_vars['member_display_url']->value;?>
" frameBorder="0"></iframe>
		</div>
		<div class="pane" id="notes">
			<iframe class="tab_frame" src="<?php echo $_smarty_tpl->tpl_vars['member_notes_url']->value;?>
" frameBorder="0"></iframe>
		</div>
		<div class="pane" id="purchases">
			<iframe class="tab_frame" src="<?php echo $_smarty_tpl->tpl_vars['member_purchasing_url']->value;?>
" frameBorder="0"></iframe>
		</div>
		<div class="pane" id="history">
			<iframe class="tab_frame" src="<?php echo $_smarty_tpl->tpl_vars['member_history_url']->value;?>
" frameBorder="0"></iframe>
		</div>
	</div>	
</div>
<?php }} ?>