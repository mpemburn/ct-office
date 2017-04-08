<?php

class Pestimator_List extends MY_Controller {
	var $local_js_vars = null;
	var $local_data = array();

	function __construct()
	{
		parent::__construct();
		$this->load->config('ct_office');		
		$this->load->helper('form');
		$this->load->model('pestimator_list_model');
		$this->load->library('AppInclude');
		$this->load->library('DataManager');
		$this->load->library('Pestimator_List');
		$this->load->helper('url');
		$this->local_js_vars['continue_link'] = base_url() . "login";
	}

	public function ajax_pestimator_list() 
	{
		$this->pestimator_list->parse_request($_POST);
	}
	
	function index()
	{
		$this->local_data['title'] = "Pestimator_List";
		$this->local_data['js_vars'] = $this->appinclude->js_vars('pestimator_list', $this->local_js_vars);
		$this->local_data['css'] = $this->appinclude->css('pestimator_list');
		$this->local_data['scripts'] = $this->appinclude->scripts('pestimator_list');
		//*** Load page using method from MY_Controller
 		$this->load_page('pestimator_list/index', $this->local_data);
	}
	
}		
/*** End of Class Pestimator_List extends MY_Controller ***/
/*** End of File /application/controllers/pestimator_list.php ***/