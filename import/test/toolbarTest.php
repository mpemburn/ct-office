
<!doctype html>
<html>
  <head>
    <meta charset="UTF-8" />
    <title>jQuery Mobile in a iScroll Plugin: Demo</title>
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.css"/>
    <script src="http://code.jquery.com/jquery-1.4.4.min.js"></script>
    <script src="http://code.jquery.com/mobile/1.0a3/jquery.mobile-1.0a3.min.js"></script>
    <script src="http://cubiq.org/dropbox/iscroll/iscroll.js?v3.7.1"></script>
    <script src="https://github.com/yappo/javascript-jquery.mobile.iscroll/raw/master/jquery.mobile.iscroll.js"></script>
  </head>
  <body>
    <div data-role="page" data-iscroll="enable" id="home">

      <div data-role="header">
	<h1>INDEX PAGE</h1>
      </div>

      <div data-role="content">
	<div data-iscroll="scroller">
          <ol data-role="listview">
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>foo</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	    <li>bar</li>
	  </ol>
	</div>
      </div>

      <div data-role="footer" class="ui-bar">
	<div data-role="navbar" class="ui-navbar">
	  <ul class="ui-grid-b">
	    <li class="ui-block-a"><a href="#home">home</a></li>
	    <li class="ui-block-b"><a href="#timeline">timeline</a></li>
	    <li class="ui-block-c"><a href="#message">message</a></li>
	    <li class="ui-block-d"><a href="#bookmark">bookmark</a></li>
	    <li class="ui-block-e"><a href="#config">config</a></li>
	  </ul>
	</div>
      </div>

    </div>
  </body>
</html>
<script>
$(document).ready(function() {
	$(window).bind('orientationchange', function(e) {
		var thePage = document.location;
		document.location = thePage;
		//alert("swap");
		//fixed($.mobile.activePage);
	});
	
	$(document).bind("mobileinit", function(){
		$.mobile.touchOverflowEnabled = true;
	});
});	
</script>
