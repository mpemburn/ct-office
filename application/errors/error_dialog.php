<!DOCTYPE html>
<html lang="en">
<head>
<link href="<?php echo base_url(); ?>css/app/theme/ui-custom.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>css/login.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-ui-1.8.14.custom.min.js"></script>
<script>
$(document).ready(function() {
	var redirect = "<?php echo $redirect_url; ?>";
	
	$("#btn_continue").button({
		icons: { primary: 'ui-icon-play' }
	}).click(function() {
		document.location = redirect;
	});
});
</script>
<title>Error</title>
<style type="text/css">
#message, #continue {
	display: block;
	font-size: 12pt;
	margin-left: auto;
	margin-right: auto;
	padding-top: 20px;
	padding-bottom: 20px;
	text-align: center;
}
</style>
</head>
<body>
	<div id="content">
		<div id="heading">
			<h1><?php echo $heading; ?></h1>			
		</div>
		<div id="message">
			<?php echo $message; ?>			
		</div>
		<div id="continue">
			<button id="btn_continue" type="submit" class="cizacl_btn_check">Continue</button>			
		</div>
	</div>
</body>
</html>

<!--END OF FILE /application/errors/error_dialog.php -->