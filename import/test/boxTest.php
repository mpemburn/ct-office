<!DOCTYPE html>
<html lang="">
	<head>

<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery.ui.all.css" />
<link rel="stylesheet" href="http://192.168.0.198/hslanj.com/css/template.css" type="text/css" media="screen" />
<link rel="stylesheet" href="http://192.168.0.198/hslanj.com/css/colorbox.css" type="text/css" media="screen" />

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script>
<!-- Dynamically assigned scripts from module controller -->
<script type="text/javascript" src="http://192.168.0.198/hslanj.com/js/jquery.colorbox.min.js"></script>

		<meta http-equiv="content-type" content="text/html; charset=">
		<title></title>
	</head>
	<body>
	</body>

<script>
function show_detail() {
	$("body").css("overflow", "hidden");
	$.colorbox({
		iframe: true,
		scrolling: false,
		width: '95%',
		height: '90%',
		speed: 100,
		href: 'tabTestB.php',
		onClosed: function()	{
			$("body").css("overflow", "auto");
		}
	});
}

$(document).ready(function() {
	show_detail();
});
</script>	

</html>