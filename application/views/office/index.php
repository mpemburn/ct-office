<div class="head_face" id="title">Enter Code</div>
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
</script>