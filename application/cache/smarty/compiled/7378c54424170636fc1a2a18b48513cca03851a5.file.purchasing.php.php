<?php /* Smarty version Smarty-3.1.1, created on 2012-02-09 11:42:53
         compiled from "application/views/members/purchasing.php" */ ?>
<?php /*%%SmartyHeaderCode:18654442004f25bb26b9bff0-33000575%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7378c54424170636fc1a2a18b48513cca03851a5' => 
    array (
      0 => 'application/views/members/purchasing.php',
      1 => 1328805770,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18654442004f25bb26b9bff0-33000575',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_4f25bb26bb8a5',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f25bb26bb8a5')) {function content_4f25bb26bb8a5($_smarty_tpl) {?><style>
#fooo, #bar {
	background-color: cyan;
	width: 200px;
	height: 25px;
}
</style>
	<div id="fooo">
		FOOOOOO!
	</div>
	<form>
		<div class="form_cell">
			<div class="form_label">
				Things
			</div>
			<div class="form_field">
				<select id="thing" name="thing">
					<option value="1">Thing 1</option>
					<option value="2">Thing 2</option>
				</select>
			</div>
		</div>
	</form>
	<div id="bar">
		BAR!
	</div>
<script>

$(document).ready(function() {
	$("#thing").selectPlus();
	$("#fooo").position({
		my: "left top",
		at: "left bottom",
		of: $("#bar")
	});
	//alert("Sjoepg");
});

</script>	
<?php }} ?>