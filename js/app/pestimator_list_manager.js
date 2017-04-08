function Pestimator_ListManager(arg) {
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
	
	this.ajaxURL = null;

	//*** Use the miracle of jQuery .extend() to add the values from 'arg' to the Contact_Us_ListManager object
	$.extend(this, arg);

	this.init = function () {
		self.firstCall = true;
		self.detailDiv = $("#pestimator_list_detail");
		self.startDate = $("#start_date");
		self.endDate = $("#end_date");
		self.datePickers = $("#start_date, #end_date");
		self.rowCount = $("#row_count");
		self.detailDiv.css({ display : 'none' });
		self.listManager = new ListManager({
			ajaxURL: self.ajaxURL,
			tag: 'pestimator',
			getType: 'GET_list',
			accordion: true,
			oneAtATime: true,
			tableWidth: '100%',
			defaultSort: 'estimate_datetime DESC',
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
	
	this.retrieveDetailData = function (estimateID, $cell) {
		self.ajaxCall({
			url: self.ajaxURL,
			data: "type=GET_detail&estimate_id=" + estimateID,
			callback: function (dataObj) {
				var data = dataObj.data;
				$cell.html("");
				for (var key in data) {
					if (data.hasOwnProperty(key)) {
						var value = data[key];
						switch (key) {
							case "estimate_dollars" :
								value = "$" + value.toDollar();
								break;
							case "estimate_pests" :
								value = self.generatePests(value);
								break;
						}
						$("#" + key).html(value);
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
//*** Subclass Pestimator_ListManager to BaseClass
Pestimator_ListManager.prototype = new BaseClass();
Pestimator_ListManager.constructor = Pestimator_ListManager;
/*** End of File /js/app/pestimator_list_manager.js ***/