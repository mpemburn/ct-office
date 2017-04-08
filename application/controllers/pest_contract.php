<?php
class Pest_Contract extends MY_Controller {
	var $local_data = array();

	public function __construct() {
		parent::__construct();
		$this->load->model('pest_contract_model');
		$this->config->load('ct_office');
		$this->load->library('App');
		$this->load->library('DataManager');
		$this->load->library('ParseImagemap');
		$this->load->library('GenerateDocument');
		$this->load->library('Sales');
	}

	public function ajax_contract_layout() 
	{
		$this->pest_contract_model->get_contract_layout();
	}

	public function ajax_generate_contract() 
	{
		$this->pest_contract_model->generate_contract();
	}

	public function ajax_form_helper() 
	{
		$this->pest_contract_model->form_helper();
	}

	public function index()	{
		$this->local_data['title'] = "Pest Contract";
		$this->local_data['image_path'] = base_url() . 'images/';
		$this->local_data['js_vars'] = $this->app->js_vars('pest_contract', array('requiredImg' => $this->config->item('ct.office.required.image')));
		$this->local_data['css'] = $this->app->css('pest_contract');
		$this->local_data['scripts'] = $this->app->scripts('pest_contract');
		$this->local_data['document_image'] = $this->config->item('ct.office.pest_contract.image');
		$this->local_data['loading_image'] = $this->config->item('ct.office.loading.image');
		$this->local_data['no_really_image'] = $this->config->item('ct.office.no_really.image');
		$this->local_data['required_image'] = $this->config->item('ct.office.required.image');
		

		//*** Load page using method from MY_Controller.  "FALSE" in third argument aborts Header/Footer loading
 		$this->load_page('pest_contract/index', $this->local_data, FALSE);
	}

}