
/*
 * jQuery isDirty
 *
 * Copyright 2012, Pemburnia LLC
 *
 */
(function($){

	$.fn.extend({ 
		 
		//pass the options variable to the function
		isDirty: function(options) {
 
 
			//Set the default values, use comma to separate the settings, example:
			var defaults = {
				nameSubstitutes: null,
				saveButton : '#save',
				ignore: [],
				onEscape: null,
				onChange : null
			}
				 
			var options =  $.extend(defaults, options);
 
			return this.each(function() {
				var o = options;
				var formData = {};
				var changes = {};
				var selector = ":input";
				
				o.saveButton.attr('disabled',"disabled");
				
				if ($(this).get(0).tagName.toLocaleLowerCase() == "form") {
					$(selector, $(this)).each(function() {
						var name = $(this).attr("name");
						if (!inArray(o.ignore,name)) {
							var value = $(this).val();
							formData[name] = value;
							changes[name] = false;
						}
					});
				} else {
					selector = "#" + $(this).attr("id");
				}
				
				$(selector).unbind('change keyup soil').bind('change keyup soil', function(evt, arg1) {
					var name = $(this).attr("name");
					if (inArray(o.ignore,name)) {
						return;
					}
					var value = $(this).val();
					//*** If and ESC (keyCode 27) is passed, either directly or from a call to the 'soil' event, undo the field changes
					if (evt.keyCode == 27 || (evt.type == 'soil' && arg1 == 27)) {
						$(this).val(formData[name]);
						value = formData[name];
						if (typeof(o.onEscape) == "function") {
							o.onEscape(name,value);
						}
					}
					name = substituteName(name,o.nameSubstitutes);
					if (value != formData[name]) {
						changes[name] = true;
					} else {
						changes[name] = false;
					}
					var hasChanged = hasChanges(changes);
					if (hasChanged) {
						o.saveButton.removeAttr('disabled');
					} else {
						o.saveButton.attr('disabled',"disabled");
					}
					if (typeof(o.onChange) == "function") {
						o.onChange(hasChanged);
					}
				});
				
				if (typeof(returnUndoData) == "function") {
					returnUndoData(formData);
				}
			});
			
			function hasChanges(changeArray) {
				for (var field in changeArray) {
					if (changeArray.hasOwnProperty(field)) {
						if (changeArray[field]) {
							return true;
						}
					}
				}
				return false;
			};
			
			function inArray(thisArray, value) {
				for (var i=0; i<thisArray.length; i++) {
					if (thisArray[i] == value) {
						return true;
					}
				}
				return false;
			};
			
			function substituteName(inName, subArray) {
				var outName = inName
				if (subArray != null) {
					for (var name in subArray) {
						if (subArray.hasOwnProperty(name)) {
							if (name == inName) {
								outName = subArray[name];
							}
						}
					}
				}
				return outName;
			};
		}
	});
	
})(jQuery);