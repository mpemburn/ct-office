<div class="page_margins">
	<div class="container_16">
		<form id="member_form" name="member_form">
			<input type="hidden" id="member_id" name="member_id" value="{$member_info.member_id}">
			<input type="hidden" id="contact_id" name="contact_id" value="{$member_info.contact_id}">
			<input type="hidden" id="is_active" name="is_active" value="{$member_info.is_active}">
			<input type="hidden" id="Degrees" name="Degrees" value="{$member_info.Degrees}">
			<input type="hidden" id="MemberTypeID2003" name="MemberTypeID2003" value="{$member_info.MemberTypeID2003}">
			<input type="hidden" id="MemberTypeID2004" name="MemberTypeID2004" value="{$member_info.MemberTypeID2004}">
			<input type="hidden" id="MemberTypeID2005" name="MemberTypeID2005" value="{$member_info.MemberTypeID2005}">
			<input type="hidden" id="MemberTypeID2006" name="MemberTypeID2006" value="{$member_info.MemberTypeID2006}">
			<input type="hidden" id="MemberTypeID2007" name="MemberTypeID2007" value="{$member_info.MemberTypeID2007}">
			<input type="hidden" id="page_number" name="page_number" value="{$member_info.page_number}">
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
					<input id="member_name" name="member_name" class="extra_long_text" type="text" value="{$member_info.member_name}">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					System Name
				</div>
				<div class="grid_4 form_field">
					{$system_name}
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Address
				</div>
				<div class="grid_4 form_field">
					<input id="address_1" name="address_1" class="long_text" type="text" value="{$member_info.address_1}">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					&nbsp;
				</div>
				<div class="grid_4 form_field">
					<input id="address_2" name="address_2" class="long_text" type="text" value="{$member_info.address_2}">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					City, State, Zip
				</div>
				<div class="grid_4 csz_field">
					<input id="city"  name="city" class="text" type="text" value="{$member_info.city}"> {$state} <input id="zip" name="zip" class="zip_plus" type="text" value="{$member_info.zip}">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					County
				</div>
				<div class="grid_4 form_field">
					<input id="county" name="county" class="text" type="text" value="{$member_info.county}">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Membership
				</div>
				<div class="grid_4 form_field">
					{$membership_year}
					<button class="lil_button" id="button_add_membership">Add</button>
					<div id="member_year_list"></div>
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Library Website
				</div>
				<div class="grid_4 form_field">
					<input id="library_website" name="library_website" class="long_text" type="text" value="{$member_info.library_website}">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Institutional Website
				</div>
				<div class="grid_4 form_field">
					<input id="institutional_website" name="institutional_website" class="long_text" type="text" value="{$member_info.institutional_website}">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Comments
				</div>
				<div class="grid_4 form_field">
					<textarea class="note_area" id="notes" name="notes">{$member_info.notes}</textarea>
				</div>
			</div>
			<div class="grid_8" id="column_2">
				<div class="grid_3 form_label">
					Primary Contact
				</div>
				<div class="grid_4 form_field">
					<input id="primary_contact_name" name="primary_contact_name" class="long_text" type="text" value="{$member_info.primary_contact_name}">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Email
				</div>
				<div class="grid_4 form_field">
					<input id="email" name="email" class="long_text" type="text" value="{$member_info.email}">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Phone
				</div>
				<div class="grid_4 form_field">
					<input id="phone" name="phone" class="text" type="text" value="{$member_info.phone}">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Fax
				</div>
				<div class="grid_4 form_field">
					<input id="fax" name="fax" class="text" type="text" value="{$member_info.fax}">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					IP Addresses
				</div>
				<div class="grid_4 form_field">
					<textarea class="ip_area" id="ip_addresses" name="ip_addresses">{$member_info.ip_addresses}</textarea>
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Consortia
				</div>
				<div class="grid_4 form_field">
					<input id="consortia" name="consortia" class="text" type="text" value="{$member_info.consortia}">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					Beds
				</div>
				<div class="grid_4 form_field">
					<input id="beds" name="beds" class="text" type="text" value="{$member_info.beds}">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					AHIPID
				</div>
				<div class="grid_4 form_field">
					<input id="AHIPID" name="AHIPID" class="text" type="text" value="{$member_info.AHIPID}">
				</div>
				<div class="clear"></div>
				<div class="grid_3 form_label">
					CHIS
				</div>
				<div class="grid_4 form_field">
					<input id="CHIS" name="CHIS" class="text" type="text" value="{$member_info.CHIS}">
				</div>
			</div>
			<!-- Entry panel for membership -->
			<div class="grid_5" id="membership_add">
				<div class="grid_4">
					{$membership_types}
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
				<input id="contact_prefix" name="contact_prefix" class="narrow" type="text" value="{$member_info.contact_prefix}">
				<input id="contact_first_name" name="contact_first_name" class="medium" type="text" value="{$member_info.contact_first_name}">
				<input id="contact_middle_name" name="contact_middle_name" class="narrow" type="text" value="{$member_info.contact_middle_name}">
				<input id="contact_last_name" name="contact_last_name" class="medium" type="text" value="{$member_info.contact_last_name}">
				<input id="contact_suffix" name="contact_suffix" class="narrow" type="text" value="{$member_info.contact_suffix}">
			</div>
		</form>
	</div>
</div>

