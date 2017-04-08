<?php

class Sales_model extends CI_Model {

	public function __construct() {
		$this->load->database();
		$this->load->helper('text');
		//*** application/library/Sales.php
		$this->load->library('DataManager');
		$this->load->library('AuditLog');
		$this->load->library('Sales');
	}

	public function get_auditlog()	{
		return $this->auditlog->parse_request($_POST);
	}	
	
	public function get_field_labels()
	{
		return $this->auditlog->get_field_labels();
	}
	
	public function get_sales($sales_id)	{
		return $this->sales->get_sales($sales_id);
	}	
	
	public function get_dd_list($list_name, $param2 = NULL, $param3 = NULL)	{
		$list = null;
		switch ($list_name)
		{
			default :
				$list = $this->sales->get_dd_list($list_name);
				break;
		}
		return $list;
	}	
		
	//*** Sales list is accessed via AJAX in controller	
	public function get_sales_list()	{
		$this->sales->parse_request($_POST);
	}

	public function set_sales() {
		$this->load->helper('url');
		
		$sales_id = url_title($this->input->post('title'), 'dash', TRUE);
		
		$data = array(
			'sales_name' => $this->input->post('sales_name'),
			'sales_id' => $sales_id,
			'text' => $this->input->post('text')
		);
		
		return $this->db->insert('site_sales', $data);
	}
}
