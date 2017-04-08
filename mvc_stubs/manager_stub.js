function {ClassName}Manager(arg) {
	var self = this;
	
	this.ajaxURL = null;

	//*** Use the miracle of jQuery .extend() to add the values from 'arg' to the {ClassName}Manager object
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
//*** Subclass {ClassName}Manager to BaseClass
{ClassName}Manager.prototype = new BaseClass();
{ClassName}Manager.constructor = {ClassName}Manager;
