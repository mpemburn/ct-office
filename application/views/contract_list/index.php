<div class="head_face" id="title">List of Submitted Contracts</div>
<br /><br />
<div class="container_16 grid_16 alpha omega">
	<div class="grid_1">&nbsp;</div>
	<div class="grid_14">
		<div id="search_container">
			<div class="grid_8 grid_left alpha" id="control_area">
				<input type="text" id="contract_search" class="search" title="Enter search terms" autocomplete="off">
				Starting: <input type="text" id="start_date">
				Ending: <input type="text" id="end_date">
			</div>
			<div class="grid_2 size_10pt"><span class="right bottom"><span id="row_count"></span> item(s) found</span></div>
			<div class="grid_3 omega">&nbsp;</div>
		</div>
		<div class="clear"></div>
		<!-- List loads into list_container via AJAX -->
		<div class="grid_12" id="contract_list_container"></div>
	</div>
	<div class="grid_1">&nbsp;</div>
</div>
<div id="contract_list_detail">
	<br />
	<div class="grid_6 pad_left_10">
		<div class="grid_2 bold size_10pt"><span class="right">Date:</span></div>
		<div id="time_stamp" class="grid_4 left size_10pt pad_bottom_5 alpha omega"></div>
		<div class="clear">&nbsp;</div>
		<div class="grid_6 bold size_12pt left pad_bottom_5"><span class="right">Residence Address:</span></div>
		<div class="clear">&nbsp;</div>
		<div class="grid_2 bold size_10pt"><span class="right">Name:</span></div>
		<div class="grid_4 left size_10pt pad_bottom_5 alpha omega">
			<span id="residence_customer_name"></span>
		</div>
		<div class="clear">&nbsp;</div>
		<div class="grid_2 bold size_10pt"><span class="right">Phone:</span></div>
		<div id="residence_phone" class="grid_4 left size_10pt pad_bottom_5 alpha omega"></div>
		<div class="clear">&nbsp;</div>
		<div class="grid_2 bold size_10pt"><span class="right">Email:</span></div>
		<div id="customer_email" class="grid_4 left size_10pt pad_bottom_5 alpha omega"></div>
		<div class="clear">&nbsp;</div>
		<div class="grid_2 bold size_10pt"><span class="right">Address:</span></div>
		<div class="grid_4 left size_10pt alpha omega">
			<div id="residence_street_address"></div>
			<span id="residence_city"></span> <span id="residence_state"></span>, <span id="residence_zip"></span>
		</div>
		<div class="clear">&nbsp;</div>
		<br />
	</div>
	<div class="grid_6 left">
		<div class="grid_6 bold size_10pt"><span class="right">&nbsp;</span></div>
		<div class="clear">&nbsp;</div>
		<div class="grid_6 bold size_12pt left pad_bottom_5"><span class="right">Billing Address:</span></div>
		<div class="clear">&nbsp;</div>
		<div class="grid_2 bold size_10pt"><span class="right">Name:</span></div>
		<div class="grid_4 left size_10pt pad_bottom_5 alpha omega">
			<span id="billing_customer_name"></span>
		</div>
		<div class="clear">&nbsp;</div>
		<div class="grid_2 bold size_10pt"><span class="right">Phone:</span></div>
		<div id="billing_phone" class="grid_4 left size_10pt pad_bottom_5 alpha omega"></div>
		<div class="clear">&nbsp;</div>
		<div class="grid_2 bold size_10pt"><span class="right">Address:</span></div>
		<div class="grid_4 left size_10pt alpha omega">
			<div id="billing_street_address"></div>
			<span id="billing_city"></span> <span id="billing_state"></span>, <span id="billing_zip"></span>
		</div>
		<div class="clear">&nbsp;</div>
		<br />
	</div>
	<div class="grid_1 left">
		<div class="grid_6 bold size_8pt"><span class="right">Attachment:</span></div>
		<div class="clear">&nbsp;</div>
		<div class="grid_6 bold size_8pt"><span class="right"><a id="pdf_name" href=""><img id="image_pdf_name" src="{$pdf_image}" /></a></span></div>
		<div class="clear">&nbsp;</div>
		<br />
	</div>
</div> 
<!-- End of File /application/views/contract_list/contract_list.php -->