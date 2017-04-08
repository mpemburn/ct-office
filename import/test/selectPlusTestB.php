<!DOCTYPE html>
<html lang="">
	<head>
	
	
<!--<link rel="stylesheet" href="http://localhost/hslanj.com/css/reset.css" type="text/css" media="screen" />-->
<link rel="stylesheet" href="http://localhost/hslanj.com/css/template.css" type="text/css" media="screen" />
<!-- Dynamically assigned stylesheets from module controller -->


<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script type="text/javascript" src="http://localhost/hslanj.com/js/jquery.ui.core.js"></script>
<!-- Dynamically assigned scripts from module controller -->
<script type="text/javascript">

</script>
<script type="text/javascript" src="http://localhost/hslanj.com/js/jquery.select_plus.js"></script>

	<title></title>
</head>
<body>
<style>
#fooo, #bar {
	background-color: cyan;
	width: 200px;
	height: 25px;
}
</style>
	<div id="fooo">
		FOOOOOO!
	</div>
	<form>
		<div class="form_cell">
			<div class="form_label">
				Things
			</div>
			<div class="form_field">
				<select id="thing" name="thing">
					<option value="1">Thing 1</option>
					<option value="2">Thing 2</option>
				</select>
			</div>
		</div>
	</form>
	<div id="bar">
		BAR!
	</div>
<script>

$(document).ready(function() {
	$("#thing").selectPlus();
	$("#fooo").position({
		my: "left top",
		at: "left bottom",
		of: $("#bar")
	});
	//alert("Sjoepg");
});

</script>	
</body>
</html>