<?php

class Contract_List extends MY_Controller {
	var $local_js_vars = null;
	var $local_data = array();

	function __construct()
	{
		parent::__construct();
		$this->load->config('ct_office');		
		$this->load->helper('form');
		$this->load->model('contract_list_model');
		$this->load->library('AppInclude');
		$this->load->library('DataManager');
		$this->load->library('Contract_List');
		$this->load->helper('url');
		$this->local_js_vars['continue_link'] = base_url() . "login";
	}

	public function ajax_contract_list() 
	{
		$this->contract_list->parse_request($_POST);
	}
	
	function index()
	{
		$pdf_image = $this->config->item('image.url') . "pdf.png";
		$no_pdf_image = $this->config->item('image.url') . "no_pdf.png";
		$this->local_js_vars['pdf_image'] = $pdf_image;
		$this->local_js_vars['no_pdf_image'] = $no_pdf_image;
		$this->local_js_vars['data_url'] = $this->config->item('data.url');
		$this->local_data['title'] = "Contract_List";
		$this->local_data['pdf_image'] = $pdf_image;
		$this->local_data['js_vars'] = $this->appinclude->js_vars('contract_list', $this->local_js_vars);
		$this->local_data['css'] = $this->appinclude->css('contract_list');
		$this->local_data['scripts'] = $this->appinclude->scripts('contract_list');
		//*** Load page using method from MY_Controller
 		$this->load_page('contract_list/index', $this->local_data);
	}
	
}		
/*** End of Class Contract_List extends MY_Controller ***/
/*** End of File /application/controllers/contract_list.php ***/