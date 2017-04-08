<?php

class Wdi_List extends MY_Controller {
	var $local_js_vars = null;
	var $local_data = array();

	function __construct()
	{
		parent::__construct();
		$this->load->config('ct_office');		
		$this->load->helper('form');
		$this->load->model('wdi_list_model');
		$this->load->library('AppInclude');
		$this->load->library('DataManager');
		$this->load->library('Wdi_List');
		$this->load->helper('url');
		$this->local_js_vars['continue_link'] = base_url() . "login";
	}

	public function ajax_wdi_list() 
	{
		$this->wdi_list->parse_request($_POST);
	}
	
	function index()
	{
		$this->local_data['title'] = "Wdi_List";
		$this->local_data['js_vars'] = $this->appinclude->js_vars('wdi_list', $this->local_js_vars);
		$this->local_data['css'] = $this->appinclude->css('wdi_list');
		$this->local_data['scripts'] = $this->appinclude->scripts('wdi_list');
		//*** Load page using method from MY_Controller
 		$this->load_page('wdi_list/index', $this->local_data);
	}
	
}		
/*** End of Class Wdi_List extends MY_Controller ***/
/*** End of File /application/controllers/wdi_list.php ***/