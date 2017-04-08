function ListManager (arg) {
	var self = this;
	var $self = this;
	this.ajaxURL = null;
	this.initOnly = false;
	this.defaultSort = null;
	this.currentSort = "";
	this.tag = null;
	this.getType = "GET_list";
	this.searchSelector = $(".search");
	this.foundSelector = null;
	this.onClickRowCallback = null;
	this.detailCallback = null;
	this.onDataCallback  = null;
	this.queryString = "";
	this.additionalParams = "";
	this.listTable = null;
	this.tableWidth = "100%";
	this.tableFooter = "";
	this.container = "list_container";
	this.formSelector = null;
	this.expandColumn = null;
	this.accordion = false;
	this.oneAtATime = false;
	this.appendData = null;
	this.prependData = null;
	this.clearContents = true;
	this.sections = [];
	this.thisQueryString = [];
	this.extraData = {};
	this.searchTerms = "";
	this.adHoc = "";
	this.userCanSort = true;
	this.waitColumn = 0;

	//*** Use the miracle of jQuery .extend() to add the values from 'arg' to the ListManager object
	$.extend(this, arg);

	ListManager.prototype.getList = function () {
		self._getList();
	};
	
	ListManager.prototype.getSearchTerms = function () {
		return self.searchTerms;
	};
	
	ListManager.prototype.setParam = function (param) {
		self.additionalParams += (self.additionalParams.length > 0) ? "&" : "";
		self.additionalParams += param;
	};
	
	ListManager.prototype.setParams = function (paramString) {
		self.additionalParams = paramString;
	};
	
	ListManager.prototype.setContatiner = function (containerSelector) {
		self.container = containerSelector;
	};
	
	ListManager.prototype.adHocList = function (hocArg) {
		self.ajaxURL = (typeof(hocArg.ajaxURL) != "undefined") ? hocArg.ajaxURL : self.ajaxURL;
		self.container = (typeof(hocArg.container) != "undefined") ? hocArg.container : self.container;
		self.tag = (typeof(hocArg.tag) != "undefined") ? hocArg.tag : self.tag;
		self.getType = (typeof(hocArg.getType) != "undefined") ? hocArg.getType : self.getType;
		self.queryString = (typeof(hocArg.queryString) != "undefined") ? hocArg.queryString : self.queryString;
		self.searchTerms = (typeof(hocArg.searchTerms) != "undefined") ? hocArg.searchTerms : self.searchTerms;
		self.currentSort = (typeof(hocArg.defaultSort) != "undefined") ? hocArg.defaultSort : self.currentSort;
		self.accordion = (typeof(hocArg.accordion) != "undefined") ? hocArg.accordion : self.accordion;
		self.oneAtATime = (typeof(hocArg.oneAtATime) != "undefined") ? hocArg.oneAtATime : self.oneAtATime;
		self.onClickRowCallback = (typeof(hocArg.detailCallback) != "undefined") ? hocArg.detailCallback : self.detailCallback;
		self.detailCallback = (typeof(hocArg.onClickRowCallback) != "undefined") ? hocArg.onClickRowCallback : self.onClickRowCallback;
		self.additionalParams = (typeof(hocArg.additionalParams) != "undefined") ? hocArg.additionalParams : self.additionalParams;
		self.adHoc = (typeof(hocArg.adHoc) != "undefined") ? hocArg.adHoc : self.adHoc;
		self._getList();
		self.adHoc = "";
	};
	
	this._getList = function () {
		var query = "type=" + self.getType + "&sort_order=" + self.currentSort;
		if (self.searchTerms != "" && typeof(self.searchTerms) != "undefined") {
			query += "&search_terms=" + self.searchTerms;
		}
		if (self.queryString != "" && typeof(self.queryString) != "undefined") {
			query += "&" + self.queryString;
		}
		if (self.additionalParams != "" && typeof(self.additionalParams) != "undefined") {
			query += "&" + self.additionalParams;
		}
		if (self.adHoc != "" && typeof(self.adHoc) != "undefined") {
			query += "&" + self.adHoc;
		}
		self.ajaxCall({
			url: self.ajaxURL,
			data : query,
			callback: function (dataObj) {
				var idField = dataObj.id_field;
				var dataList = dataObj.data_list;
				var dataLen = (dataObj.data_list != null) ? dataList.length : 0;
				var columnList = dataObj.column_list;
				var dbColumns = dataObj.db_columns;
				var rowData = [];
				var tagID = (self.tag != null) ? self.tag + "_" : "";
				if (self.container.indexOf("#") == -1) {
					self.container = "#" + tagID + self.container;
				}
				var $lc = $(self.container);
				self.sections = [];
				$lc.empty();
				self.extraData = dataObj.extra_data;
				
				//*** Construct the HTML table to contain the returned data
				self.listTable = self.buildTable(idField, dataList, columnList, rowData);
				//*** Label to show how many items found
				$self.foundSelector.html(dataLen + " items found");
				if ($("#" + self.tag + "_label").length != 0) {
					$("#" + self.tag + "_label").css({ color: (dataLen == 0) ? 'gray' : 'black' });
				}
				
				//console.log("Tag: " + self.tag + " Container: " + self.container);
				//*** Put data before list if available
				if (self.prependData != null) {
					$lc.append(self.prependData);
				}
				//*** Append the table to the DOM
				$lc.append(self.listTable);
				//*** Put data after list if available
				if (self.appendData != null) {
					$lc.append(self.appendData);
				}
				
				//*** Set up sort and display the appropriate arrow at column head (must have ASC.png and DESC.png in image path)
				self.setUpSorting(tagID);

				//*** Add hidden fields if columns are available
				if (typeof(dbColumns) != "undefined" && self.formSelector != null) {
					for (var i=0; i<dbColumns.length; i++) {
						//*** Add only fields that are not define
						if ($("#" + dbColumns[i]).length == 0) {
							var html = '<input type="hidden" id="' + dbColumns[i] + '" name="' + dbColumns[i] + '" value="" />';
							self.formSelector.append(html);
						}
					}
				}
				//*** Hide all 'wait' gifs.
				$('[id^="wait"]').css({ backgroundImage: 'none' });
				//*** Remove click events from column heads and rows
				
				self.initListEvents(tagID);
				
				//*** If an "onData" callback is specified, call it now
				if (typeof(self.onDataCallback) == "function") {
					self.onDataCallback (dataLen, self.extraData, rowData);
				}
			},
			error: function (msg) {
				alert("ListManager reports: " + msg.statusText + "\n\nURL is: " + self.ajaxURL);
			}
		});
	};

	ListManager.prototype.collapseAll = function (leaveOpen, sections, clearContents) {
		for (var i=0; i<sections.length; i++) {
			if (leaveOpen == sections[i]) {
				continue;
			}
			$(sections[i]).hide();
			if (clearContents) {
				$(sections[i]).find("td").html("");
			}
		}
	};
	
	ListManager.prototype.listenForSearch = function (rowID) {
		$self.searchSelector.keyup(function () {
			var thisID = $(this).attr("id");
			var doSearch = true;
			if (self.tag != null && thisID.indexOf(self.tag) == -1) {
				doSearch = false;
			}
			if (doSearch) {
				self.searchTerms = $(this).val();
				self.showClearSearch(self.searchTerms.length > 0);
				self._getList();
			}
		});
	};

	ListManager.prototype.openRow = function (rowID) {
		$(self.sections[rowID]).show();
	};
	
	ListManager.prototype.getRowCell = function (rowID) {
		var tagTitle = (self.tag != null) ? self.tag : null;
		var tagID = (tagTitle != null) ? tagTitle + "_" : "";
		return $("#expand_" + tagID + rowID);
	};
	
	this.buildTable = function (idField, dataArray, columns, rowData) {
		self.waitColumn = getObjectLength(columns);
		columns['wait'] = { label: "", column_width: "20px", align: "center" };
		var fields = [];
		var aligns = [];
		var controls = [];
		var controlID = "";
		var tagTitle = (self.tag != null) ? self.tag : null;
		var tagID = (tagTitle != null) ? tagTitle + "_" : "";
		var table = "<table id='list' cellpadding='2' cellspacing='0' width='" + self.tableWidth + "' align='center'>";
		table += "<tr>";
		if (self.expandColumn != null) {
			var newObj = {};
			newObj[self.expandColumn] = "";
			for (var key in columns) {
				if (columns.hasOwnProperty(key)) {
					newObj[key] = columns[key];
				}
			}
			columns = newObj;
		}
		for (var field in columns) {
			var colWidth = "";
			if (field == self.expandColumn) {
				colWidth = "width='2%'";
			}
			if (columns.hasOwnProperty(field)) {
				fields.push(field);
				var label = "";
				var labelAlign = "";
				var align = "left";
				var control = "";
				if (typeof(columns[field]) == "object") {
					label = columns[field].label;
					if (columns[field].hasOwnProperty('label_align')) {
						labelAlign = columns[field].label_align;
					}
					if (columns[field].hasOwnProperty('align')) {
						align = columns[field].align;
					}
					if (columns[field].hasOwnProperty('control')) {
						control = columns[field].control;
					}
					if (columns[field].hasOwnProperty('column_width')) {
						colWidth = "width='" + columns[field].column_width + "'";
					}
				} else {
					label = columns[field].replace(/ /g,"&nbsp;");
				}
				
				table += "<th id='" + tagID + "sort_" + field + "' class='head_face " + labelAlign + "' " + colWidth + ">" + label + "</th>";
				aligns.push(align);
				controls.push(control);
			}
		}
		table += "</tr>"; 
		if (dataArray != null) {
			for (var i=0; i<dataArray.length; i++) {
				var recordID = (typeof(dataArray[i][idField]) != "undefined") ? dataArray[i][idField] : "";
				var columnCount = 0;
				var isActive = "";
				if (dataArray[i].hasOwnProperty('is_active')) {
					if (dataArray[i].is_active == "0") {
						isActive = "_inactive";
					}
				}
				rowData.push({ rowID: tagID + "data_" + recordID, expandID: "#expand_current_" + recordID });
				table += "<tr class='data_row" + isActive + "' id='" + tagID + "data_" + recordID + "'>";
				for (var key in fields) {
					if (isNaN(key)) {
						continue;
					}
					var field = fields[key];
					var value = dataArray[i][field];
					value = (typeof(value) != "undefined") ? value.toString() : "";
					if (typeof(value) == "string") {
						value = value.deEscape();
					}
					
					if (typeof(self.searchTerms) != "undefined" && self.searchTerms != "") {
						if (value.toLowerCase().indexOf(self.searchTerms.toLowerCase()) != -1) {
							value = value.replace(
								new RegExp(self.searchTerms, 'gi'), 
								function(match) {
									return ["<span class='highlight'>", match, "</span>"].join("");
								}
							);
						}
					}
					var spinny = "";
					var loader = "";
					if (columnCount == self.waitColumn && self.accordion) {
						spinny = " spinny";
						loader = "id='wait_" + recordID + "'";
					}
					if (controls[key] != "") {
						var control = controls[key];
						controlID = "id='control_" + control + "_" + tagID + recordID + "'";
						if (control == "check" || controls[key] == "read") {
							var png = (value === "1") ? control + '.png' : 'un' + control + '.png';
							value = "<img  " + controlID + " src='" + self.options.imagePath + "/" + png + "'>";
						}
					}
					if (field == self.expandColumn) {
						var expImage = "\u25ba"; //*** Unicode right arrow character
						value = (value == "1") ? "<div id='" + recordID + "_expand_image' class='expander'>" + expImage + "</div>" : "";
					}
					if (value.length == 0) {
						value = "&nbsp;";
					}
	 				table += "<td class='data" + spinny + "' " + loader + " id='" + recordID + "_" + field + "' align='" + aligns[key] + "' nowrap>" + value + "</td>";
	 				columnCount++;
				}
				table += "</tr>";
				//*** Add this section to array of section elements.
				self.sections.push("#expand_" + tagID + recordID);
				if (self.accordion) {
					table += "<tr id='expand_" + tagID + recordID + "' class='accordion'>";
					table += "<td id='accordion_" + tagID + recordID + "' class='accordion_cell' colspan='" + columnCount + "' align='center'></td>"
					table += "</tr>";
				}
				
			}
		}
		table += self.tableFooter;
		table += "</table>";
		return table;
	};

	this.getSearch = function () {
		return $self.searchSelector.val();
	};

	this.initListEvents = function (tagID) {
		//*** NOTE: Selector syntax indicates "select all id's that begin with [tagID] + 'data'".
		//*** Add events for data rows				
		$('[id^="' + tagID + 'data"]').off().on('click touch', function (evt) {
			var shiftKey = evt.shiftKey;
			var controlKey = evt.metaKey;
			var rowID = $(this).attr("id");
			rowID = (typeof(rowID) == "undefined") ? "" : rowID;
			var dataID = (rowID != "") ? rowID.replace(tagID + "data_","") : "";
			if (self.accordion) {
				var cellID = "#expand_" + tagID + dataID;
				var $parent = $(this).parent();
				var $row = $(cellID);
				var $wait = $("#wait_" + dataID);
				var $cell = $row.find("td");
				if (self.oneAtATime) {
					var leaveOpen = (isOpen) ? cellID : "";
					self.collapseAll(leaveOpen, self.sections, self.clearContents);
				}
				var isOpen = self.toggleAccordion($row);
				if (isOpen) {
					if (typeof(self.detailCallback) == "function") {
						$wait.css({ 
							backgroundImage : "url(" + self.options.imagePath + "/" + "ajax-loader.gif)",
							backgroundRepeat: 'no-repeat',
							backgroundPosition: '90%' 
						});
						self.detailCallback(dataID, $cell);
					}
				} else {
					if (typeof(self.onClickRowCallback) == "function") {
						self.onClickRowCallback(dataID);
					}					
				}
			} else {
				if (typeof(self.detailCallback) == "function") {
					self.detailCallback(dataID);
				}
			}
			if (self.expandColumn != null) {
				var expImage = (isOpen) ? "\u25bc" : "\u25ba"; //*** Unicode arrows: down or right
				$("#" + dataID + "_expand_image").html(expImage);	
			}
		});
		if (self.userCanSort) {
			//*** Add events for column heads
			$('[id^="' + tagID + 'sort"]').off().on("click touch", function () {
				var sort_id = $(this).attr("id").replace(tagID + "sort_","");
				self.currentSort = self.reSort(self.currentSort,sort_id);
				self._getList();
			});		
		}
	};

	this.reSort = function (sort_string, new_sort) {
		if (sort_string.indexOf(new_sort) != -1) {
			if (sort_string.indexOf("ASC") != -1) {
				sort_string = sort_string.replace("ASC","DESC");
			} else {
				sort_string = sort_string.replace("DESC","ASC");
			}
		} else {
			sort_string = new_sort + " ASC";
		}
		return sort_string;
	};

	this.showClearSearch = function (show) {
		var should_show = (show) ? "inline-block" : "none";
		$("#clear_search").css({ display : should_show });
	};
	
	this.setListeners = function () {
		self.listenForSearch();
		//*** Set up search field with a prompt
		var tagName = (self.tag != null) ? self.tag + "_" : "";
		var $inputField = $("#" + tagName + "search");
		$inputField.css({ position: 'relative' });
		var $promptSpan = $('<span class="input_prompt"/>');
		var $clearSearch = $('<div class="clear_search"></div>');
		//*** Append to DOM
		$inputField.before($promptSpan);
		$inputField.after($clearSearch);
		
		$promptSpan.attr('id', tagName + 'input_prompt').append($inputField.attr('title')).click(function (){
			$(this).hide();
			$inputField.focus();
		});
		
		$clearSearch.attr('id', tagName + 'clear_search_').css({
			position: 'absolute',
			zIndex: '10'
		}).click(function () {
			self.searchTerms = "";
			$clearSearch.hide();
			self._getList();
			$inputField.val("").blur();
		}).hide();
		
		if ($inputField.val() != ''){
			$promptSpan.hide();
		}
			
		$inputField.focus(function(){
			$promptSpan.hide();
			$clearSearch.show().position({
				my: 'left top',
				at: 'right top',
				of: $inputField,
				offset: '-19 4',
				collision: 'none'
			});
		});
		$inputField.blur(function(){
			if ($(this).val() == '') {
					$promptSpan.show().position({
					my: 'left',
					at: 'left',
					of: $inputField,
					offset: '10 0',
					collision: 'none'
				});
			}
		});
	};
	
	this.setUpSorting = function (tagID) {
		var sort_parts = self.currentSort.split(" ");
		$("#" + tagID + "sort_" + sort_parts[0]).css({ 
			backgroundImage : "url(" + self.options.imagePath + "/" + sort_parts[1] + ".png)",
			backgroundRepeat: 'no-repeat',
			backgroundPosition: '90%' 
		});
	};
	
	this.toggleAccordion = function ($row) {
		var display = $row.css("display");
		var toggle = (display == "none") ? "table-row" : "none"
		$row.css({ display : toggle });
		return (toggle == "table-row");
	};

	this.__constructor = function () {
		//*** Extend the BaseClass options object with an 'ajaxURL' property
		self.options.ajaxURL = self.ajaxURL;
		//*** Call the superconstructor
		BaseClass.call(this);
		var tagName = (self.tag != null) ? self.tag + "_" : "";
		$self.foundSelector = $("#" + tagName + "found");
		if (self.initOnly) {
			return;
		}
		self.currentSort = (self.defaultSort != null) ? self.defaultSort : "";
		self._getList();
		self.setListeners();
	}();
}
//*** Subclass ListManager to BaseClass
ListManager.prototype = new BaseClass();
ListManager.constructor = ListManager;

//*** END OF FILE /js/app/list_manager.js
