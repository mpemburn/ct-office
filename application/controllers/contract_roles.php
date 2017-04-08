<?php

class Contract_Roles extends MY_Controller {
	var $local_js_vars = null;
	var $local_data = array();

	function __construct()
	{
		parent::__construct();
		$this->load->config('ct_office');
		$this->load->helper('form');
		$this->load->model('contract_roles_model');
		$this->load->library('AppInclude');
		$this->load->library('DataManager');
		$this->load->library('Contract_Roles');
		$this->load->helper('url');
		$this->local_js_vars['continue_link'] = base_url() . "login";
	}

	public function ajax_contract_roles()
	{
		$this->contract_roles->parse_request($_POST);
	}

	function index()
	{
		$pdf_image = $this->config->item('image.url') . "pdf.png";
		$no_pdf_image = $this->config->item('image.url') . "no_pdf.png";
		$this->local_js_vars['pdf_image'] = $pdf_image;
		$this->local_js_vars['no_pdf_image'] = $no_pdf_image;
		$this->local_js_vars['data_url'] = $this->config->item('data.url');
		$this->local_data['title'] = "Contract Roles";
		$this->local_data['pdf_image'] = $pdf_image;
		$this->local_data['js_vars'] = $this->appinclude->js_vars('contract_roles', $this->local_js_vars);
		$this->local_data['css'] = $this->appinclude->css('contract_roles');
		$this->local_data['scripts'] = $this->appinclude->scripts('contract_roles');
		//*** Load page using method from MY_Controller
 		$this->load_page('contract_roles/index', $this->local_data);
	}

}
/*** End of Class contract_roles extends MY_Controller ***/
/*** End of File /application/controllers/contract_roles.php ***/