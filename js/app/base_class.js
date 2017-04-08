function BaseClass() {
	var self = this;
	this.options = {
		imagePath: (typeof(image_path) != "undefined") ? image_path : null
	};
	
	this.ajaxCall = function (arg) {
		if (!self.options.hasOwnProperty("ajaxURL")) {
			return;
		}
		var param = {
			url: self.options.ajaxURL,
			type: 'POST',
			data: null ,
			callback: null
		};
		param = $.extend(param, arg);
		if (typeof(arg.url) == "undefined") {
			return;
		}
		$.ajax({ 
			url: param.url,
			type: 'POST',
			data: param.data,
			success: function (data) {
				if (data.substr(0, 1) == "<" || data.indexOf("PHP Error") != -1) {
					self.phpErrorDialog(data);
					return;
				}
				if (data.indexOf("DEBUG") != -1) {
					self.debugDialog(data);
					return;
				}
				if (data.indexOf("ERROR") != -1) {
					self.errorDialog(data);
					return;
				}
				var dataObj = $.parseJSON(data);
				if (typeof(param.callback) == "function") {
					param.callback(dataObj, param);
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var urlMissing = (typeof(arg.url) == "undefined") ? " (Missing)" : "";
				self.errorDialog({
					source:	"BaseClass.ajaxCall",
					message: xhr.statusText,
					url: arg.url + urlMissing,
					called_with: arg.data
				});
			}
		});
	};
	
	this.confirmDialog = function (alertMsg, callback) {
		if (jQuery().dialog) {
			$("<div>" + alertMsg + "</div>").dialog({
				title: "Confirm",
				modal: true,
				width: 'auto',
				buttons: { 
					"Cancel": function() { $(this).dialog("close") },
					"OK": function() {
						$(this).dialog("close");
						if (typeof(callback) == 'function') {
							callback(true);
						}
					}
				}
			});
		} else {
			alert(alertMsg);
		}
	};
	
	this.debugDialog = function (returnData) {
		var alertMsg = document.location;
		if (jQuery().dialog) {
			var dataObj = $.parseJSON(returnData);
			$("<div>" + dataObj.DEBUG + "</div>").dialog({
				title: "Debug Data",
				modal: true,
				width: 'auto',
				buttons: {
					"OK": function() { $(this).dialog("close") }
				}
			});
		} else {
			alert(alertMsg);
		}
	};

	this.phpErrorDialog = function (returnData) {
		var alertMsg = document.location;
		if (jQuery().dialog) {
			var endDiv = returnData.indexOf("</div>");
			var endPos = (endDiv != -1) ? endDiv + 6 : returnData.length;
			var phpData = returnData.substr(0, endPos);
			$("<div>" + phpData + "</div>").dialog({
				title: "PHP Error",
				modal: true,
				width: 'auto',
				buttons: { 
					"OK": function() { $(this).dialog("close") }
				}
			});
		} else {
			alert(alertMsg);
		}
	};
	
	this.errorDialog = function (returnData) {
		var alertMsg = document.location;
		var errorMsg = alertMsg + "<br /><br />";
		var dataObj = (typeof(returnData) == "object") ? returnData : $.parseJSON(returnData);
		for (var key in dataObj) {
			if (dataObj.hasOwnProperty(key)) {
				var label = key.replace("_", " ").toProperCase();
				label = label.replace(/url/gi, "URL");
				alertMsg += label + ": " + " " + dataObj[key] + "\n\n";
				errorMsg += "<ins>" + label + ": " + "</ins> " + dataObj[key] + "<br /><br />";
			}
		}
		if (jQuery().dialog) {
			$("<div>" + errorMsg + "</div>").dialog({
				title: "Error Dislaying Page",
				modal: true,
				width: 'auto',
				buttons: { 
					"OK": function() { $(this).dialog("close") }
				}
			});
		} else {
			alert(alertMsg);
		}
	};
	
	//*** Get parameter from the URL string
	this.getURLParam = function (param) {
		var urlParams = {};
		var e,
			a = /\+/g,  // Regex for replacing addition symbol with a space
			r = /([^&=]+)=?([^&]*)/g,
			d = function (s) { return decodeURIComponent(s.replace(a, " ")); },
			q = window.location.search.substring(1);
	
		while (e = r.exec(q)) {
		   urlParams[d(e[1])] = d(e[2]);
		}
		var thisParam = (urlParams.hasOwnProperty(param)) ? urlParams[param] : null;
		return thisParam;
	};

	self.serialize = function(obj, prefix) {
	    var str = [];
	    for(var p in obj) {
		   var k = prefix ? prefix + "[" + p + "]" : p, v = obj[p];
		   str.push(typeof v == "object" ? 
			  serialize(v, k) :
			  encodeURIComponent(k) + "=" + encodeURIComponent(v));
	    }
	    return str.join("&");
	}

	this.init = function () {
		$.datepicker._gotoToday = function(id) {
		    var target = $(id);
		    var inst = this._getInst(target[0]);
		    if (this._get(inst, 'gotoCurrent') && inst.currentDay) {
				  inst.selectedDay = inst.currentDay;
				  inst.drawMonth = inst.selectedMonth = inst.currentMonth;
				  inst.drawYear = inst.selectedYear = inst.currentYear;
		    }
		    else {
				  var date = new Date();
				  inst.selectedDay = date.getDate();
				  inst.drawMonth = inst.selectedMonth = date.getMonth();
				  inst.drawYear = inst.selectedYear = date.getFullYear();
				  // the below two lines are new
				  this._setDateDatepicker(target, date);
				  this._selectDate(id, this._getDateDatepicker(target));
		    }
		    this._notifyChange(inst);
		    this._adjustDate(target);
		}
	};
	
	this.__constructor = function () {
		self.init();
	}();

}


//*** END OF FILE /js/app/base_class.js