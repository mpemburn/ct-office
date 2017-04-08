$(document).ready(function() {
	var popIsShowing = false;
	
	$("#new_contract").popover({
		title: "Contracts",
		fadeSpeed: 500,
		verticalOffset: 15,
		content: $("#contract_links").html()
	});
	$("#new_contract").bind('click touch', function () {
		if (!popIsShowing) {
			$(this).popover('show');
			popIsShowing = true;
		} else {
			$(this).popover('fadeOut');
			popIsShowing = false;
		}
	});
	
});