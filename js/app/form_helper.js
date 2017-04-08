function FormHelper (arg) {
	var self = this;
	var $self = this; // create second reference to use for jQuery objects
	
	this.contactPanel = null;
	this.contactIsInit = false;
	this.popPanels = [];
	this.contactUndo = "";
	this.currentKey;
	this.formSelector = null;
	this.undoData = {};
	this.changedData = {};	
	this.prefixes = ['vere','von','van','de','del','della','di','da','pietro','vanden','du','st.','st','la','lo','ter'];


	//*** Use the miracle of jQuery .extend() to add the values from 'arg' to the FormHelper object
	$.extend(this, arg);

	//*** FormHelper public methods
	FormHelper.prototype.clearFields = function (dataArray, clearArray) {
		for (var field in dataArray) {
			if (dataArray.hasOwnProperty(field)) {
				if (typeof(clearArray) != "undefined") {
					if (!clearArray.in_array(field)) {
						continue;
					}
				}
				$("#" + field).val("");
			}
		}
	};
	
	//*** Begin FormHelper public methods
	FormHelper.prototype.createPopPanel = function (popArg) {
		//*** Make this an object with its own methods
		function Pop(popArg) {
			var me = this;
			this.panelSelector = null;
			this.relativeSelector = null;
			this.offsetX = -40;
			this.offsetY = -1;
			this.isShowing = false;
			this.positionID = null;
			this.uid = self.guid();
			
			//*** Extend/modify values via jQuery			
			$.extend(this, popArg);

			this.hide = function () {
				me.panelSelector.css({ visibility: 'hidden' });
				me.isShowing = false;
				if (typeof(me.onHide) == "function") {
					me.onHide();
				}
			};
			
			this.hideOthers = function () {
				for (var i=0; i<self.popPanels.length; i++) {
					var uid = self.popPanels[i].uid;
					if (uid != me.uid) {
						self.popPanels[i].hide();
					}
				}
			};
			
			this.show = function ($where) {
				me.hideOthers();
				me.panelSelector.css({ visibility: 'visible' });
				if (typeof($where) != "undefined") {
					me.positionID = $where.attr("id");
					me.panelSelector.position({
						my: 'left top',
						at: 'left bottom',
						of: $where,
						offset: me.offsetX + ' ' + me.offsetY,
						collision: 'none'
					});
				}
				me.isShowing = true;
				if (typeof(me.onShow) == "function") {
					me.onShow();
				}
			};
			
			this.__constructor = function () {
				me.positionID = me.relativeSelector.attr("id");
				//*** We need to display, position, then hide in order for it to position correctly.
				me.panelSelector.css({ 
					display: 'block',
					position: 'absolute',
					zIndex: '999' 
				}).position({
					my: 'left top',
					at: 'left bottom',
					of: me.relativeSelector,
					offset: me.offsetX + ' ' + me.offsetY,
					collision: 'none'
				}).click(function (evt) {
					//*** If user clicks "X", close
					var x = evt.pageX - this.offsetLeft;
					var width = $(this).width();
					if (x >= width - 16) {
						me.hide();
					}
				}).css({ visibility: 'hidden' });
			}();
		};
		var thisPop = new Pop(popArg);
		self.popPanels.push(thisPop);
		return thisPop;
	};

	FormHelper.prototype.blankControls = function (panel) {
		var $panelInputs = $("#" + panel + " :input");
		$panelInputs.each(function (i) {
			$(this).val(null);
		});
	}
	
	FormHelper.prototype.enableControls = function (panel, doSo, skipControls) {
		var $panelInputs = $("#" + panel + " :input");
		$panelInputs.each(function (i) {
			var id = $(this).attr("id");
			var skip = false;
			if (typeof(skipControls) == "undefined") {
				skipControls = [];
			}
			//*** Don't alter hidden controls
			if ($(this).attr("type") == "hidden") {
				skipControls.push(id);
			}
			skip = skipControls.in_array(id);
			if (!skip) {
				if ($(this).attr("type") == "button" || $(this)[0].tagName.toUpperCase() == "BUTTON") {
					$(this).css({ color: (doSo) ? 'black' : 'gray' });
				}
				$(this).prop('disabled', !doSo);
			}
		});
	}
	
	FormHelper.prototype.format = function (inMillis, formatStr) {
		if (isNaN(inMillis)) {
			return null;
		}

		var d = new Date(inMillis);
		return d.format(formatStr);
	};

	FormHelper.prototype.getPrefixes = function () {
		return self.prefixes;
	};
	
	//*** Returns 36 character globally unique identifier (e.g.: '21385136-6508-7a60-f293-3ab08c079006');
	FormHelper.prototype.guid = function () {
	    return "".guid();
	};
	
	FormHelper.prototype.loadSelect = function (listName, data) {
		for (var value in data) {
			if (data.hasOwnProperty(value)) {
				var text = data[value];
				$("#" + listName).append($("<option />").val(value).text(text));
			}
		}
	};
	
	FormHelper.prototype.populateFields = function (dataArray, transform) {
		var transformType;
		var transformParam;
		for (var field in dataArray) {
			if (dataArray.hasOwnProperty(field)) {
				var value = dataArray[field];
				if (typeof(transform) == "object") {
					if (transform.hasOwnProperty(field)) {
						if (typeof(transform[field]) == "object") {
							transformType = transform[field].type;
							transformParam = transform[field].param;
						} else {
							transformType = transform[field];
						}
						switch (transformType) {
							case "toDollar" :
								value = value.toDollar();
								break;
							case "fromISODate" :
								value = value.fromISODate(transformParam);
								break;
							case "fromISOTime" :
								value = value.fromISOTime(transformParam);
								break;
							case "toISODate" :
								if (typeof(value) == "object") {
									value = value.toISODate();
								}
								break;
						}
					}
				}
				$("#" + field).val(value);
			}
		}
	};
	
	FormHelper.prototype.populateList = function (args) {
		var options = {
			listName: null,
			extraParams: null,
			dontEmpty: false,
		}
		options = $.extend(options, args);
		
		var firstID = null;
		var query = "&list_name=" + options.listName;
		query += (options.extraParams == null) ? "" : "&" + options.extraParams; 
		var resourceList = [];
		var parentArray = [];
		options.listName = options.listName.replace("#","");
		if (self.changedData.length > 0) {
			if (!self.changedData.hasOwnProperty(listName)) {
				return;
			}
		}
		if (typeof(options.dontEmpty) == "undefined") {
			$("#" + options.listName).empty();
		}
		$.ajax({
		    url: self.ajaxURL,
		    type : 'POST',
		    data : "type=GET_ddlist" + query,
		    dataType: "text",
		    success: function(data){
				var dataObj = $.parseJSON(data);
				for (var value in dataObj) {
					if (dataObj.hasOwnProperty(value)) {
						var text = dataObj[value];
						$("#" + options.listName).append($("<option />").val(value).text(text));
					}
				}
				var value = self.changedData[options.listName];
				$("#" + options.listName).val(value);
		    }
		});
	}
	
	FormHelper.prototype.properName = function (inName, controlID) {
		var prefixes = (controlID.indexOf("name") != -1) ? self.prefixes : [];
		var nameParts = inName.split(" ");
		for (var i=0; i<nameParts.length; i++) {
			if (!prefixes.in_array(nameParts[i])) {
				nameParts[i] = nameParts[i].toProperCase();
			}
		}
		return nameParts.join(" ");
	};
	
	//*** Begin FormHelper private methods
	this.ajaxParse = function (contactValue) {
		$.ajax({ 
			url: members_ajax_url,
			type: 'POST',
			data: self.contactQuery + "=" + contactValue,
			success: function(data) {
				var dataObj = $.parseJSON(data);
				if (dataObj.status == "SUCCESS") {
					var parsed = dataObj.parsed;
					for (var field in parsed) {
						//*** Parse returned values out to contact fields (first_name, middle_name, etc.)
						if (parsed.hasOwnProperty(field)) {
							$("#" + field).val(parsed[field]);
						}
					}
					//*** Trigger the 'soil' event to let isDirty know that a keyup or change event has taken place on this field
					//		Pass along the last 'keyup' value in case user has hit ESC (keycode == 27).
					self.contactName.trigger('soil', [self.currentKey]);
				}
			}
		});
	};
	
	this.fieldDirtyStatusChanged = function (hasChanged) {
		self.setFormDirtyIndicator(hasChanged);
		if (!hasChanged && self.contactPanel != null) {
			self.contactPanel.hide();
		}
	};

	this.fieldUndone = function (fieldName, undoValue) {
		if (self.contactParser != null) {
			if (fieldName == self.contactName.attr("id")) {
				self.ajaxParse(undoValue);
			}
		}
	};

	this.initForm = function () {
		if (!jQuery().isDirty) {
			return;
		}

		//*** Attach 'isDirty' plug-in
		self.thisForm.isDirty({
			saveButton: self.saveButton,
			returnUndoData: self.saveUndo,
			ignore: self.ignoreFields,
			onEscape: self.fieldUndone,
			onChange: self.fieldDirtyStatusChanged
		});
	}
	
	this.initContactParser = function () {
		if (self.contactParser == null) {
			return;
		}
		self.contactParserID = self.contactParser.attr("id")
		self.contactName.unbind('keyup change');
		self.contactName.bind("keyup change", function(evt) {
			self.currentKey = evt.keyCode;
			//*** Ignore cursor or tab keys
			if (evt.keyCode >= 37 && evt.keyCode <= 40 || evt.keyCode == 9) {
				return;
			}
			self.contactParser.css({ 
				display: 'inline-block'
			});
			if (!self.contactIsInit) {
				self.contactPanel = self.createPopPanel({
					panelSelector: self.contactParser,
					relativeSelector: self.contactName
				});
			}
			self.contactIsInit = true;
			self.contactPanel.show();
			//*** Do parse
			self.ajaxParse(self.contactName.val());
		}).keydown(function(evt) {
			//*** Hide the parser if the user tabs out of the field
			if (evt.keyCode == 9 && self.contactPanel.isShowing) {
				self.contactPanel.hide();
			}
		}).attr('autocomplete', 'off');
	}
	
	/*** Use list of self.dropDowns to create "selectPlus" controls (requires selectPlus plug-in)
	*		Format for self.dropDowns is:
	*		 [
	*			{ 
	*				selector: "#my_dropdown_selector_1",
	*				allowBlank: true
	*			},
	*			{
	*				selector: "#my_dropdown_selector_1",				
	*			}
	*		]
	*/
	this.initSelectPlusDropDowns = function () {
		if (self.dropDowns != null) {
			for (var i=0; i<self.dropDowns.length; i++) {
				var selector = self.dropDowns[i].selector;
				var allowBlank = self.dropDowns[i].allowBlank;
				$(selector).selectPlus({
					allowBlank: allowBlank
				});
			}
		}
	};

	this.initFormSave = function () {
		if (self.saveButton == null) {
			return;
		}
		self.saveButton.click(function() {
			var serialized = self.thisForm.serialize();
			$.ajax({ 
				url: self.ajaxURL,
				type: 'POST',
				data: "type=SAVE&" + serialized,
				success: function(data) {
					var dataObj = $.parseJSON(data);
					var hasChanges = false;
					if (dataObj.status == "SUCCESS") {
						if (typeof(dataObj.changes) != "undefined") {
							self.setChangedData(dataObj.changes);
							self.refreshDropDowns();
							hasChanges = true;
						}
						self.initForm();
						self.setFormDirtyIndicator(false);
						self.initContactParser();
						if (self.contactPanel != null) {
							self.contactPanel.hide();
						}
						if (typeof(self.onComplete) == "function") {
							self.onComplete(hasChanges);
						}
					} else {
						alert("Error saving record.");
					}
				}
	
			});
			//*** Return false to to prevent annoying event propigation
			return false;
		});
		
	};

	this.refreshChanges = function () {
		var $form = $(':input',self.formSelector);
		$form.each(function () {
			var field = this.name;
			if (self.changedData.hasOwnProperty(field)) {
				var value = self.changedData[field];
				$("#" + field).val(value);
			}
		});
	}
	
	this.refreshDropDowns = function () {
		if (self.dropDowns != null) {
			for (var i=0; i<self.dropDowns.length; i++) {
				var selector = self.dropDowns[i].selector;
				$(selector).trigger('disappear');
				self.populateList(selector);
			}
		}
	};
	
	this.saveUndo = function (data) {
		undoData = data;
	}
	
	this.setChangedData = function (changes) {
		self.changedData = changes;
	};

	this.setFormDirtyIndicator = function (isDirty) {
		if (self.formDirtyIndicator == null) {
			return;
		}
		var color = (isDirty) ? "red" : "#43e83b";
		self.formDirtyIndicator.css({ background: color });
	}
	
	this.__constructor = function () {
		self.formSelector = "#" + self.thisForm.attr("id");
		self.initFormSave();
		//*** See if the selectPlus plug-in is available
		if (jQuery().selectPlus) {
			self.initSelectPlusDropDowns();
		}
		self.initForm();
		self.initContactParser();
		self.setFormDirtyIndicator(false);
	}();
	
}