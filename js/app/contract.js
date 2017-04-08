var formHelper = null;
var required = [];
var optional = [];
var lineArray = [];
var lineGrouping = [];
var ccEncrypted = false;
var debug = false;

function validateForm() {
	var missing = pollInputs();
	if (missing) {
		return (debug) ? true : false;
	}
	$("#pleaseSign, #pleaseEmail").css({ color: 'black' });
	$(".sigWrapper, #signature_email").css({ border: '1px solid gray' });
	if ($("#output").val() == "") {
		$("#pleaseSign").css({ color: 'red' });
		$(".sigWrapper").css({ border: '2px solid red' });
		return false;
	}

	if ($("#signature_email").val() == "") {
		$("#pleaseEmail").css({ color: 'red' });
		$("#signature_email").css({ border: '2px solid red' });
		return false;
	}
	return true;
}

function pollInputs() {
	var missing = false;
	var errorVisibility = "hidden";
	for (var i=0; i<required.length; i++) {
		var $control = $("#" + required[i]);
		var requiredStar = "none";
		if ($control.val() == "") {
			requiredStar = 'url(' + requiredImg + ')';
			errorVisibility = "visible";
			missing = true;
		}
		$control.css({ 
			backgroundImage: requiredStar,
			backgroundPosition: 'left top',
			backgroundRepeat: 'no-repeat'
		});
		$(".errorMsg").css({ visibility: errorVisibility });
	}
	
	return missing;
}

function setRequiredStar(controlName, isEmpty) {
	var $control = $("#" + controlName);
	var requiredStar = "none";
	if (isEmpty) {
		requiredStar = 'url(' + requiredImg + ')';
	}
	$control.css({ 
		backgroundImage: requiredStar,
		backgroundPosition: 'left top',
		backgroundRepeat: 'no-repeat'
	});
}

function percentAdd(inPercent, delta) {
	var percent = parseFloat(inPercent,10);
	percent += delta;
	return percent + "%";
}

function createDropdown(controlName) {
	formHelper.populateList({ 
		listName: controlName, 
		dontEmpty: true
	});
}

function countServices() {
	/*
	var nChecks = $(".serviceCheck:checked").length;
	$("#services_count").val(nChecks);
	multiplyServices();
	*/
}

function calculateTotalServiceAmount() {
	var oneTimeFee = $("#one_time_fee").val();
	var twoWeekFee = $("#two_week_fee").val();
	var totalServices = multiplyServices();
	var totalServiceAmount = "";
	oneTimeFee = (oneTimeFee == "") ? 0.0 : parseFloat(oneTimeFee.toNumber());
	twoWeekFee = (twoWeekFee == "") ? 0.0 : parseFloat(twoWeekFee.toNumber());
	totalServicesAmount = (oneTimeFee + twoWeekFee + totalServices).toString();
	totalServicesAmount = totalServicesAmount.toDollar();
	$("#total_service_amount").val("$" + totalServicesAmount);
}

function multiplyServices() {
	var count = 0;
	var amount = 0;
	var mqTotal = 0;
	var totalServices = 0;
	for (var i=1; i<=2; i++) {
		var suffix = "_" + i;
		count = $("#services_count" + suffix).val();
		amount = $("#services_total_amount" + suffix).val();
		
		count = (count != "") ? parseInt(count,10) : 0;
		amount = (amount != "") ? parseFloat(amount.replace("$",""),10) : 0.0;
		
		mqTotal = count * amount;
		$("#services_month_qtr_fee" + suffix).val("$" + mqTotal.toString().toDollar());
		totalServices += mqTotal;
	}
	return totalServices;
}

function totalSpecifications() {
	var specTotal = 0.0;
	var specString = "";
	$("#total_construction_amount").val("");
	$('input[id^="spec_amount"]').each(function () {
		var $child = $(this);
		var amount = $child.val();
		if (amount != "") {
			amount = amount.replace(/[^0-9.]/g,"");
			specTotal += parseFloat(amount,10);
		}
	});
	specString = specTotal.toString().toDollar();
	$("#total_construction_amount").val("$" + specString);
}

