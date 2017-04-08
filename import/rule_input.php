<!DOCTYPE html>
<html lang="">
<head>
<style>
body {
	font-family: Arial, sans-serif;
}
th {
	font-size: 8pt;
	text-align: left;
}
#resource_heading, #look_form, #rules_container {
	width: 100%;
	margin: 0px auto;
	text-align: center;
}

#vspace {
	min-height: 150px;
}

.wide {
	width: 170px;
}
.dollar {
	width: 100px;
}
.narrow {
	width: 30px;
}
.save_button {
}
</style>
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
	<meta http-equiv="content-type" content="text/html; charset=">
	<title>Rule Input</title>
</head>
<body>
<div id="vspace"></div>
<div id="resource_heading"></div>
<div id="look_form">
	<form name="get_form">
		<input type="button" id="prev" value="<">
		<input type="text" id="vr_id" value="1">
		<input type="button" id="next" value=">">
	</form>
</div>
<div id="rules_container"></div>
</body>
<script type="text/javascript">
var max_id = 67;

function get_resource(vendor_resource_id) {
	$(".save_button").die("click");
	$(".narrow, .wide, .currency").die("blur");
	$.ajax({
	    url: "rules_model.php",
	    type : 'POST',
	    data : "type=GET&vendor_resource_id=" + vendor_resource_id,
	    success: function(data){
	    	var dataObj = $.parseJSON(data);
	    	var $rc = $("#rules_container");
	    	var rule_fields = [];
	    	var resource_id = dataObj.resource.resource_id;
	    	$("#resource_heading").html(dataObj.resource.resource_name);
	    	$rc.empty();
	    	var rules = dataObj.rule_info;
    		var resource_rule_id = 0;
	    	var table = "<table cellpadding='2' border='0'>";
	    	table += "<tr><th>Rule</th><th>Min Beds</th><th>Max Beds</th><th>Min Sites</th><th>Max Sites</th><th>Min Users</th><th>Max Users</th><th>Price</th><th>FY</th></tr>"; 
	    	for (var i=0; i<rules.length; i++) {
		    	table += "<tr>";
		    	var field_class = "";
		    	var prepend = "";
	    		for (var key in rules[i]) {
	    			if (i == 0) {
	    				rule_fields.push(key);
	    			}
	    			var skip = false
	    			switch (key) {
	    				case "resource_rule_id" :
	    					resource_rule_id = (rules[i].resource_rule_id == "") ? "0" : rules[i].resource_rule_id;
	    				case "resource_id" :
	    					skip = true;
	    					break;
	    				case "rule_description" :
	    					field_class = "wide";
	    					break;
	    				case "rule_price" :
	    					field_class = "dollar";
	    					prepend = "$";
	    					break;
	    				default :
	    					prepend = "";
	    					field_class = "narrow";
	    					break;
	    			}
	    			if (!skip) {
	    				table += "<td>" + prepend +"<input class='" + field_class + "' id='" + key + "-" + resource_rule_id + "' type='text' value='" + rules[i][key] + "'></td>";
	    			}
	    		}
	    		table += "<td>";
    			table += "<input class='save_button' id='" + resource_rule_id + "' type='button' value='Save'>";
	    		table += "</td></tr>";
	    	}
	    	table += "</table>";
	    	$rc.append(table);
	    	$(".save_button").live("click", function () {
 	    		var rule_id = $(this).attr("id");
 	    		insert_update(resource_id,rule_id,rule_fields);
	    	});
	    }
	});
}

function insert_update(resource_id, rule_id, rule_fields) {
	var qArray = [];
	var query = "type=SAVE&resource_id=" + resource_id + "&resource_rule_id=" + rule_id + "&";
	var suffix = (rule_id == "") ? "" : "-" + rule_id;
	for (var i=0; i<rule_fields.length; i++) {
		var value = $("#" + rule_fields[i] + suffix).val();
		if (typeof(value) != "undefined" && value != "") {
			qArray.push(rule_fields[i] + "=" + value);
		}
	}
	query += qArray.join("&");
	$.ajax({
	    url: "rules_model.php",
	    type : 'POST',
	    data : query,
	    success: function(data){
	    	alert(data);
	    }
	});
	
}

$(document).ready(function() {
	$("#vr_id").blur(function() { 
		var id = $(this).val();
		if (! isNaN(id)) {
			id = parseInt(id,10);
			get_resource(id);
		}
	});
	
	$("#prev").click(function() {
		var $vr_id = $("#vr_id");
		var id = $vr_id.val();
		if (id == 1) {
			return;
		}
		id--;
		$vr_id.val(id);
		get_resource(id);
	});
	
	$("#next").click(function() {
		var $vr_id = $("#vr_id");
		var id = $vr_id.val();
		if (id == max_id) {
			return;
		}
		id++;
		$vr_id.val(id);
		get_resource(id);
	});
	get_resource(1);
});
</script>
</html>