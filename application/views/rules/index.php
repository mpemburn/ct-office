<script type="text/javascript">
{$js_vars}	
</script>
{$css}
{$scripts}
<div id="container">
	<div id="vspace"></div>
	<div id="resource_heading"></div>
	<div id="form_container">
		<div id="list_container">
			<select id="vendor_list">
				{foreach $vendors as $vendor}
				    <option value="{$vendor.vendor_id}">{$vendor.vendor_name}</option>
				{/foreach}
				<!--<?php foreach ($vendors as $vendor): ?>
					<option value="{$vendor['vendor_id']}">{$vendor['vendor_name']}</option>
				<?php endforeach ?>-->
			</select>
			<img class="arrow" src="{$back_arrow}" id="prev">
			<select id="vendor_resource_list">
			</select>
			<img class="arrow" src="{$fwd_arrow}" id="next">
			<img class="arrow" src="{$back_arrow}" id="prev_subcat">
			<select id="subcategory_list">
			</select>
			<img class="arrow" src="{$fwd_arrow}" id="next_subcat">
			<img id="wait" src="{$spinner}">
			<input type="hidden" id="current_id" value="">
			<input type="hidden" id="current_subcat_id" value="">
		</div>
		<div id="years_container">
			Fiscal Year <select id="years"></select>
		</div>
	</div>
	<div id="rules_container"></div>
</div>
