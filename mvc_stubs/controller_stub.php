<?php

class {ClassName} extends MY_Controller {
	var $local_js_vars = null;
	var $local_data = array();

	function __construct()
	{
		parent::__construct();
		$this->load->config('ct_office');		
		$this->load->helper('form');
		$this->load->model('{ModelName}');
		$this->load->library('AppInclude');
		$this->load->library('DataManager');
		$this->load->library('{ClassName}');
		$this->load->helper('url');
		$this->local_js_vars['continue_link'] = base_url() . "login";
	}

	public function ajax_{ClassNameToLower}() 
	{
		$this->{ClassNameToLower}->parse_request($_POST);
	}
	
	function index()
	{
		$this->local_data['title'] = "{ClassName}";
		$this->local_data['js_vars'] = $this->appinclude->js_vars('{ClassNameToLower}', $this->local_js_vars);
		$this->local_data['css'] = $this->appinclude->css('{ClassNameToLower}');
		$this->local_data['scripts'] = $this->appinclude->scripts('{ClassNameToLower}');
		//*** Load page using method from MY_Controller
 		$this->load_page('{ClassNameToLower}/index', $this->local_data);
	}
	
}		
/*** End of Class {ClassName} extends MY_Controller ***/
