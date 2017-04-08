<?php /* Smarty version Smarty-3.1.1, created on 2012-03-13 12:46:34
         compiled from "application/views/office/index.php" */ ?>
<?php /*%%SmartyHeaderCode:9486159444f5f65979ed3a8-96708153%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3206d72eac291a95fdb38b928c91c5881c633f9e' => 
    array (
      0 => 'application/views/office/index.php',
      1 => 1331657184,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9486159444f5f65979ed3a8-96708153',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_4f5f65979eef1',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f5f65979eef1')) {function content_4f5f65979eef1($_smarty_tpl) {?><div class="head_face" id="title">Enter Code</div>
<div id="container">
	<div id="vspace"></div>
	<div class="container_12">
		<div class="grid_5"></div>
		<br /><br />
		<div class="clear"></div>
		<div class="container_12 grid_12" align="center"><input type="text" id="code" class="large" style="width: 40%" value="" /></div>
		<br />
		<div id="answer" class="container_12 grid_12" align="center"></div>
		<br />
		<div class="container_12 grid_12" align="center"><button id="go_submit" class="medium">Submit</button></div>
	</div>
	<div id="list_container"></div>		
</div>
<script type="text/javascript">
function decrypt(key, data) {
	var result = $.rc4DecryptStr(data, key);
	$("#answer").html("Result: " + result);
}

$(document).ready(function() {
	$("#go_submit").click(function () {
		$("#answer").html("");
		$.ajax({ 
			url: office_ajax_url,
			type: 'POST',
			data: "type=GET_key",
			success: function(data) {
				if (data.indexOf("SUCCESS") != -1) {
					var code = $("#code").val();
					var dataObj = $.parseJSON(data);
					decrypt(dataObj.data, code);
				} else {
					alert("There was an error retrieving the code.\nPlease contact Mark.");
				}
				return false;
			},
			error: function(e) {
				alert("Error: " + e.responseText);
				return false;
			}
		});
		
	});
});
</script><?php }} ?>