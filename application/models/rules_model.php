<?php

class Rules_model extends CI_Model {

	public function __construct() {
		$this->load->database();
		$this->load->helper('text');
		$this->load->library('DataManager');
		$this->load->library('AuditLog');
 	}

	public function get_js_vars()
	{
		$output = "";
		$vars = array();
		$vars['max_rules'] = $this->db->count_all('site_vendor_resources');
		$vars['rules_ajax_url'] = base_url() . "rules/ajax_rules_manager";
		$vars['resources_ajax_url'] = base_url() . "rules/ajax_resources_manager";
		$vars['image_path'] = base_url() . "images";
		foreach ($vars as $key => $var)
		{
			$output .= "var " . $key . " = \"" . $var . "\";\n";
		}
		return $output;
	}
	
	public function get_vendors()
	{
		return $this->vendors->get_vendors();
	}
	
	public function get_resource($vendor_resource_id)
	{
		if ($vendor_resource_id === FALSE) {
			$query = $this->db->get('site_vendor_resources');
			$results = $query->result_array();
			$i = 0;
			foreach ($results as $row) {
				foreach ($row as $field => $value) {
					switch ($field) {
						default :
							$output[$i][$field] = $row[$field];
							break;
					}
				}
				$i++;
			}
			return $output;
		}
		$query = $this->db->get->where('vendor_resource_id', array('vendor_resource_id' => $vendor_resource_id));
		$results = $query->row_array();

		return $results;
	}
	
}
