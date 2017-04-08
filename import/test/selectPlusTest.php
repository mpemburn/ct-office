<!DOCTYPE html>
<html lang="">
	<head>
<link rel="stylesheet" href="http://localhost/hslanj.com/css/template.css" type="text/css" media="screen" />
<link rel="stylesheet" href="http://localhost/hslanj.com/css/app/form.css" type="text/css" media="screen" />

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>

<script type="text/javascript" src="http://localhost/hslanj.com/js/jquery.ui.core.js"></script>
<script type="text/javascript" src="../js/jquery.select_plus.js"></script>
		<meta http-equiv="content-type" content="text/html; charset=">
		<title></title>
	</head>
	<body>
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
	</body>

<script>
$(document).ready(function() {
	$("#fooo").position({
		my: "left top",
		at: "left bottom",
		of: $("#bar")
	});
	$("#thing").selectPlus();
});
</script>	

</html>