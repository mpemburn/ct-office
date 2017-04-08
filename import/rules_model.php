<?php
require_once("constants.php");
require_once("DB_connect.php");
require_once("JSON.php");

$json = new Services_JSON;

$rules = new Rules($_REQUEST);
echo $json->encode($rules->get_output());

class Rules {
	var $conn = null;
	var $request;
	var $resource = null;
	var $resource_id = null;
	var $resource_name = null;
	var $rule_info = null;
	var $output = null;
	var $last_operation = false;
	
	public function __construct($request) {
		$this->load_database();
		$this->parse_request($request);
	}
	
	private function parse_request($request)
	{
		$this->request = $request;
		switch($this->get_request('type'))
		{
			case "GET" :
				$vr_id = $this->get_request('vendor_resource_id');
				if (!is_numeric($vr_id)) {
					$this->output = "ERROR during get: No vendor_resource_id";
					return;
				}
				$this->resource = $this->get_resource($vr_id);
				if (!is_null($this->resource))
				{
					$this->rule_info = $this->get_rules($this->resource['resource_id']);
					$this->output = array('resource' => $this->resource, 'rule_info' => $this->rule_info);
				}
				break;
			case "SAVE" :
				$this->set_rule();
				break;
		}
	}
	
	private function get_request($key)
	{
		 return isset($this->request[$key]) ? $this->request[$key] : null;
	}
	
	public function get_output()
	{
		return $this->output;
	}
	
	public function get_resource($vendor_resource_id)
	{
		$resource = null;
		$resource_id = null;
		$resource_name = null;
		$sql = "SELECT * FROM site_vendor_resources WHERE vendor_resource_id = " . $vendor_resource_id . ";";
		$results = mysql_query($sql,$this->conn);
		while ($row = mysql_fetch_assoc($results))
		{
			$resource_id = $row['resource_id'];
			$resource_name = $row['resource_name'];
		}
		if (!is_null($resource_id))
		{
			$resource = array('resource_id' => $resource_id, 'resource_name' => $resource_name);
		}
		return $resource;
	}
	
	public function get_columns()
	{
		$sql = "SHOW COLUMNS IN site_resource_rules;";
		$results = mysql_query($sql,$this->conn);
		$columns = array();
		
		while ($col_row = mysql_fetch_assoc($results))
		{
			$columns[] = $col_row['Field'];
		}
		return $columns;
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
	
	public function get_rules($resource_id)
	{
		$sql = "SELECT * FROM site_resource_rules WHERE resource_id = '" . $resource_id . "';";
		$rule_info = array();
		$rule_results = mysql_query($sql,$this->conn);
		
		while ($rule_row = mysql_fetch_assoc($rule_results))
		{
			$col_info = array();
			foreach ($rule_row as $field => $value) 
			{
				$col_info[$field] = (is_null($value)) ? "" : $value;
			}
			$rule_info[] = $col_info;
		}
		$rule_info[] = $this->get_entry_row();
		return $rule_info;
	}
	
	public function set_rule()
	{
		$data = array();
		$columns = $this->get_columns();
		foreach ($columns as $field)
		{
			$value = $this->get_request($field);
			switch ($field)
			{
				case "resource_rule_id" :
					$resource_rule_id = $value;
					break;
				default :
					if ($value != "")
					{
						$data[$field] = $value;
					}
					break;
			}
		}
		if ($resource_rule_id == "0")
		{
			$this->output = $this->db_insert('site_resource_rules',$data);
		}
		else
		{
			$this->db_where('resource_rule_id',$resource_rule_id);
			$this->output = $this->db_update('site_resource_rules',$data);
		}
	}
	
	private function db_insert($table_name, $data)
	{
		$output = "ERROR";
		foreach ($data as $field => $value)
		{
			if ($value != "")
			{
				$val = "'" . str_replace("'","''",$value) . "'";
				$fields[] = $field;
				$values[] = $val;
			}
		}
		$sql = "INSERT INTO " . $table_name . " (" . implode(",",$fields) . ") VALUES (" . implode(",",$values) . ");";
		$success = mysql_query($sql,$this->conn);
		if ($success)
		{
			$this->output = "SUCCESS";
			$new_id = mysql_insert_id($this->conn);
			$this->output .= ";" . $new_id;
			echo $this->output;
		}
	}
	
	private function db_update($table_name, $data)
	{
		$output = "ERROR";
		foreach ($data as $field => $value)
		{
			if ($value != "")
			{
				$val = "'" . str_replace("'","''",$value) . "'";
				$sets[] = $field . "=" . $val;
			}
		}
		$sql = "UPDATE " . $table_name . " SET " . implode(",",$sets) . $this->criteria . ";";
		$success = mysql_query($sql,$this->conn);
		$this->last_operation = "UPDATE";
		if ($success)
		{
			$output = "SUCCESS";
		}
		return $output;
	}
	
	private function db_where($field, $value)
	{
		$this->criteria = " WHERE " . $field . "='" . str_replace("'","''",$value) . "'";
	}
	
	private function load_database() {
		$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
		$this->conn = $db->get();
	}
	
} //*** End of class Rules
//*** END of FILE

