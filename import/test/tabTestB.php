<!DOCTYPE html>
<html lang="">
<head>
	<meta http-equiv="content-type" content="text/html; charset=">
<!--<link rel="stylesheet" href="http://192.168.0.198/hslanj.com/css/reset.css" type="text/css" media="screen" />-->
<link rel="stylesheet" type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery.ui.all.css" />
<link rel="stylesheet" href="http://192.168.0.198/hslanj.com/css/template.css" type="text/css" media="screen" />
<!-- Dynamically assigned stylesheets from module controller -->
<link rel="stylesheet" href="http://192.168.0.198/hslanj.com/css/app/members.css" type="text/css" media="screen" />

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.js"></script>
<!-- Dynamically assigned scripts from module controller -->
<script type="text/javascript">
var members_ajax_url = "http://192.168.0.198/hslanj.com/members/ajax_members_manager";
var image_path = "http://192.168.0.198/hslanj.com/images";


</script>
<script type="text/javascript" src="http://192.168.0.198/hslanj.com/js/jquery.ui.core.js"></script>

	<title></title>
</head>
<body>
<style>
html, body, iframe {
	font-family: Arial, sans-serif;
	width: 100%;
	height: 100%;
	margin: 0;
	padding: 0;
}

.tab_frame, .panes, .pane {
	border: none;
	width: 95%;
	height: 85%;
}

</style>

<div id="detail_title">Alfred I duPont Hospital for Children of the Nemours Foundation</div>

<div id="member_tabs" style="min-height: 95%;">
	<!-- the tabs -->
	<ul>
		<li id="tab_general"><a href="#general">General</a></li>
		<li id="tab_purchases"><a href="#notes">Notes</a></li>
		<li id="tab_purchases"><a href="#purchases">Purchases</a></li>
		<li id="tab_history"><a href="#history">History</a></li>

	</ul>
	
	<!-- tab "panes" -->
	<div class="panes">
		<div class="pane" id="general">
			<iframe class="tab_frame" src="http://192.168.0.198/hslanj.com/members/member_display/1"></iframe>
		</div>
		<div class="pane" id="notes">
			<iframe class="tab_frame" src="http://192.168.0.198/hslanj.com/members/member_notes/1"></iframe>

		</div>
		<div class="pane" id="purchases">
			<iframe class="tab_frame" src="http://192.168.0.198/hslanj.com/members/purchasing/1"></iframe>
		</div>
		<div class="pane" id="history">
			<iframe class="tab_frame" src="http://192.168.0.198/hslanj.com/members/history/1"></iframe>
		</div>
	</div>	

</div>
</body>

<script>
$(document).ready(function() {
	$("#member_tabs").tabs();
});
</script>	

</html>