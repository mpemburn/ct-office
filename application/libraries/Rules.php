<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_Rules extends CI_DataManager {
	var $conn = null;
	var $request;
	var $resource = null;
	var $resource_id = null;
	var $resource_name = null;
	var $rule_info = null;
	
	public function __construct() 
	{
		$this->load->database();
		$this->load->helper('json');
	}
	
	//*** Magic method __get gives us access to the parent CI object
    public function __get($var)    
    {
        static $CI;
        (is_object($CI)) OR $CI = get_instance();
        return $CI->$var;
    }
	
	public function parse_request($request)
	{
		//echo var_dump($request);
		if (sizeof($request) == 0) {
			$request = $_REQUEST;
		}
		$this->request = $request;
		switch($this->get_request('type'))
		{
			case "GET_by_vr_id" :
				$vr_id = $this->get_request('vendor_resource_id');
				if (!is_numeric($vr_id)) {
					$this->echo_output("ERROR during get: No vendor_resource_id");
					return;
				}
				$this->resource = $this->get_resource($vr_id);
			case "GET_by_resource_id" :
				$resource_id = $this->get_request('resource_id');
				$this->resource = $this->get_resource($resource_id);
			
				if (!is_null($this->resource))
				{
					$fiscal_year = $this->get_request('fiscal_year');
					$vendor_info = $this->get_vendor_info($this->resource['vendor_id']);
					$this->rule_info = $this->get_rules($this->resource['resource_id'],$fiscal_year);
					$data = array('resource' => $this->resource, 'rule_info' => $this->rule_info, 'vendor_info' => $vendor_info);
					
					$this->echo_output(json_encode($data));
				}
				break;
			case "SAVE" :
				$this->set_rule();
				break;
			case "DELETE" :
				$resource_rule_id = $this->get_request('resource_rule_id');
				$this->delete_rule($resource_rule_id);
				break;
		}
	}
	
	public function echo_output($data)
	{
		echo $data;
	}
	
	public function delete_rule($resource_rule_id) {
		$this->db->save_queries = false;
		$this->db->delete('site_resource_rules', array('resource_rule_id' => $resource_rule_id));
		$affected = $this->db->affected_rows();
		$success = ($affected == "1");
		if ($success) {
			$this->echo_output("SUCCESS");
		} else {
			$this->echo_output("ERROR: Could not delete record.");
		}
	}
	
	public function get_resource($id)
	{
		$this->db->save_queries = false;
		$resource = null;
		$where_array = (is_numeric($id)) ? array('vendor_resource_id' => $id) : array('resource_id' => $id);
		$query = $this->db->get_where('site_vendor_resources', $where_array);
		$results = $query->result_array();
		foreach ($results as $row) 
		{
			$vendor_id = $row['vendor_id'];
			$resource_id = $row['resource_id'];
			$resource_name = $row['resource_name'];
			$resource_has_children = $row['resource_has_children'];
		}
		if (!is_null($resource_id))
		{
			$resource = array('vendor_id' => $vendor_id, 'resource_id' => $resource_id, 'resource_name' => $resource_name, 'resource_has_children' => $resource_has_children);
		}
		return $resource;
	}
	
	public function get_rules($resource_id, $fiscal_year)
	{
		$this->db->save_queries = false;
		$rule_info = array();
		$query = $this->db->get_where('site_resource_rules', array('rule_fiscal_year' => $fiscal_year, 'resource_id' => $resource_id));
		$results = $query->result_array();
		foreach ($results as $row) 
		{
			//*** Any fields that must have specially formatting are processed here
			foreach ($row as $field => $value) 
			{
				switch ($field) 
				{
					case "rule_price" :
					case "rule_price_break" :
						$value = number_format($value,2,".",",");
						break;
				}
				$col_info[$field] = (is_null($value)) ? "" : $value;
			}
			$rule_info[] = $col_info;
		}
		$rule_info[] = $this->get_entry_row();
		return $rule_info;
	}
	
	public function get_columns()
	{
		return parent::get_columns("site_resource_rules");
	}
	
	public function get_entry_row()
	{
		$columns = $this->get_columns();
		$col_info = array();
		
		foreach ($columns as $column)
		{
			$col_info[$column] = "";
		}
		return $col_info;
	}
	
	public function get_vendor_info($vendor_id)
	{
		$vendor_info = null;
		$this->db->save_queries = false;
		$resource = null;
		$query = $this->db->get_where('site_vendors', array('vendor_id' => $vendor_id));
		$results = $query->result_array();
		foreach ($results as $row) 
		{
			foreach ($row as $field => $value) 
			{
				$vendor_info[$field] = (is_null($value)) ? "" : $value;
			}
		}
		return $vendor_info;
	}
	
	public function set_rule()
	{
		$data = array();
		$field_count = 0;
		$columns = $this->get_columns();
		foreach ($columns as $field)
		{
			$value = $this->get_request($field);
			switch ($field)
			{
				case "resource_rule_id" :
					$resource_rule_id = $value;
					break;
				case "rule_max_beds" :
				case "rule_max_sites" :
				case "rule_max_users" :
					if ($value == "∞")
					{
						$value = "-1";
					}
				case "rule_price" :
				case "rule_price_break" :
					$value = str_replace(array("$",","),"",$value);
				default :
					if ($value != "")
					{
						$data[$field] = $value;
						$field_count++;
					}
					break;
			}
		}
		if ($resource_rule_id == "0")
		{
			if ($field_count > 2)
			{
				$this->db->save_queries = false;
				$this->db->insert('site_resource_rules',$data);
				$new_id = $this->db->insert_id();
				$this->echo_output($new_id);
			}
		}
		else
		{
			//echo $resource_rule_id."\n";
			//echo var_dump($data);
			$this->db->save_queries = false;
			$this->db->where('resource_rule_id',$resource_rule_id);
			$this->db->update('site_resource_rules',$data);
			$affected = $this->db->affected_rows();
			if ($affected > 0) 
			{
				$this->echo_output("SUCCESS");
			}
		}
	}
	
} //*** End of class Rules
//*** END of FILE

