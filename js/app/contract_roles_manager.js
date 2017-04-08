function Contract_Roles_Manager(arg) {
	var self = this;
	var listManager = null;
	var detailDiv = null;
	var rowCount = null
	var numRows = 0;
	var pageVars = [];
	var firstCall = false;
	var dateCall = false;
	var dataURL = null;
	var currentRoleName = '';
	var currentRoleId = null;

	this.ajaxURL = null;

	//*** Use the miracle of jQuery .extend() to add the values from 'arg' to the Contact_Us_ListManager object
	$.extend(this, arg);

	this.init = function () {
		self.firstCall = true;
		self.detailDiv = $("#contract_roles_detail");
		self.rowCount = $("#row_count");
		self.detailDiv.css({ display : 'none' });
		self.loadList();
		self.setEvents();
	};

	this.clearList = function() {
		$('#contract_roles_list_container').empty();
	};

	this.loadList = function() {
		self.listManager = new ListManager({
			ajaxURL: self.ajaxURL,
			tag: 'contract_roles',
			getType: 'GET_list',
			accordion: true,
			oneAtATime: true,
			tableWidth: '100%',
			defaultSort: 'time_stamp DESC',
			detailCallback: self.retrieveDetailData,
			onDataCallback: self.listLoaded
		});
	};

	this.listLoaded = function (dataLen, extraData, rowData) {
		self.numRows = rowData.length;
		self.rowCount.html(self.numRows);
		// Re-open the row detail if this was an update
		if (self.currentRoleId != null) {
			$('#contract_roles_data_' + self.currentRoleId).trigger('click');
		}
	};

	this.addRoleDialog = function (callback) {
		// First, clear all values from the form
		$('form[name=add_role]').find('input, select').val('');
		$('#add_role_dialog').dialog({
			title: "Add Role",
			modal: true,
			width: '400px',
			buttons: {
				"Cancel": function() { $(this).dialog("close") },
				"OK": function() {
					$(this).dialog("close");
					if (typeof(callback) == 'function') {
						callback();
					}
				}
			}
		});
	};


	this.addRole = function () {
		var data = $('form[name=add_role]').first().serialize();
		self.ajaxCall({
			url: self.ajaxURL,
			data: "type=ADD_role&" + data,
			callback: function (dataObj) {
				self.currentRoleId = (dataObj.role_id) ? dataObj.role_id : 0;
				self.clearList();
				self.loadList();
			}
		});
	};

	this.removeRole = function (roleID) {
		self.ajaxCall({
			url: self.ajaxURL,
			data: "type=DELETE_role&role_id=" + roleID,
			callback: function (dataObj) {
			}
		});
	};

	this.updateRole = function (roleID) {
		var data = $('form[name=role_detail]').first().serialize();
		self.ajaxCall({
			url: self.ajaxURL,
			data: "type=UPDATE_role&" + data,
			callback: function (dataObj) {
				self.clearList();
				self.loadList();
			}
		});
	};

	this.retrieveDetailData = function (roleID, $cell) {
		self.ajaxCall({
			url: self.ajaxURL,
			data: "type=GET_detail&role_id=" + roleID,
			callback: function (dataObj) {
				var data = dataObj.data;
				var html = self.detailDiv.html();
				$cell.html(html);
				for (var key in data) {
					if (data.hasOwnProperty(key)) {
						var value = data[key];
						$('#' + key).val(value);
					}
				}
				self.currentRoleName = $('#first_name').val() + ' ' + $('#last_name').val();
				self.currentRoleId = data.id;
				self.setEvents();
				$cell.show();
				//*** Hide the 'loading' spinner
				$('[id^="wait"]').css({ backgroundImage: 'none' });
			}
		});
	};

	this.setEvents = function() {
		$('#button_add_role').off().on('click', function () {
			self.addRoleDialog(self.addRole);
		});
		$('#button_update_role').off().on('click', function () {
			self.updateRole(self.currentRoleId);
		});
		$('#button_remove_role').off().on('click', function () {
			self.confirmDialog('Are you sure you want to remove ' + self.currentRoleName + '?',
			function() {
				$('#contract_roles_data_' + self.currentRoleId).remove();
				$('#accordion_contract_roles_' + self.currentRoleId).remove();
				self.removeRole(self.currentRoleId);
			});
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
//*** Subclass contract_rolesManager to BaseClass
Contract_Roles_Manager.prototype = new BaseClass();
Contract_Roles_Manager.constructor = Contract_Roles_Manager;
/*** End of File /js/app/contract_roles_manager.js ***/
