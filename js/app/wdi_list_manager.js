function Wdi_ListManager(arg) {
	var self = this;
	
	this.ajaxURL = null;

	//*** Use the miracle of jQuery .extend() to add the values from 'arg' to the Wdi_ListManager object
	$.extend(this, arg);

	this.init = function () {
	};


	this.__constructor = function () {
		//*** Extend the BaseClass options object with an 'ajaxURL' property
		self.options.ajaxURL = self.ajaxURL;
		//*** Call the superconstructor
		BaseClass.call(this);

		self.init();
	}();
}
//*** Subclass Wdi_ListManager to BaseClass
Wdi_ListManager.prototype = new BaseClass();
Wdi_ListManager.constructor = Wdi_ListManager;
/*** End of File /js/app/wdi_list_manager.js ***/