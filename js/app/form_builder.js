function FormBuilder(arg) {
	var self = this;
	var $self = this; // create second reference to use for jQuery objects

	//*** Use the miracle of jQuery .extend() to add the values from 'arg' to the FormBuilder object
	$.extend(this, arg);
	
	this.tabIndex = 1;
	this.insertAfter = null;
	this.lastInserted = null;
	this.postInsert = false;
	this.extendedTextareas = [];
	
	FormBuilder.prototype.create = function () {
		for (var field in self.mapArray) {
			
			self.createField({
				controlName: self.mapArray[field].field_name,
				xPercent: self.mapArray[field].coords.x,
				yPercent: self.mapArray[field].coords.y,
				width: self.mapArray[field].coords.width,
				height: self.mapArray[field].coords.height,
				inputType: self.mapArray[field].field_type,
				action: self.mapArray[field].action
			});
		}
		//*** Set flag to indicate that all controls inserted after this point are of the 'post insert' type
		self.postInsert = true;
	};
	
	this.addBlurEvent = function ($thisArea) {
		$thisArea.live('blur', function () {
			var $spec = $(this);
			var $test = $("#width_test");
			var thisID = $spec.attr("id");
			var thisLen = $spec.val().length;
			var specText = $spec.val();
			var specWidth = $spec.width();
			var specHeight = $spec.height();
				
			$test.css({ fontSize: $spec.css('fontSize'), width: specWidth });
			$test.html(specText);
			$spec.css({ height: ($test.height() > specHeight) ? $test.height() : specHeight });		
		});
	};

	this.createField = function (map) {
		if (map.action == "indirect") {
			return false;
		}
		map.fieldWidth = Math.round(self.imgWidth * (parseFloat(map.width,10) / 100));
		map.fieldHeight = Math.round(self.imgHeight * (parseFloat(map.height,10) / 100));
		var onePercentX = self.imgWidth / 100;
		var onePercentY = self.imgHeight / 100;
		var baseX = (parseInt(self.imgWidth,10) / 2) * -1;
		var baseY = (parseInt(self.imgHeight,10) / 2) * -1;
		var xPixels = 0;
		var yPixels = 0;
		var fieldType;
		var inputField = "<div id='" + map.controlName + "'></div>";
		var nextStep = {
			 isCC: false,
			 isCheck: false,
			 isDate: false,
			 isMY_Date: false,
			 isHidden: false,
			 isPlus: false,
			 isTrigger: false
		};
		var skipCSS = false
		var shiftRight = ['text','date','my_date','numeric_text','phone_text','dollar_text','cc_text','zip_text'];
		
		//is_mobile = true;
		switch (map.inputType) {
			case "coverup" :
				return;
				break;
			case "extensible_textarea" :
				map.controlName = map.controlName.addNumericSuffix();
				self.optional.push(map.controlName);
				inputField = "<textarea class='extensibleText' id='" + map.controlName + "' name='" + map.controlName + "'></textarea>";
				var $thisArea = $("#" + map.controlName);
				self.extendedTextareas.push("#" + map.controlName);
				//self.addBlurEvent($thisArea);
				nextStep.isPlus = true;
				break;
			case "extensible_dollar_text" :
				self.optional.push(map.controlName);
				fieldType = (is_mobile) ? "tel" : "text";
				inputField = "<input class='dollarUnderscore' type='" + fieldType + "' id='" + map.controlName + "' name='" + map.controlName + "' />";
				break;
			case "extensible_static_number" :
				self.optional.push(map.controlName);
				skipCSS = true;
				inputField = "<input type='text' class='staticNumber' id='" + map.controlName + "' name='" + map.controlName + "'>&nbsp;</div>";
				break;
			case "plus_button" :
				self.optional.push(map.controlName);
				skipCSS = true;
				inputField = "<div class='plusButton' id='" + map.controlName + "'>&nbsp;</div>";
				break;
			case "date" :
				inputField = "<input class='dateField' type='text' id='" + map.controlName + "' name='" + map.controlName + "' />";
				nextStep.isDate = true;
				break;
			case "my_date" :
				inputField = "<input class='dateField' type='text' id='" + map.controlName + "' name='" + map.controlName + "' />";
				nextStep.isMY_Date = true;
				break;
			case "cc_text" :
				fieldType = (is_mobile) ? "tel" : "text";
				inputField = "<input class='textField' type='" + fieldType + "' id='" + map.controlName + "' name='" + map.controlName + "' />";
				nextStep.isCC = true;
				break;
			case "text" :
				inputField = "<input class='textField' type='text' id='" + map.controlName + "' name='" + map.controlName + "' />";
				break;
			case "dollar_text" :
				fieldType = (is_mobile) ? "tel" : "text";
				inputField = "<input class='dollarText' type='" + fieldType + "' id='" + map.controlName + "' name='" + map.controlName + "' />";
				break;
			case "hidden_text" :
				inputField = "<input type='text' id='" + map.controlName + "' name='" + map.controlName + "' />";
				nextStep.isHidden = true;
				break;
			case "phone_text" :
				fieldType = (is_mobile) ? "tel" : "text";
				inputField = "<input class='phoneText' type='" + fieldType + "' id='" + map.controlName + "' name='" + map.controlName + "' />";
				break;
			case "numeric_text" :
				fieldType = (is_mobile) ? "tel" : "text";
				inputField = "<input class='numericText' type='" + fieldType + "' id='" + map.controlName + "' name='" + map.controlName + "' />";
				break;
			case "zip_text" :
				fieldType = (is_mobile) ? "tel" : "text";
				inputField = "<input class='zipText' type='" + fieldType + "' id='" + map.controlName + "' name='" + map.controlName + "' />";
				break;
			case "textarea" :
				inputField = "<textarea class='contractTextarea' id='" + map.controlName + "' name='" + map.controlName + "'></textarea>";
				break;
			case "checkbox" :
			case "service_checkbox" :
				nextStep.isCheck = true;
				map.xPercent = (is_mobile) ? map.xPercent : percentAdd(map.xPercent,0.4);
				inputField = "<input type='checkbox' class='serviceCheck' id='" + map.controlName + "' name='" + map.controlName + "' />";
				inputField += "<label for='" + map.controlName + "' class='checkLabel' id='" + map.controlName + "_label' name='" + map.controlName + "_label'>&nbsp;<label>";
				break;
			case "trigger_checkbox" :
				nextStep.isCheck = true;
				inputField = "<input class'triggerCheck' type='checkbox' id='" + map.controlName + "' name='" + map.controlName + "' />";
				break;
			case "select" :
				if (is_mobile) {
					//*** Move selects up a hair
					map.yPercent = percentAdd(map.yPercent,-0.3);
				}
				inputField = "<select class='selectField' id='" + map.controlName + "' name='" + map.controlName + "'/>";
				if (typeof(map.action) != "undefined" && map.action != null) {
					if (typeof(window[map.action]) == "function") {
						window[map.action](map.controlName);
					}
				}
				map.action = null;
				break;
		}
		//*** Add the current control to the 'self.required' list unless it's in the 'self.optional' list.
		if (!self.optional.in_array(map.controlName)) {
			self.required.push(map.controlName);
		}
		
		//*** Shift some input types a bit to the right and squeeze their map.fieldWidth for better display
		if (shiftRight.in_array(map.inputType)) {
			map.xPercent = percentAdd(map.xPercent,0.6);
			map.fieldWidth -= Math.round(onePercentX * 0.6);
		}
		//*** Calculate the top left corner of the field based on the size of the background (document) image
		xPixels = baseX + (map.fieldWidth / 2);
		xPixels += Math.round(self.imgWidth * (parseFloat(map.xPercent,10) / 100));
		yPixels = baseY + (map.fieldHeight / 2);
		yPixels += Math.round(self.imgHeight * (parseFloat(map.yPercent,10) / 100));
		
		$self.form.append("<div id='wrap_" + map.controlName + "'>" + inputField + "</div>");
		self.lastInserted = map.controlName;
		if (!skipCSS) {
			$("#" + map.controlName).css({ 
				display: 'block',
				backgroundColor: 'transparent',
				width: map.fieldWidth + 'px', 
				height: map.fieldHeight + 'px',
				verticalAlign: 'bottom',
				zIndex: '2' 
			}).attr("tabindex", self.tabIndex++);
		}
		
		$("#" + map.controlName).position({
			my: 'top left',
			at: 'top left',
			of: $(self.anchor),
			offset: xPixels + ' ' + yPixels
		}).die('click tap').bind('click tap', function () {
			if (typeof(map.action) != "undefined" && map.action != null) {
				if (typeof(window[map.action]) == "function") {
					window[map.action]($(this));
				}
			}
		});
		
		var $newControl = $("#" + map.controlName);
		this.doNext($newControl, nextStep, map);
		return $newControl;
	};
	
	this.doNext = function ($newControl, nextStep, farg) {
		if (nextStep.isCheck) {
			$("#" + farg.controlName).css({ width: (self.isMobile) ? farg.fieldWidth + 'px' : '1%' });
			$("#" + farg.controlName + "_label").css({
				width: farg.fieldWidth + 'px', 
				height: farg.fieldHeight + 'px',
			}).position({
				my: 'left top',
				at: 'left top',
				of: $("#" + farg.controlName)
			}).live('click tap', function () {
				$("#" + farg.controlName).trigger('click');
			});
		}	
		if (nextStep.isCC) {
			$("#" + farg.controlName).live("cut copy paste",function(e) {
				e.preventDefault();
			});
		}
		//*** Add a datepicker to the control
		if (nextStep.isDate) {
			$("#" + farg.controlName).die('focus').live('focus',function () {
				 $(this).blur(); 
			}).datepicker({
				//showButtonPanel: true
			});
		}
		//*** Add a Month/Year datepicker.
		if (nextStep.isMY_Date) {
			$("#" + farg.controlName).die('focus').live('focus',function () {
				 $(this).blur(); 
			}).datepicker( {
		        changeMonth: true,
		        changeYear: true,
		        showButtonPanel: true,
		        dateFormat: 'mm/yy',
		        onClose: function(dateText, inst) { 
		            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
		            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
		            $(this).datepicker('setDate', new Date(year, month, 1));
		        }
		    });
		}	
		if (nextStep.isHidden) {
			$("#" + farg.controlName).css({ visibil: 'hidden' });
		}
		if (nextStep.isPlus) {
			if (self.postInsert) {
				self.insertTabindex($newControl, self.insertAfter);
			}
			self.createExtensibleField(farg);
			self.insertAfter = self.lastInserted;
		}
	};
	
	this.createExtensibleField = function (farg) {
		if (self.postInsert) {
			self.insertAfter = farg.controlName;
		}
		//*** Save values from current field to be used in the 'click' event
		var saveArgs = $.extend({}, farg);
		var suffixNumber = saveArgs.controlName.getSuffixNumber();
		//*** Get the map data for the base field (i.e., without the numeric suffix).
		var extField = self.mapArray[farg.controlName.deleteNumericSuffix()];
		//*** If the extField object is available, the 'action' property will contain an array of fields
		var extString =  (typeof(extField) == "undefined") ? null : extField.action.toString().replace(/'/g,"\"");
		//'//*** Parse into an object
		var actionObj = (extString != null) ? $.parseJSON(extString) : null;
		//*** Get the 'companions' array if defined
		var companions = (actionObj != null) ? actionObj.companions : [];	
		//*** Get the 'maxHeight' if defined
		var maxHeight = (actionObj != null) ? actionObj.maxHeight.replace("%","") : null;
		
		//*** Set up the "plus control to be at the bottom left extensible field
		farg.controlName += "_plus";
		farg.inputType = "plus_button";
		farg.xPercent = self.percentAdd(farg.xPercent, -2);
		farg.yPercent = self.percentAdd(farg.yPercent, 2.5); //farg.height);
		farg.width = "1.5%";
		farg.height = "1.5%";
		
		//*** Create the plus control
		var $plusControl = self.createField(farg);

		for (var i=0; i<companions.length; i++) {
			var insertTab = false;
			//*** Get a clone of the companion object
			var thisMap = $.extend({}, self.mapArray[companions[i]]);
			var thisName = thisMap.field_name.addNumericSuffix(suffixNumber);
			if (thisMap.action == "indirect") {
				thisMap.action = "";
			}
			if (parseInt(suffixNumber,10) > 1) {		
				thisMap.coords.y = farg.yPercent;
				insertTab = true;
			}
			var $newControl = self.createField({
				controlName: thisName,
				xPercent: thisMap.coords.x,
				yPercent: saveArgs.yPercent,
				width: thisMap.coords.width,
				height: thisMap.coords.height,
				inputType: thisMap.field_type,
				action: thisMap.action
			});
			if (thisMap.field_type == "extensible_static_number") {
				$newControl.val(suffixNumber + ".").live('focus', function () { $(this).blur(); });
			}
			if (thisMap.field_type.indexOf("_text") != -1) {
				if (self.postInsert) {
					self.insertTabindex($newControl, self.insertAfter);
				}
				self.insertAfter = thisName;
			}
		}
		
		var controlHeight = self.calculateExtHeights();
		if (controlHeight > maxHeight) {
			$plusControl.css({ visibility: 'hidden' });
			return;
		}

		$plusControl.live('click touch', function (evt) {
			//*** Hide the current button
			$(this).css({ visibility: 'hidden' });
			saveArgs.yPercent = self.percentAdd(farg.yPercent, farg.height);
			var $newField = self.createField(saveArgs);
			$newField.focus();
			return false;
		});
		
		return true;
	};

	this.calculateExtHeights = function () {
		var $first = $(self.extendedTextareas[0]);
		var $last = $(self.extendedTextareas.last());
		var top = $first.offset().top;
		var lastTop = $last.offset().top;
		var lastHeight = $last.height();
		var totalHeight = (lastHeight + lastTop) - top;
		return (totalHeight / self.imgHeight) * 100;
	};

	this.insertTabindex = function ($newControl, insertAfterControl) {
		var formSelector = $self.form.selector;
		$(formSelector + " :input").each(function() {
			var $child = $(this);
			var thisID = $child.attr("id");
			var thisIndex = $child.attr("tabindex");
			if (thisID == insertAfterControl)  {
				$newControl.attr("tabindex", thisIndex);
				thisIndex++;
			}
			if (thisID != insertAfterControl) {
				$child.attr("tabindex", thisIndex);
			}
		});
	};

	this.percentAdd = function (inPercent, addTo) {
		var floatPercent = parseFloat(inPercent.replace("%",""),10);
		var floatAdd = parseFloat(addTo.toString().replace("%",""),10);
		return (floatPercent + floatAdd) + "%";
	};

	this.__constructor = function () {
		self.create();
	}();
}
