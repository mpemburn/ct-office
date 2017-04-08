function Contract_ListManager(arg) {
	var self = this;
	var listManager = null;
	var detailDiv = null;
	var datePickers = null;
	var startDate = null;
	var endDate = null;
	var rowCount = null
	var numRows = 0;
	var pageVars = [];
	var firstCall = false;
	var dateCall = false;
	var dataURL = null;
	var pdfImage = null;
	var noPdfImage = null;
	
	this.ajaxURL = null;

	//*** Use the miracle of jQuery .extend() to add the values from 'arg' to the Contact_Us_ListManager object
	$.extend(this, arg);

	this.init = function () {
		self.firstCall = true;
		self.detailDiv = $("#contract_list_detail");
		self.startDate = $("#start_date");
		self.endDate = $("#end_date");
		self.datePickers = $("#start_date, #end_date");
		self.rowCount = $("#row_count");
		self.detailDiv.css({ display : 'none' });
		self.listManager = new ListManager({
			ajaxURL: self.ajaxURL,
			tag: 'contract',
			getType: 'GET_list',
			accordion: true,
			oneAtATime: true,
			tableWidth: '100%',
			defaultSort: 'time_stamp DESC',
			detailCallback: self.retrieveDetailData,
			onDataCallback: self.listLoaded
		});
		
		self.datePickers.datepicker({
			changeMonth: true,
			changeYear: true,
			showButtonPanel: true,
			dateFormat: 'm/d/yy',
			closeText : "Close",
			onClose: function(dateText, inst) {
				setTimeout(function () {
					self.setDateRange();
				}, 500);
			}
		});
	};
	
	this.generatePests = function (value) {
		var already = [];
		var html = "<ul>";
		var pestArray = value.split(",");
		for (var i=0; i<pestArray.length; i++) {
			var _pest = pestArray[i];
			if (!already.in_array(_pest)) {
				var pest = _pest.replace("_", " ").ucwords();
				html += "<li>" + pest + "</li>";
			}
			already.push(_pest);
		}
		return html + "</ul>";
	};

	this.listLoaded = function (dataLen, extraData, rowData) {
		var startDate = (typeof(extraData) != "undefined") ? extraData.start_date : "";
		var endDate = (typeof(extraData) != "undefined") ? extraData.end_date : "";
		if (self.firstCall) {
			self.startDate.val(startDate);
			self.endDate.val(endDate);
			self.firstCall = false;
		}
		if (self.dateCall) {
			self.dateCall = false;
		}
		self.numRows = rowData.length;
		self.rowCount.html(self.numRows);
	};

	this.retrieveDetailData = function (contractID, $cell) {
		self.ajaxCall({
			url: self.ajaxURL,
			data: "type=GET_detail&contract_id=" + contractID,
			callback: function (dataObj) {
				var data = dataObj.data;
				$cell.html("");
				for (var key in data) {
					var skip = false;
					if (data.hasOwnProperty(key)) {
						var value = data[key];
						switch (key) {
							case "contract_dollars" :
								value = "$" + value.toDollar();
								break;
							case "contract_pests" :
								value = self.generatePests(value);
								break;
							case "pdf_name" :
								var href = self.dataURL + value;
								var image = self.pdfImage;
								if (value == "Not found") {
									href = document.location + "/#";
									image = self.noPdfImage;
								}
								$("#" + key).attr('href', href);
								$("#image_" + key).attr('src', image);
								skip = true;
								break;
						}
						if (!skip) {
							$("#" + key).html(value);
						}
					}
				}
				$cell.html(self.detailDiv.html());
				//*** Hide the 'loading' spinner
				$('[id^="wait"]').css({ backgroundImage: 'none' });
			}
		});
	};
	
	this.setDateRange = function () {
		self.dateCall = true;
		self.listManager.adHocList({
			additionalParams: "start_date=" + self.startDate.val() + "&end_date=" + self.endDate.val()
		});
	};

	this.__constructor = function () {
		//*** Extend the BaseClass options object with an 'ajaxURL' property
		self.options.ajaxURL = self.ajaxURL;
		//*** Call the superconstructor
		BaseClass.call(this);

		self.init();
	}();
}
//*** Subclass Contract_ListManager to BaseClass
Contract_ListManager.prototype = new BaseClass();
Contract_ListManager.constructor = Contract_ListManager;
/*** End of File /js/app/contract_list_manager.js ***/