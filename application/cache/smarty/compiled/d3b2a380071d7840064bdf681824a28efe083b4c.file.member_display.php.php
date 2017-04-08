<?php /* Smarty version Smarty-3.1.1, created on 2012-02-27 11:47:04
         compiled from "application/views/members/member_display.php" */ ?>
<?php /*%%SmartyHeaderCode:4644397274f25549c02d504-81471004%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd3b2a380071d7840064bdf681824a28efe083b4c' => 
    array (
      0 => 'application/views/members/member_display.php',
      1 => 1330361190,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4644397274f25549c02d504-81471004',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.1',
  'unifunc' => 'content_4f25549c250be',
  'variables' => 
  array (
    'member_info' => 0,
    'system_name' => 0,
    'state' => 0,
    'membership_year' => 0,
    'membership_types' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_4f25549c250be')) {function content_4f25549c250be($_smarty_tpl) {?><div class="page_margins">
	<div class="container_16">
		<form id="member_form" name="member_form">
			<input type="hidden" id="member_id" name="member_id" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['member_id'];?>
">
			<input type="hidden" id="contact_id" name="contact_id" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['contact_id'];?>
">
			<input type="hidden" id="is_active" name="is_active" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['is_active'];?>
">
			<input type="hidden" id="Degrees" name="Degrees" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['Degrees'];?>
">
			<input type="hidden" id="MemberTypeID2003" name="MemberTypeID2003" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['MemberTypeID2003'];?>
">
			<input type="hidden" id="MemberTypeID2004" name="MemberTypeID2004" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['MemberTypeID2004'];?>
">
			<input type="hidden" id="MemberTypeID2005" name="MemberTypeID2005" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['MemberTypeID2005'];?>
">
			<input type="hidden" id="MemberTypeID2006" name="MemberTypeID2006" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['MemberTypeID2006'];?>
">
			<input type="hidden" id="MemberTypeID2007" name="MemberTypeID2007" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['MemberTypeID2007'];?>
">
			<input type="hidden" id="page_number" name="page_number" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['page_number'];?>
">
			<div class="grid_16" id="control_strip">
				<div class="circle" id="status"></div>
				<button class="ui-button" id="button_edit_save">Save</button>&nbsp;&nbsp;
			</div>
			<div class="clear"></div>
			<div class="grid_8" id="column_1">
				<div class="grid_3 form_label">
					Facility Name
				</div>
				<div class="grid_4 form_field">
					<input id="member_name" name="member_name" class="extra_long_text" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['member_name'];?>
">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					System Name
				</div>
				<div class="grid_4 form_field">
					<?php echo $_smarty_tpl->tpl_vars['system_name']->value;?>

				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Address
				</div>
				<div class="grid_4 form_field">
					<input id="address_1" name="address_1" class="long_text" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['address_1'];?>
">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					&nbsp;
				</div>
				<div class="grid_4 form_field">
					<input id="address_2" name="address_2" class="long_text" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['address_2'];?>
">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					City, State, Zip
				</div>
				<div class="grid_4 csz_field">
					<input id="city"  name="city" class="text" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['city'];?>
"> <?php echo $_smarty_tpl->tpl_vars['state']->value;?>
 <input id="zip" name="zip" class="zip_plus" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['zip'];?>
">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					County
				</div>
				<div class="grid_4 form_field">
					<input id="county" name="county" class="text" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['county'];?>
">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Membership
				</div>
				<div class="grid_4 form_field">
					<?php echo $_smarty_tpl->tpl_vars['membership_year']->value;?>

					<button class="lil_button" id="button_add_membership">Add</button>
					<div id="member_year_list"></div>
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Library Website
				</div>
				<div class="grid_4 form_field">
					<input id="library_website" name="library_website" class="long_text" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['library_website'];?>
">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Institutional Website
				</div>
				<div class="grid_4 form_field">
					<input id="institutional_website" name="institutional_website" class="long_text" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['institutional_website'];?>
">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Comments
				</div>
				<div class="grid_4 form_field">
					<textarea class="note_area" id="notes" name="notes"><?php echo $_smarty_tpl->tpl_vars['member_info']->value['notes'];?>
</textarea>
				</div>
			</div>
			<div class="grid_8" id="column_2">
				<div class="grid_3 form_label">
					Primary Contact
				</div>
				<div class="grid_4 form_field">
					<input id="primary_contact_name" name="primary_contact_name" class="long_text" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['primary_contact_name'];?>
">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Email
				</div>
				<div class="grid_4 form_field">
					<input id="email" name="email" class="long_text" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['email'];?>
">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Phone
				</div>
				<div class="grid_4 form_field">
					<input id="phone" name="phone" class="text" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['phone'];?>
">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Fax
				</div>
				<div class="grid_4 form_field">
					<input id="fax" name="fax" class="text" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['fax'];?>
">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					IP Addresses
				</div>
				<div class="grid_4 form_field">
					<textarea class="ip_area" id="ip_addresses" name="ip_addresses"><?php echo $_smarty_tpl->tpl_vars['member_info']->value['ip_addresses'];?>
</textarea>
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Consortia
				</div>
				<div class="grid_4 form_field">
					<input id="consortia" name="consortia" class="text" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['consortia'];?>
">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Beds
				</div>
				<div class="grid_4 form_field">
					<input id="beds" name="beds" class="text" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['beds'];?>
">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					AHIPID
				</div>
				<div class="grid_4 form_field">
					<input id="AHIPID" name="AHIPID" class="text" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['AHIPID'];?>
">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					CHIS
				</div>
				<div class="grid_4 form_field">
					<input id="CHIS" name="CHIS" class="text" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['CHIS'];?>
">
				</div>
			</div>
			<!-- Entry panel for membership -->
			<div class="grid_5" id="membership_add">
				<div class="grid_4">
					<?php echo $_smarty_tpl->tpl_vars['membership_types']->value;?>

					<span class="form_label">$</span>
					<input id="membership_dues_paid" name="membership_dues_paid" class="small" type="text" value="" />
					<button class="ui-button lil_button" id="button_membership_save">Save</button>
				</div>
				<div class="clear"></div>
				<div class="grid_4">
					<br />
					<span class="form_label">Billed:</span>
					<span class="form_field"><input id="membership_date_billed" name="membership_date_billed" class="medium" type="text" value="" /></span>
					&nbsp;&nbsp;
					<span class="form_label">Paid:</span>
					<span class="form_field"><input id="membership_date_paid" name="membership_date_paid" class="medium" type="text" value="" /></span>
				</div>
				<input type="hidden" id="membership_tally_id" name="membership_tally_id" value="0">
			</div>
			<!-- Parser for contact full name -->
			<div class="grid_4" id="contact_parse">
				<input id="contact_prefix" name="contact_prefix" class="narrow" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['contact_prefix'];?>
">
				<input id="contact_first_name" name="contact_first_name" class="medium" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['contact_first_name'];?>
">
				<input id="contact_middle_name" name="contact_middle_name" class="narrow" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['contact_middle_name'];?>
">
				<input id="contact_last_name" name="contact_last_name" class="medium" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['contact_last_name'];?>
">
				<input id="contact_suffix" name="contact_suffix" class="narrow" type="text" value="<?php echo $_smarty_tpl->tpl_vars['member_info']->value['contact_suffix'];?>
">
			</div>
		</form>
	</div>
</div>

<?php }} ?>