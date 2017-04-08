<?php
class App_Form extends MY_Controller {
	var $local_data = array();
	var $sharedJSVars;

	public function __construct() {
		parent::__construct();
		$this->load->model('app_form_model');
		$this->config->load('ct_office');
		$this->load->library('App');
		$this->load->library('DataManager');
		$this->load->library('ParseImagemap');
		$this->load->library('GenerateDocument');
		$this->load->library('Sales');
		$this->sharedJSVars = array(
			'requiredImg' => $this->config->item('ct.office.required.image'),
			'plusImg' => $this->config->item('ct.office.plus.image')
		);
	}

	public function ajax_contract_layout() 
	{
		$this->app_form_model->get_contract_layout();
	}

	public function ajax_generate_contract() 
	{
		$this->app_form_model->generate_contract();
	}

	public function ajax_form_helper() 
	{
		$this->app_form_model->form_helper();
	}

	public function pest_contract()	{
		$this->local_data['title'] = "Pest Control Agreement";
		$this->local_data['image_path'] = base_url() . 'images/';
		$services_count_1 = $this->config->item('ct.office.pest_contract.default.number.of.services_1');
		$services_count_2 = $this->config->item('ct.office.pest_contract.default.number.of.services_2');
		$this->local_data['js_vars'] = $this->app->js_vars('app_form', array('document_name' => "pest_contract", 'services_count_1' => $services_count_1, 'services_count_2' => $services_count_2) + $this->sharedJSVars);
		$this->local_data['css'] = $this->app->css('app_form');
		$this->local_data['scripts'] = $this->app->scripts('app_form');
		$this->local_data['contract_type'] = "pest_contract";
		$this->local_data['document_identifier'] = $this->config->item('ct.office.pest_contract.identifier');
		$this->local_data['document_image'] = $this->config->item('ct.office.pest_contract.image');
		$this->local_data['loading_image'] = $this->config->item('ct.office.loading.image');
		$this->local_data['no_really_image'] = $this->config->item('ct.office.no_really.image');
		$this->local_data['required_image'] = $this->config->item('ct.office.required.image');		

		//*** Load page using method from MY_Controller.  "FALSE" in third argument aborts Header/Footer loading
 		$this->load_page('app_form/document_template', $this->local_data, FALSE);
	}

	public function termite_contract()	{
		$this->local_data['title'] = "Termite Re-Treatment Guarantee";
		$this->local_data['image_path'] = base_url() . 'images/';
		$this->local_data['js_vars'] = $this->app->js_vars('app_form', array('document_name' => "termite_contract") + $this->sharedJSVars);
		$this->local_data['css'] = $this->app->css('app_form');
		$this->local_data['scripts'] = $this->app->scripts('app_form');
		$this->local_data['contract_type'] = "termite_contract";
		$this->local_data['document_identifier'] = $this->config->item('ct.office.termite_contract.identifier');
		$this->local_data['document_image'] = $this->config->item('ct.office.termite_contract.image');
		$this->local_data['loading_image'] = $this->config->item('ct.office.loading.image');
		$this->local_data['no_really_image'] = $this->config->item('ct.office.no_really.image');
		$this->local_data['required_image'] = $this->config->item('ct.office.required.image');
		

		//*** Load page using method from MY_Controller.  "FALSE" in third argument aborts Header/Footer loading
 		$this->load_page('app_form/document_template', $this->local_data, FALSE);
	}

	public function construction_contract()	{
		$this->local_data['title'] = "Construction Division Proposal";
		$this->local_data['image_path'] = base_url() . 'images/';
		$this->local_data['js_vars'] = $this->app->js_vars('app_form', array('document_name' => "construction_contract") + $this->sharedJSVars);
		$this->local_data['css'] = $this->app->css('app_form');
		$this->local_data['scripts'] = $this->app->scripts('app_form');
		$this->local_data['contract_type'] = "construction_contract";
		$this->local_data['document_identifier'] = $this->config->item('ct.office.construction_contract.identifier');
		$this->local_data['document_image'] = $this->config->item('ct.office.construction_contract.image');
		$this->local_data['loading_image'] = $this->config->item('ct.office.loading.image');
		$this->local_data['no_really_image'] = $this->config->item('ct.office.no_really.image');
		$this->local_data['required_image'] = $this->config->item('ct.office.required.image');
		

		//*** Load page using method from MY_Controller.  "FALSE" in third argument aborts Header/Footer loading
 		$this->load_page('app_form/document_template', $this->local_data, FALSE);
	}

}