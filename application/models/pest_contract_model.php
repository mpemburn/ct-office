<?php

class Pest_Contract_model extends CI_Model {

	public function __construct() {
		$this->load->database();
		$this->load->helper('text');
	}

	public function get_contract_layout()	{
		return $this->parseimagemap->parse_request($_POST);
	}
	
	public function generate_contract()	{
		return $this->generatedocument->parse_request($_POST);
	}
	
	public function form_helper()	{
		return $this->sales->parse_request($_POST);
	}
	
	public function set_pest_contract() {
	}
}
