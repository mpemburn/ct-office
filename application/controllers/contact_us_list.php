<?php

class Contact_Us_List extends MY_Controller {
	var $local_js_vars = null;
	var $local_data = array();

	function __construct()
	{
		parent::__construct();
		$this->load->config('ct_office');		
		$this->load->helper('form');
		$this->load->model('contact_us_list_model');
		$this->load->library('AppInclude');
		$this->load->library('DataManager');
		$this->load->library('Contact_Us_List');
		$this->load->helper('url');
		$this->local_js_vars['continue_link'] = base_url() . "login";
	}

	public function ajax_contact_us_list() 
	{
		$this->contact_us_list->parse_request($_POST);
	}
	
	function index()
	{
		$this->local_data['title'] = "Contact_Us_List";
		$this->local_data['js_vars'] = $this->appinclude->js_vars('contact_us_list', $this->local_js_vars);
		$this->local_data['css'] = $this->appinclude->css('contact_us_list');
		$this->local_data['scripts'] = $this->appinclude->scripts('contact_us_list');
		//*** Load page using method from MY_Controller
 		$this->load_page('contact_us_list/index', $this->local_data);
	}
	
}		
/*** End of Class Contact_Us_List extends MY_Controller ***/
/*** End of File /application/controllers/contact_us_list.php ***/