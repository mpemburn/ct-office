<?php

class Office_model extends CI_Model {

	public function __construct() {
		$this->load->database();
		$this->load->helper('text');
		//*** application/library/Office.php
		$this->load->library('DataManager');
		$this->load->library('AuditLog');
		$this->load->library('Office');
	}

	public function get_auditlog()	{
		return $this->auditlog->parse_request($_POST);
	}	
	
	public function get_office_info()	{
		return $this->office->parse_request($_POST);
	}
	
	public function get_dd_list($list_name, $param2 = NULL, $param3 = NULL)	{
		$list = null;
		switch ($list_name)
		{
			default :
				$list = $this->office->get_dd_list($list_name);
				break;
		}
		return $list;
	}	
		
	//*** Office list is accessed via AJAX in controller	
	public function get_office_list()	{
		$this->office->parse_request($_POST);
	}

	public function set_office() {
		$this->load->helper('url');
		
		$office_id = url_title($this->input->post('title'), 'dash', TRUE);
		
		$data = array(
			'office_name' => $this->input->post('office_name'),
			'office_id' => $office_id,
			'text' => $this->input->post('text')
		);
		
		return $this->db->insert('site_office', $data);
	}
}
