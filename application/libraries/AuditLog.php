<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_AuditLog extends CI_DataManager {
	var $user_id = null;
	var $table_name = null;
	var $is_subcontext = FALSE;
	
	public function __construct() 
	{
		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('delta');
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
			case "GET_list" :
				$sort_order = $this->get_request('sort_order');
				$search_terms = $this->get_request('search_terms');
				$table_name = $this->get_request('table_name');
				$key_field = $this->get_request('key_field');
				$key_value = $this->get_request('key_value');
				$data = $this->get_auditlog_for_item($sort_order,$search_terms,$table_name,$key_field,$key_value);
				//$data = array('audit_log_list' => $audit_log_list);
				
				$this->echo_output(json_encode($data));
				break;
			case "GET_log_entry" :
				$audit_id = $this->get_request('audit_id');
				$data = $this->get_full_log_entry($audit_id);

				$this->echo_output(json_encode($data));
				break;
		}
	}
	
	public function echo_output($data)
	{
		echo $data;
	}
	
	public function get_delta($from,$to)
	{
		return delta_html($from,$to);
	}
	
	public function get_full_log_entry($audit_id)
	{
		$log_data = array();
		$delta = null;
		$this->db->save_queries = FALSE;
		$this->db->from('site_audit_log');
		$this->db->select("*",FALSE);
		$this->db->where('audit_id',$audit_id);
		$query = $this->db->get();
		$results = $query->result_array();
		foreach ($results as $row) 
		{
			foreach ($row as $field => $value)
			{
				$log_data[$field] = (is_null($value)) ? "" : $value;
			}
		}
		//*** Get the data types of the table from which this log entry was drawn
		$data_types = $this->get_data_types($log_data['table_name']);
		$field_type = $data_types[$log_data['field_name']];
		if ($field_type == 'text' OR $field_type == 'longtext' OR strlen($log_data['change_from']) > 50 OR strlen($log_data['change_to']) > 50)
		{
			$delta = $this->get_delta($log_data['change_from'],$log_data['change_to']);
		}
		return array('log_entry' => $log_data, 'delta' => $delta);
	}
	
    public function get_auditlog_for_item($sort_order, $search_terms, $table_name, $key_field, $key_value)
    {
    	$audit_log_list = array();
		$id_field = "audit_id";
		$search_fields = array('change_date','field_label','change_from','change_to','user_id');
		$where_array = array('table_name' => $table_name, 'key_field' => $key_field, 'key_value' => $key_value);
		$column_label_array	= $this->get_field_labels($search_fields);
		$this->db->save_queries = FALSE;
		$members_list = array();
		$this->db->from('site_audit_log');
		$this->db->select("*",FALSE);
		if (!is_null($sort_order) && $sort_order != "") 
		$this->db->where($where_array);
		{
			switch (true)
			{ 
				case (strstr($sort_order,"contact_name")) :
					$sort_order = $this->correct_sort_order($sort_order,"contact_last_name","contact_first_name");
					break;
				case (strstr($sort_order,"member_name")) :
					$sort_order = str_replace("member_name","member_system_name",$sort_order);
					break;
			}
			$this->db->order_by($sort_order);
		}
		if (!is_null($search_terms)) 
		{
			foreach ($search_fields as $field)
			{
				$search_array[$field] = $search_terms;	
			}
			$q_string = $this->build_mixed_where($where_array,$search_array,TRUE);
			
			$this->db->where($q_string);
		}
		$query = $this->db->get();
		$results = $query->result_array();
		foreach ($results as $row) 
		{
			foreach ($row as $field => $value) 
			{
				//*** Any fields that must have special formatting are processed here
				switch ($field) 
				{
					case "change_date" :
						$value = date("m/d/Y g:i A",strtotime($value));
					case "change_from" :
					case "change_to" :
						$value = $this->truncate($value,40);
						break;
					default :
						break;
				}
				$col_info[$field] = (is_null($value)) ? "" : $value;
			}
			$audit_log_list[] = $col_info;
		}
		return array('id_field' => $id_field, 'data_list' => $audit_log_list, 'column_list' => $column_label_array);
    }
    
    public function get_field_labels($include = NULL)
    {
    	$labels = array();
    	$columns = $this->get_columns();
    	foreach ($columns as $field)
    	{
    		$skip = FALSE;
    		if (!is_null($include))
    		{
    			if (!in_array($field,$include))
    			{
    				$skip = TRUE;
    			}
    		}
    		if (! $skip)
    		{
    			$audit_table = "site_audit_log";
    			$labels[$field] = $this->lang->line($audit_table . "." . $field);
    		}
    	}
    	return $labels;
    }
	
	public function get_columns()
	{
		$columns = array();
		$sql = "SHOW COLUMNS IN site_audit_log;";
		$this->db->save_queries = FALSE;
		$query = $this->db->query($sql);
		foreach ($query->result() as $row)
		{
			$columns[] = $row->Field;
		}
		return $columns;
	}
	
	public function set_fields($key_field, $key_value, $sub_key_field = NULL, $sub_key_value = NULL)
	{
		$this->key_field = $key_field;
		$this->key_value = $key_value;
		$this->sub_key_field = $sub_key_field;
		$this->sub_key_value = $sub_key_value;
	}
	
	public function set_context($user_id, $table_name, $is_subcontext = FALSE)
	{
		$this->user_id = $user_id;
		$this->table_name = $table_name;
		$this->is_subcontext = $is_subcontext;
	}
	
	public function write_log ($field_name, $change_from, $change_to)
	{
		$data = array();
		$change_date = date("Y-m-d H:i:s");
		$data['user_id'] = $this->user_id;
		$data['table_name'] = $this->table_name;
		$data['key_field'] = $this->key_field;
		$data['key_value'] = $this->key_value;
		if ($this->is_subcontext)
		{
			$data['sub_key_field'] = $this->sub_key_field;
			$data['sub_key_value'] = $this->sub_key_value;
		}
		$data['field_name'] = $field_name;
		$data['field_label'] = $this->lang->line($this->table_name . "." . $field_name);
		$data['change_from'] = $change_from;
		$data['change_to'] = $change_to;
		$data['change_date'] = $change_date;
		//echo var_dump($data);
		
		$this->db->save_queries = FALSE;
		$this->db->insert('site_audit_log',$data);
		//$new_id = $this->db->insert_id();
		
	}
	
}