function useBillingAddress($element, checkName) {
	var $form;
	var $billingCheck;
	if ($element.is("form")) {
		$form = $element;
		$billingCheck = $("#" + checkName);
	} else {
		$form = $element.closest("form");
		$billingCheck = $element;
	}
	$("input, select, textarea").each(function () {
		var id = $(this).attr("id");
		if (typeof(id) != "undefined") {
			if (id.indexOf("billing_") != -1) {
				var fieldCore = id.replace("billing_","");
				var value = $(this).val();
				if (!$billingCheck.is(':checked')) {
					value = "";
				}
				$("#residence_" + fieldCore).val(value);
			}
		}
	});
	//*** Clear or apply 'required' indicators as applicable
	pollInputs();

}

function validateCC(callback) {
	var cc = $("#cc_number").val();
	if (cc.indexOf("##") == -1) {
		encrypt($("#cc_number"), $("#cc_encrypted"), callback);
	}
}

function popSignature() {
	var horizOffset = 0;
	var verticalOffset = 0;
	if(navigator.platform == 'iPhone' || navigator.platform == 'iPod') {
	     verticalOffset = 0;
	};

	if(navigator.platform == 'iPad') {
	     verticalOffset = 100;
	};

	$("#pleaseSign, #pleaseEmail").css({ color: 'black' });
	$(".sigWrapper, #signature_email").css({ border: '1px solid gray' });
	$("#no_really").css({ visibility: 'hidden' });
	$("#sig_pad").dialog({
		modal: true,
		width: '640px' 
	});
}

function encrypt($sourceField, $destField, callback) {
	$.ajax({ 
		url: generate_doc_ajax_url,
		type: 'POST',
		data: "type=GET_key",
		success: function(data) {
			var sourceID = $sourceField.selector;
			var value = $sourceField.val();
			//** Encrypt value using returned data.  FUTURE: include guid 
			var hash = $.rc4EncryptStr(value,data);
			$destField.val(hash);
			if (sourceID.indexOf("cc_number") != -1) {
				$sourceField.val(hashCC(value));
				if (typeof(callback) == "function") {
					callback();
				}
			}
			if (sourceID.indexOf("signature") != -1) {
				$sourceField.val(hash);
			}
		},
		error: function(e) {
			alert("Error: " + e.responseText);
		}
	});
}

function compactSignature(inSig) {
	return inSig.replace(/[^0-9,]/g,"");
}

function hashCC(ccNumber) {
	var lastFour = ccNumber.substr(ccNumber.length -4);
	var firstPart = ccNumber.replace(lastFour,"");
	return firstPart.replace(/[0-9]/g,"#") + lastFour;
}

//*** Retreive positions of fields (and associated data) from ImageMap data stored in documents folder
function getDocumentLayout() {
	$.ajax({ 
		url: layout_ajax_url,
		type: 'POST',
		data: "type=GET_layout&document=" + document_name,
		success: function(data) {
			if (data.indexOf("SUCCESS") != -1) {
				var dataObj = $.parseJSON(data);
				var mapArray = dataObj.data;
				//*** Get list of fields that are not required
				optional = dataObj.optional;
				//** The anchor is assumed to be an image set to 100% of the screen.  Get the pixel width and set the height
				var imgWidth = parseInt($("#contract_img").css('width'),10);
				var imgHeight = imgWidth * 1.295;
				$("#contract_img").css({ height: imgHeight });
				//*** Do layout
				var builder = new FormBuilder({
					isMobile: is_mobile, //*** Use test from CI to see if this is a mobile device
					anchor: "#contract_img",
					form: $("#sigForm"),
					imgWidth: imgWidth,
					imgHeight: imgHeight,
					mapArray: mapArray,
					optional: optional,
					required: required
				});
				//*** Fill in default fields
				setDefaults();
				$("#loading").dialog('close');
				pollInputs();
			}
			
		},
		error: function(e) {
			alert("Error: " + e.responseText);
		}
	});
}

function addToArray(targetArray, toAdd) {
	if (!targetArray.in_array(toAdd)) {
		targetArray.push(toAdd);
	}
}

