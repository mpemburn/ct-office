<?php

/* Generate MVC classes and associated files from stubs found in /mvc_stubs folder
 * 
 * USAGE: http://localhost/my_site/generate_mvc/index/my_new_mvc
 */

class Generate_Mvc extends MY_Controller {
	var $local_js_vars = null;
	var $local_data = array();

	function __construct()
	{
		parent::__construct();
		$this->load->config('ct_office');		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->library('AppInclude');
		$this->load->library('DataManager');
		$this->load->library('Generate_Mvc');
		$this->local_js_vars['continue_link'] = base_url() . "login";
		$this->local_js_vars['messages_ajax_url'] = base_url() . "/messages/ajax_message_manager";
	}

	public function ajax_offer() 
	{
		$this->offer->parse_request($_POST);
	}
	
	function index($mvc_name)
	{
		$this->local_data['title'] = "Generate_MVC";
		$this->local_data['js_vars'] = $this->appinclude->js_vars('', $this->local_js_vars);
		$this->local_data['css'] = $this->appinclude->css(NULL, array('jquery.snippet.css'));
		$this->local_data['scripts'] = $this->appinclude->scripts(NULL, array('jquery.snippet.js'));
		$gen_data = $this->generate_mvc->generate($mvc_name);
 		$this->load_page('generate_mvc/index', $this->local_data + $gen_data, TRUE);
	}
	
}		
//*** End of Class Generate_Mvc extends MY_Controller
//*** End of File /application/controllers/offer.php
