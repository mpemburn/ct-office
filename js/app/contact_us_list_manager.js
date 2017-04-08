function Contact_Us_ListManager(arg) {
	var self = this;
	var listManager = null;
	var detailDiv = null;
	var datePickers = null;
	var startDate = null;
	var endDate = null;
	var pageVars = [];
	var rowCount = null
	var numRows = 0;
	var firstCall = false;
	var dateCall = false;
	
	this.ajaxURL = null;

	//*** Use the miracle of jQuery .extend() to add the values from 'arg' to the Contact_Us_ListManager object
	$.extend(this, arg);

	this.init = function () {
		self.firstCall = true;
		self.detailDiv = $("#contact_us_list_detail");
		self.startDate = $("#start_date");
		self.endDate = $("#end_date");
		self.datePickers = $("#start_date, #end_date");
		self.rowCount = $("#row_count");
		self.detailDiv.css({ display : 'none' });
		self.listManager = new ListManager({
			ajaxURL: self.ajaxURL,
			tag: 'contact_us',
			getType: 'GET_list',
			accordion: true,
			oneAtATime: true,
			tableWidth: '100%',
			defaultSort: 'timestamp DESC',
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
	
	this.retrieveDetailData = function (contactID, $cell) {
		self.ajaxCall({
			url: self.ajaxURL,
			data: "type=GET_message&contact_id=" + contactID,
			callback: function (dataObj) {
				var data = dataObj.data;
				$cell.html("");
				for (var key in data) {
					if (data.hasOwnProperty(key)) {
						$("#" + key).html(data[key]);
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
//*** Subclass Contact_Us_ListManager to BaseClass
Contact_Us_ListManager.prototype = new BaseClass();
Contact_Us_ListManager.constructor = Contact_Us_ListManager;
/*** End of File /js/app/contact_us_list_manager.js ***/