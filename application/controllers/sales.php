<?php
class Sales extends MY_Controller {
	var $local_data = array();
	
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('sales_model');
		$this->load->library('App');
		$this->load->library('AuditLog');
		$this->load->library('GenerateDocument');
 	}

	public function ajax_auditlog() 
	{
		$this->sales_model->get_auditlog();
	}

	public function ajax_sales_manager() 
	{
		$this->sales_model->get_sales_list();
	}

	public function index()	{
	
		$this->local_data['title'] = "Sales";
		$this->local_data['js_vars'] = $this->app->js_vars('sales_main');
		$this->local_data['css'] = $this->app->css('sales');
		$this->local_data['scripts'] = $this->app->scripts('sales');
		//*** Menu items for header
		$this->local_data['sales'] = base_url() . 'sales';
		$this->local_data['rules'] = base_url() . 'rules';
		$this->local_data['logout'] = base_url() . 'login/logout';
		
		$this->local_data['clear_x'] = base_url() . 'images/clear_x.png';
		$this->local_data['contract_links'] = $this->config->item('ct.office.contract.links');
		
		//*** Load page using method from MY_Controller
 		$this->load_page('sales/index', $this->local_data);
 	}
	
	 public function test_mail()
	 {
		 $contract_array = array(
			'residence_customer_name' => "Mike Shrike",
			'residence_street_address' => "101 Downstreet St.",
			'residence_city' => "Baltimore",
			'residence_state' => "MD",
			'residence_zip' => "21101",
			'cc_encrypted' => "fafdfefafef192"
		 );
		//*** Send copy and notification to office
		$body = $this->config->item('ct.office.to.office.contract.email.body');
		$body = $this->utilities->replace_vars($body, $contract_array);
		$subject = $this->config->item('ct.office.to.office.contract.email.subject');
		$subject = $this->utilities->replace_vars($subject, $contract_array);
		$attach = FCPATH . "data/gregory_bailey__cdp_10-02-2013.pdfx";
		echo $subject;
		//return;
		$success = $this->generatedocument->send_email_new("support@centurytermite.com", "mark@pemburn.com,mpemburn@gmail.com", $subject, $body, $attach);
		echo "<br>" .$success;
	 }

}