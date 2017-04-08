<?php
class Office extends MY_Controller {
	var $local_data = array();
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('office_model');
		$this->load->library('App');
		$this->load->library('AuditLog');
 	}

	public function ajax_auditlog() 
	{
		$this->office_model->get_auditlog();
	}

	public function ajax_office_manager() 
	{
		$this->office_model->get_office_info();
	}

	public function index()	{
		$this->local_data['title'] = "Office";
		$this->local_data['js_vars'] = $this->app->js_vars('office');
		$this->local_data['css'] = $this->app->css('office');
		$this->local_data['scripts'] = $this->app->scripts('office');
		
		$this->local_data['clear_x'] = base_url() . 'images/clear_x.png';
		
		//*** Load page using method from MY_Controller
 		$this->load_page('office/index', $this->local_data);
 	}

}