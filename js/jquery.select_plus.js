/*
 * jQuery select_plus
 *
 * Copyright 2012, Pemburnia LLC
 *
 */
(function($){

	$.fn.extend({ 
		 
		//pass the options variable to the function
		selectPlus: function(options) {
 
 
			//Set the default values, use comma to separate the settings, example:
			var defaults = {
				allowBlank: false,
				onHidden: null,
				onVisible: null
			}
				 
			var options =  $.extend(defaults, options);
 
			return this.each(function() {
				var o = options;
				var $select = $(this);
				var $parent = $select.parent(); //.closest("div");
				var thisID = $select.attr("id");
				//*** Add plus sign after the select box
				$select.after("<span id=\"plus_sign_" + thisID + "\" style=\"font-size: 10pt;\">+</span>");
				//*** Apped the new input field to the select's parent form.  Name it "plus_" -- plus whatever the drop-down was named and id'ed
				$parent.append("<input type=\"text\" id=\"plus_" + thisID + "\">");
				if (!o.allowBlank) {
					$parent.append("<input type=\"hidden\" id=\"no_blank_" + thisID + "\" name=\"no_blank_" + thisID + "\" value=\"true\">");
				}
				var $plusInput = $("#plus_" + thisID);
				var $plusSign = $("#plus_sign_" + thisID);
				//*** Set the plus input box up
				$plusInput.css({
					width: $select.css('width'),
					visibility: 'hidden',
					zIndex: 999
				}).position({
					my: "left top",
					at: "left top",
					of: $select,
					offset: '-4 0'
				});
				//*** Set the plus sign control up
				$plusSign.css({
					cursor: 'pointer',
					fontWeight: 'bold',
					paddingLeft: '5px',
					paddingTop: '2px',
					width: '25px',
					textAlign: 'center',
					verticalAlign: 'center'
				}).live('click', function (e) {
					var sign = $(this).html();
					if (sign == "+") {
						//*** Add the 'name' attribute.  Processing will be needed to override the original drop-down value when user fill in the select-plus
						$plusInput.attr('name',"plus_" + thisID);
						$plusInput.css({ visibility : 'visible' });
						$plusInput.val($select.val()).select().focus();
						if (typeof(o.onVisible) == "function") {
							o.onVisible();
						}
					} else {
						//*** Remove the 'name' attribute so it's not passed when the form submits
						$plusInput.removeAttr('name');
						$plusInput.css({ visibility : 'hidden' });
						$plusInput.val("");
						if (typeof(o.onHidden) == "function") {
							o.onHidden();
						}
					}
					$(this).html((sign == "+") ? "&ndash;" : "+");
				});
				//*** Use this to reset the plus box (e.g., after an AJAX call) by calling with .trigger('disappear') on the original drop-down
				$select.bind('disappear', function(e) {
					$plusInput.css({ visibility : 'hidden' });
					$plusInput.val("");
					$plusSign.html("+");
				});
			});
			
		}
	});
	
})(jQuery);