function removeFromArray(targetArray, toRemove) {
	if (targetArray.in_array(toRemove)) {
		var thisIndex = targetArray.array_index(toRemove);
		targetArray.remove(thisIndex);
	}
}

function setUnset(setArray, isSet) {
	for (var i=0; i<setArray.length; i++) {
		var shouldSet = isSet;
		if (shouldSet) {
			removeFromArray(required, setArray[i]);
		} else {
			addToArray(required, setArray[i]);
		}
		if (!shouldSet) {
			shouldSet = ($("#" + setArray[i]).val() != "");
		}
		setRequiredStar(setArray[i], !shouldSet);
	}
}
	
function setDefaults() {
	var startDate = formHelper.format(new Date().getTime(), "m/d/Y");
	$("#contract_date, #signature_date").val(startDate);
	if (typeof(services_count_1) != "undefined") {
		$("#services_count_1").val(services_count_1);
	}
	if (typeof(services_count_2) != "undefined") {
		$("#services_count_2").val(services_count_2);
	}
}

function submitContract() {
	var query = $("#sigForm").serialize();
	query = "type=SAVE_document&document=" + document_name + "&" + encodeURI(query);
	$.ajax({ 
		url: generate_doc_ajax_url,
		type: 'POST',
		data: query,
		success: function(data) {
			//alert(data);
			if (data.indexOf("SUCCESS") != -1) {
				alert("Thank You!\nYour contract has been sent to your email address");
			} else {
				alert("There was an error sending the contract:\n" + data + "\n\nPlease contact Mark.");
			}
			$("#loading").dialog('close');
			if (!debug) {
				document.location = sales_page_url;
			}
		},
		error: function(e) {
			alert("Error: " + e.responseText);
		}
	});
}

