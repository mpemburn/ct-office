<?php /* Smarty version Smarty-3.1.1, created on 2012-04-05 07:34:08
         compiled from "application/views/app_form/document_template.php" */ ?>
<?php /*%%SmartyHeaderCode:8006542994f72e16fa79288-08912243%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b871a68ed65dda8ac3025446af541bab30f10c2b' => 
    array (
      0 => 'application/views/app_form/document_template.php',
      1 => 1333625643,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8006542994f72e16fa79288-08912243',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_4f72e16faf9fe',
  'variables' => 
  array (
    'contract_type' => 0,
    'document_identifier' => 0,
    'document_image' => 0,
    'no_really_image' => 0,
    'required_image' => 0,
    'loading_image' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f72e16faf9fe')) {function content_4f72e16faf9fe($_smarty_tpl) {?>	<div class="container_12">
		<form id="sigForm" method="post" action="" class="sigPad">
		<!-- The "output" field is used by the signature pad plugin to store the array of coordinates -->
		<input type="hidden" id="output" name="output" class="output" />
		<input type="hidden" id="signature_encrypted" name="signature_encrypted" />
		<input type="hidden" id="contract_id" name="contract_id" value="0" />
		<input type="hidden" id="contract_type" name="contract_type" value="<?php echo $_smarty_tpl->tpl_vars['contract_type']->value;?>
" />
		<input type="hidden" id="document_identifier" name="document_identifier" value="<?php echo $_smarty_tpl->tpl_vars['document_identifier']->value;?>
" />
		<input type="hidden" id="customer_email" name="customer_email" value="" />
		<input type="hidden" id="cc_encrypted" name="cc_encrypted" value="" />
		<input type="hidden" id="guid" name="guid" value="" />
		<div id="contract">
			<img id="contract_img" src="<?php echo $_smarty_tpl->tpl_vars['document_image']->value;?>
" width="100%">
		</div>
		<div id="sig_pad" class="grid_12" title="Customer Signature">
			<div class="grid_11 errorMsg right">
				<img id="no_really" src="<?php echo $_smarty_tpl->tpl_vars['no_really_image']->value;?>
">
				<img src="<?php echo $_smarty_tpl->tpl_vars['required_image']->value;?>
">Required fields need your attention.
			</div>
			<div class="clear"></div>
			<div class="container_12 grid_12" align="center">
				<div id="pleaseSign" class="label">Please sign below</div>
				<div class="sig sigWrapper">
					<canvas id="canvas" class="pad" width="600" height="95"></canvas>
				</div>
			</div>
			<button id="clearButton" class="clearButton">Clear</button>
			<div class="clear"></div>
			<div class="container_12 grid_12">
				<div id="pleaseEmail" class="label">Please enter your email address</div>
			</div>
			<div class="clear"></div>
			<div class="container_12 grid_12">
				<input id="signature_email" class="large" type="email" name="signature_email">
			</div>
			<div class="clear"></div>
			<div id="buttons" class="grid_10">
				<button id="closeButton">Close</button>
			</div>
			<div id="buttons" class="grid_2 right">
				<button id="formSubmit" type="button">I accept the terms<br /> of this agreement</button>
			</div>
		</div>
		</form>
	</div>
	<div id="loading" title="Please wait . . .">
		<br />
		<img id="loading_img" src="<?php echo $_smarty_tpl->tpl_vars['loading_image']->value;?>
">
	</div>
	<div id="width_test"></div><?php }} ?>