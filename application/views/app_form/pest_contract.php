	<div class="container_12">
		<form id="sigForm" method="post" action="" class="sigPad">
		<!-- The "output" field is used by the signature pad plugin to store the array of coordinates -->
		<input type="hidden" id="output" name="output" class="output" />
		<input type="hidden" id="signature_encrypted" name="signature_encrypted" />
		<input type="hidden" id="contract_id" name="contract_id" value="0" />
		<input type="hidden" id="contract_type" name="contract_type" value="{$contract_type}" />
		<input type="hidden" id="document_identifier" name="document_identifier" value="{$document_identifier}" />
		<input type="hidden" id="customer_email" name="customer_email" value="" />
		<input type="hidden" id="cc_encrypted" name="cc_encrypted" value="" />
		<input type="hidden" id="guid" name="guid" value="" />
		<div id="contract">
			<img id="contract_img" src="{$document_image}" width="100%">
		</div>
		<div id="sig_pad" class="grid_12" title="Customer Signature">
			<div class="grid_11 errorMsg right">
				<img id="no_really" src="{$no_really_image}">
				<img src="{$required_image}">Required fields need your attention.
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
		<img id="loading_img" src="{$loading_image}">
	</div>
