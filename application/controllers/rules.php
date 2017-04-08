<?php
class Rules extends MY_Controller {
	var $local_data = array();

	public function __construct() {
		parent::__construct();
		$this->load->model('rules_model');
		$this->load->library('app');
		$this->load->library('rules');
		$this->load->library('resources');
		$this->load->library('vendors');
	}

	public function ajax_rules_manager() {
		$this->rules->parse_request($_POST);
	}
	
	public function ajax_resources_manager() {
		$this->resources->parse_request($_POST);
	}

	public function index()	{
		$this->local_data['title'] = 'Create Rules';
		$this->local_data['vendors'] = $this->rules_model->get_vendors();
		$this->local_data['js_vars'] = $this->rules_model->get_js_vars();
		$this->local_data['css'] = $this->app->css('rules');
		$this->local_data['scripts'] = $this->app->scripts('rules');
		//*** Menu items for header
		$this->local_data['members'] = base_url() . 'members';
		$this->local_data['rules'] = base_url() . 'rules';
		$this->local_data['logout'] = base_url() . 'login/logout';
		
		$this->local_data['back_arrow'] = base_url() . 'images/back_arrow.png';
		$this->local_data['fwd_arrow'] = base_url() . 'images/fwd_arrow.png';
		$this->local_data['spinner'] = base_url() . "images/ajax-loader.gif";
		
		//*** Load page using method from MY_Controller
 		$this->load_page('rules/index', $this->local_data);
	}

	public function view($vendor_resource_id)	{
		$this->local_data['rule_item'] = $this->rules_model->get_rules();
		if (empty($this->local_data['rule_item'])) {
			show_404();
		}
		$this->local_data['title'] = $this->local_data['rule_item']['title'];
	
		//*** Load page with no header or footer:
 		$this->load_page('rules/view', $this->local_data, FALSE);
	}
	
}