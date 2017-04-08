<?php /* Smarty version Smarty-3.1.1, created on 2012-02-01 12:15:03
         compiled from "application/views/members/history.php" */ ?>
<?php /*%%SmartyHeaderCode:18654442004f25bb26a93d01-73793163%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0ce56b018862cabe233ec64c8ed76cdd82e5d6f7' => 
    array (
      0 => 'application/views/members/history.php',
      1 => 1328115507,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18654442004f25bb26a93d01-73793163',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_4f25bb26abe35',
  'variables' => 
  array (
    'js_vars' => 0,
    'css' => 0,
    'scripts' => 0,
    'clear_x' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f25bb26abe35')) {function content_4f25bb26abe35($_smarty_tpl) {?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="">
	<head>
<script type="text/javascript">
<?php echo $_smarty_tpl->tpl_vars['js_vars']->value;?>

</script>
<?php echo $_smarty_tpl->tpl_vars['css']->value;?>

<?php echo $_smarty_tpl->tpl_vars['scripts']->value;?>

	<meta http-equiv="content-type" content="text/html; charset=" />
	<title></title>
</head>
<body>
<div id="detail_title">Change History</div>
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
</body>
<script>

function show_detail(audit_id, $cell) {
	$.ajax({ 
		url: auditlog_ajax_url,
		type: 'POST',
		data: "type=GET_log_entry&audit_id=" + audit_id,
		success: function(data) {
			var dataObj = $.parseJSON(data);
			var log_entry = dataObj.log_entry;
			var delta = dataObj.delta;
			var cell_data = build_log_cell(audit_id,log_entry.field_label,log_entry.change_from,log_entry.change_to,delta);
			$("#show_delta_" + audit_id).die("click");
			$cell.html(cell_data);
			$("#delta_" + audit_id).css({ display : 'none' });
			$("#show_delta_" + audit_id).live("click", function() {
				var $delta = $("#delta_" + audit_id);
				var $to_from = $("#to_from_" + audit_id);
				var display = $delta.css("display");
				var toggle_delta = (display == "none") ? "block" : "none"
				var toggle_to_from = (display == "none") ? "none" : "block"
				var d_color = (display == "none") ? "gray" : "blue"
				$delta.css({ display : toggle_delta });
				$to_from.css({ display : toggle_to_from });
				$(this).css({ color : d_color });
			});
		}

	});
	
}

function build_log_cell(audit_id, field_name, change_from, change_to, delta) {
	var cell = "";
	var field_text = "<div class='log_field'>" + field_name + " &mdash;</div>";
	var delta_text = ""
	var to_from = "<div id='to_from_" + audit_id + "'>";
	to_from += "<div class='log_change_from'><strong>From: </strong>" + change_from + "</div>";
	to_from += "<div class='log_change_to'><strong>To: </strong>" + change_to + "</div>";
	to_from += "</div>";
	if (delta != null) {
		delta_text += "<div id='delta_" + audit_id + "' class='log_delta'>" + delta + "</div>";
		field_text = field_text.replace("</div>","<span id='show_delta_" + audit_id + "' class='show_delta'> &Delta;</span></div>");
	}
	cell = field_text + to_from + delta_text;
	return cell;
}

function on_data (record_count) {
	$("#history_container").css({ display : 'block' });
}

$(document).ready(function() {

var listManager = new ListManager({
	ajax_url: auditlog_ajax_url,
	accordion: true,
	default_sort: "change_date DESC",
	query_string: "table_name=site_members&key_field=member_id&key_value=" + member_id,
	detail_callback: show_detail,
	on_data_callback: on_data
});


});

</script>
</html><?php }} ?>