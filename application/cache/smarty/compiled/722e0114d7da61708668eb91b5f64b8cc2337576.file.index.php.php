<?php /* Smarty version Smarty-3.1.1, created on 2013-06-27 13:26:46
         compiled from "application/views/contact_us_list/index.php" */ ?>
<?php /*%%SmartyHeaderCode:82915450051c9f8e47cbec9-15282015%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '722e0114d7da61708668eb91b5f64b8cc2337576' => 
    array (
      0 => 'application/views/contact_us_list/index.php',
      1 => 1372354001,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '82915450051c9f8e47cbec9-15282015',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_51c9f8e480432',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_51c9f8e480432')) {function content_51c9f8e480432($_smarty_tpl) {?><div class="head_face" id="title">Messages from the "Contact Us" Page</div>
<br /><br />
<div class="container_16">
	<div class="grid_2">&nbsp;</div>
	<div class="grid_14">
		<div id="search_container">
			<div class="grid_8 grid_left alpha" id="control_area">
				<input type="text" id="contact_us_search" class="search" title="Enter search terms" autocomplete="off">
				Starting: <input type="text" id="start_date">
				Ending: <input type="text" id="end_date">
			</div>
			<div class="grid_2 size_10pt"><span class="right bottom"><span id="row_count"></span> item(s) found</span></div>
			<div class="grid_3 omega">&nbsp;</div>
		</div>
		<div class="clear"></div>
		<!-- List loads into list_container via AJAX -->
		<div class="grid_14 alpha" id="contact_us_list_container"></div>
	</div>
</div>
<div id="contact_us_list_detail">
	<br />
	<div class="grid_1 bold size_10pt">Date: </div>
	<div id="timestamp" class="grid_4 left size_10pt alpha omega"></div>
	<div class="grid_9 left">&nbsp;</div>
	<div class="clear"></div>
	<div class="grid_1 bold size_10pt">From: </div>
	<div id="message_name" class="grid_4 left size_10pt alpha omega"></div>
	<div class="grid_9 left">&nbsp;</div>
	<div class="clear"></div>
	<div class="grid_1 bold size_10pt">Email: </div>
	<div id="message_email" class="grid_4 left size_10pt alpha omega"></div>
	<div class="grid_9 left">&nbsp;</div>
	<div class="clear"></div>
	<div id="message_body" class="note_text"></div>
</div> 
<!-- End of File /application/views/contact_us_list/contact_us_list.php --><?php }} ?>