$(document).ready(function() {
	var weTried = [];
	
	formHelper = new FormHelper({
		thisForm: $("#sigForm"),
		ajaxURL: form_helper_ajax_url
	});
		
	$("#loading").dialog({
		modal: true
	});
	
	getDocumentLayout();
	
	//*** Assign a unique identifier to this document
	var guid = formHelper.guid();
	$('#guid').val(guid);
	
	$('.sigPad').signaturePad({
		drawOnly: true,
		lineTop: 70,
		onPenUp: function() { 
			var coords = $("#output").val();
			var compact = compactSignature(coords);
			$("#signature_encrypted").val(compact); 
			//encrypt($("#signature_encrypted"),$("#signature_encrypted"))
		}
	});
	
	
	//*** Prevent user from dragging image. Disable context menu.
	$('img').bind('contextmenu dragstart', function(e){
		e.preventDefault();
	    return false;
	});

	$("#closeButton").click(function () {
		$("#sig_pad").dialog('close');
	});
	
	$("#signature_email").focus(function () {
		if ($("#output").val() == "") {
			$(this).blur();
		}
	}).blur(function () {
		$("#customer_email").val($("#signature_email").val());
	});
	
	$('input[id$="customer_name"], input[id$="street_address"], input[id$="city"]').live('blur', function () {
		var id = $(this).attr("id");
		if (weTried.in_array(id)) {
			return;
		}
		$(this).val(formHelper.properName($(this).val(), id));
		weTried.push(id);
	});
	
	$("#total_service_amount, #total_construction_amount").live('focus', function () {
		//$(this).blur();
		if ($(this).val() == "$0.00") {
			$(this).val("");
		}
	});
	
	$("#down_payment_amount").live('blur', function () {
		var constTotal = $("#total_construction_amount").val();
		var down = $(this).val();
		if (typeof(constTotal) != "undefined" && typeof(down) != "undefined") {
			constTotal = constTotal.replace(/[^0-9.]/g,"");
			down = down.replace(/[^0-9.]/g,"");
			var balance = (constTotal - down).toString().toDollar();
		
			$("#payment_balance_amount").val("$" + balance);
		}
	});
	
	$("input, select").live('blur change', function () {
		pollInputs();
	});
	
	$("#special_instructions").live('blur keyup', function () {
		var text = $(this).val();
		var maxLen = 250;
		$(this).val((text.length <= maxLen) ? text : text.substr(0, maxLen));
	});
	
	$(".dollarText, .dollarUnderscore").live('blur', function () {
		var value = $(this).val();
		value = value.toDollar();
		$(this).val("$" + value);
	});
	
	$("#billing_zip").live('blur', function () {
		var zip = $(this).val();
		$("#cc_billing_zip").val(zip);

	});
	
	$("#termite_treatment_sum").live('blur', function () {
		$("#total_service_amount").val($("#termite_treatment_sum").val());
	});

	$("#down_payment_percent").live('blur', function () {
		var percent = $("#down_payment_percent").val();
		var total = $("#termite_treatment_sum").val();
		total = total.replace(/[^0-9.]/g,"");
		var downPayment = (percent / 100) * total;
		var balance = total - downPayment;
		$("#down_payment_amount").val("$" + downPayment.toString().toDollar());
		$("#payment_balance_amount").val("$" + balance.toString().toDollar());
	});
	
	/*
	$("#services_count, #services_total_amount").live('blur', function () {
		multiplyServices();		
	});
	*/
	$('input[id^="services_count"], input[id^="services_total_amount"], #one_time_fee, #two_week_fee').live('blur', function () {
		calculateTotalServiceAmount();
	});

	$("#cc_number").live('blur', function () {
		var value = $(this).val();
		var ccSet = (value != "");
		setUnset(["check_number","check_amount"], ccSet);
		setUnset(["cc_expiry_date","cc_billing_zip"], !ccSet);
	});
	
	$("#check_number").live('blur', function () {
		var value = $(this).val();
		var checkSet = (value != "");
		setUnset(["cc_expiry_date","cc_billing_zip"], checkSet);
		setUnset(["check_number","check_amount"], !checkSet);
	});
	
	//*** Monitor the billing fields
	$('input[id^="billing"]').live('blur', function () {
		var $form = $(this).closest("form");
		useBillingAddress($form,"use_billing_address");
	});
	
	//*** Monitor the spec_amount fields
	$('input[id^="spec_amount"]').live('blur', function () {
		totalSpecifications();
	});
	
	//*** Monitor the fee fields
	$("[id$=fee] :input").live('blur', function () {
		var $fees = $("[id$=fee] :input");
		var total = 0.0;
		$fees.each(function () {
			var value = $(this).val();
			value = parseFloat(value.toNumber(),10);
			if (!isNaN(value)) {
				total += value;
			}
			//$("#total_service_amount").val("$" + total.toString().toDollar());
		});
	});
	
	//*** Monitor the specification fields
	$('textarea[id^="specifications"]').live('blur', function (evt) {
	});
	
	function breakLines($test, lineIn, maxLen) {
		var wordArray = lineIn.split(" ");
		var line = "";
		var index = 0;
		
		for (var i=0; i<wordArray.length; i++) {
			line += (" " + wordArray[i]);
			$test.html(line.trim());
			if (parseInt($test.css('width').replace("px",""),10) <= maxLen) {
				lineArray[index] = line.trim();
			} else {
				line = "";
				index++;
			}
		}
		return lineArray;
	}
	
	$("#follow_up_schedule").live('change', function () {
		var value = $(this).val();
		var $other = $("#other_follow_up");
		if (value.indexOf("Other") != -1) {
			$other.css({ visibility: 'visible', backgroundColor: '#E0E0E0' });
			$("body").delay(500);
			$other.focus();
		} else {
			$other.css({ visibility: 'hidden' }).blur();
		}
	});
	
	$("#formSubmit").click(function() {
		if (validateForm()) {
			$("#loading").dialog({
				modal: true
			});
			validateCC(submitContract);
		} else {
			$("#formSubmit").css({ backgroundColor: '#1f3564' });
			$("#no_really").css({ visibility: 'hidden' });
			setTimeout(function () { 
				$("#no_really").css({ visibility: 'visible' });
			}, 100);
						
		}
	});
	
});
