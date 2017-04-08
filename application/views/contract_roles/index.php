<div class="head_face" id="title">Role Manager</div>
<br/><br/>
<div class="container_16 grid_16 alpha omega">
    <div class="grid_1">&nbsp;</div>
    <div class="grid_14">
        <div id="search_container">
            <div class="grid_8 grid_left alpha" id="control_area">
                <button class="medium" id="button_add_role">Add New Role</button>
            </div>
            <div class="grid_2 size_10pt"><span class="right bottom"><span id="row_count"></span> item(s) found</span>
            </div>
            <div class="grid_3 omega">&nbsp;</div>
        </div>
        <div class="clear"></div>
        <!-- List loads into list_container via AJAX -->
        <div class="grid_12" id="contract_roles_list_container"></div>
    </div>
    <div class="grid_1">&nbsp;</div>
</div>
<div id="contract_roles_detail">
    <br/>
    <form name="role_detail">
        <input type="hidden" id="role_id" name="role_id" value=""/>
        <div class="grid_6 pad_left_8">
            <div class="grid_4 bold size_10pt"><span class="right">First Name:</span></div>
            <div class="grid_4 left size_10pt pad_bottom_5 alpha omega">
                <input id="first_name" name="first_name" value=""/>
            </div>
            <div class="clear">&nbsp;</div>
            <div class="grid_4 bold size_10pt"><span class="right">Last Name:</span></div>
            <div class="grid_4 left size_10pt pad_bottom_5 alpha omega">
                <input id="last_name" name="last_name" value=""/>
            </div>
            <div class="clear">&nbsp;</div>
            <div class="grid_4 bold size_10pt"><span class="right">Email:</span></div>
            <div class="grid_4 left size_10pt pad_bottom_5 alpha omega">
                <input id="email" name="email" value=""/>
            </div>
            <div class="clear">&nbsp;</div>
            <div class="clear">&nbsp;</div>
            <div class="grid_4 bold size_10pt"><span class="right">Role:</span></div>
            <div class="grid_4 left size_10pt pad_bottom_5 alpha omega">
                <select id="role" name="role">
                    <option value="tech">Technician</option>
                    <option value="rep">Representative</option>
                    <option value="crew">Crew</option>
                </select>
            </div>
            <div class="clear">&nbsp;</div>
        </div>
    </form>
    <div class="grid_4 right">
        <button class="wide_button" id="button_update_role">Update</button>
        <button class="wide_button" id="button_remove_role">Remove</button>
        <br/>
    </div>
</div>

<div id="add_role_dialog" class="grid_16">
    <form name="add_role">
    <div class="grid_4 left size_10pt pad_bottom_5 alpha omega">
        <label class="grid_4 bold size_10pt"><span class="right">First Name:</span></label>
        <input id="first_name" name="first_name" value=""/>
    </div>
    <div class="clear">&nbsp;</div>
    <div class="grid_4 left size_10pt pad_bottom_5 alpha omega">
        <label class="grid_4 bold size_10pt"><span class="right">Last Name:</span></label>
        <input id="last_name" name="last_name" value=""/>
    </div>
    <div class="clear">&nbsp;</div>
    <div class="grid_4 left size_10pt pad_bottom_5 alpha omega">
        <label class="grid_4 bold size_10pt"><span class="right">Email:</span></label>
        <input id="email" name="email" value=""/>
    </div>
    <div class="clear">&nbsp;</div>
    <div class="grid_4 left size_10pt pad_bottom_5 alpha omega">
        <label class="grid_4 bold size_10pt"><span class="right">Role:</span></label>
        <select id="role" name="role">
            <option value="">(select)</option>
            <option value="tech">Technician</option>
            <option value="rep">Representative</option>
            <option value="crew">Crew</option>
        </select>
    </div>
    </form>
</div>

<!-- End of File /application/views/contract_roles/contract_roles.php -->