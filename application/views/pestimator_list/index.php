<div class="head_face" id="title">Pestimator List</div>
<br /><br />
<div class="container_16">
	<div class="grid_2">&nbsp;</div>
	<div class="grid_14">
		<div id="search_container">
			<div class="grid_8 grid_left alpha" id="control_area">
				<input type="text" id="pestimator_search" class="search" title="Enter search terms" autocomplete="off">
				Starting: <input type="text" id="start_date">
				Ending: <input type="text" id="end_date">
			</div>
			<div class="grid_2 size_10pt"><span class="right bottom"><span id="row_count"></span> item(s) found</span></div>
			<div class="grid_3 omega">&nbsp;</div>
		</div>
		<div class="clear"></div>
		<!-- List loads into list_container via AJAX -->
		<div class="grid_14 alpha" id="pestimator_list_container"></div>
	</div>
</div>
<div id="pestimator_list_detail" class="grid_13">
	<br />
	<div class="grid_7 pad_left_10">
		<div class="grid_2 bold size_10pt"><span class="right">Date:</span></div>
		<div id="estimate_datetime" class="grid_4 left size_10pt pad_bottom_5 alpha omega"></div>
		<div class="clear">&nbsp;</div>
		<div class="grid_2 bold size_10pt"><span class="right">Name:</span></div>
		<div class="grid_4 left size_10pt pad_bottom_5 alpha omega">
			<span id="estimate_first_name"></span> <span id="estimate_last_name"></span>
		</div>
		<div class="clear">&nbsp;</div>
		<div class="grid_2 bold size_10pt"><span class="right">Email:</span></div>
		<div id="estimate_email" class="grid_4 left size_10pt pad_bottom_5 alpha omega"></div>
		<div class="clear">&nbsp;</div>
		<div class="grid_2 bold size_10pt"><span class="right">Address:</span></div>
		<div class="grid_4 left size_10pt alpha omega">
			<div id="estimate_address1"></div>
			<div id="estimate_address2"></div>
			<span id="estimate_city"></span> <span id="estimate_state"></span>, <span id="estimate_zip"></span>
		</div>
		<div class="clear">&nbsp;</div>
		<br />
	</div>
	<div class="grid_4 left">
		<div class="grid_2 bold size_10pt"><span class="right">Estimate:</span></div>
		<div id="estimate_dollars" class="grid_4 left size_10pt pad_bottom_5 alpha omega"></div>
		<div class="clear">&nbsp;</div>
		<div class="grid_2 bold size_10pt"><span class="right">Pests:</span></div>
		<div id="estimate_pests" class="grid_4 left size_10pt alpha omega"></div>
	</div>
</div> 
 <!-- End of File /application/views/pestimator_list/pestimator_list.php -->