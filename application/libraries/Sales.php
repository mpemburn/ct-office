<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_Sales extends CI_DataManager {
	var $request;
	var $resource = null;
	var $resource_id = null;
	var $resource_name = null;
	var $sales_info = null;
	var $user_id = null;
	
	public function __construct() 
	{
		$this->load->database();
		$this->load->library('AuditLog');
		$this->load->library('Contacts');
		$this->load->library('NameParser');
		$this->load->helper('json');
		$this->config->load('ct_office');
		
		$user_data = $this->session->userdata('currentsession','sales_info');
		$this->user_id = $user_data['user_username'];
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
				$data = $this->get_sales_list($sort_order,$search_terms);
				//$data = array('sales_list' => $sales_list);
				
				$this->echo_output(json_encode($data));
				break;
			case "GET_ddlist" :
				$list_name = $this->get_request('list_name');
				$data = $this->get_dd_list($list_name);
				
				$this->echo_output(json_encode($data));
				break;
			case "GET_parse_contact" :
				$conctact_name = $this->get_request('primary_contact_name');
				$data = $this->parse_name($conctact_name);
				
				$this->echo_output(json_encode($data));
				break;
			case "SAVE" :
				$this->request['type'] = "";
				$mdata = $this->set_sales();
				$this->contacts->parse_request($this->request);
				$cdata = $this->contacts->set_contact(TRUE);
				$data = array_merge($mdata,$cdata);
				$this->echo_output(json_encode($data));
				break;
			case "DELETE" :
				$sales_id = $this->get_request('sales_id');
				$this->archive_sales($sales_id);
				break;
		}
	}
	
	public function echo_output($data)
	{
		echo $data;
	}
	
	public function add_new_state($state_name)
	{
		/*
		UPDATE `site_states` SET valid_state = 0 WHERE 1;
		UPDATE `site_states` SET valid_state = 1 WHERE `state_code` IN('DE','NJ','PA');	
		*/
		$this->db->save_queries = false;
		$this->db->where('state_code', $state_name);
		$this->db->or_where('state_name', $state_name); 
		$this->db->update('site_states',array('valid_state' => "1"));
		return $this->get_state_code($state_name);
	}
	
	public function add_new_system($system_name)
	{
		if ($system_name != "" && $system_name != "0")
		{
			$this->db->save_queries = false;
			$this->db->insert('site_systems',array('system_name' => $system_name));
			$new_id = $this->db->insert_id();
		}
		return $system_name;
	}
	
	public function archive_sales($sales_id) {
		$this->db->save_queries = false;
		//$this->db->delete('site_sales', array('sales_id' => $sales_id));
		$affected = $this->db->affected_rows();
		$success = ($affected == "1");
		if ($success) {
			$this->echo_output("SUCCESS");
		} else {
			$this->echo_output("ERROR: Could not delete record.");
		}
	}
	
	public function get_dd_list($list_name)
	{
		$out_list = null;
		switch ($list_name)
		{
			case "tech_name" :
			case "ct_representative" :
				$out_list = $this->get_contract_roles();
				break;
			default :
				$list = $this->config->item('ct.office.' . $list_name);
				if (is_array($list))
				{
					$list_array = $list;
					$out_list = array_flip($list_array);
				}
				else
				{
					$list_array = explode(",",$list);
					$out_list = array_flip($list_array);
				}
				//echo var_dump($out_list);
				foreach ($out_list as $key => $index)
				{
					$out_list[$key] = $list_array[$index];
				}
				break;
		}
		$out_list = array('' => '(select)') + $out_list;
		return $out_list;
	}

	public function get_contract_roles()
	{
		$roles = array();
		$this->db->save_queries = false;
		$this->db->select('*')->from('cto_contract_roles')->order_by('role DESC, last_name, first_name');
		$query = $this->db->get();
		$results = $query->result_array();
		foreach ($results as $row)
		{
			$name = $row['first_name'] . ' ' . $row['last_name'];
			$roles[$name] = $name;
		}
		return $roles;
	}

	public function get_sales($sales_id)
	{
		$sales_info = null;
		$select_fields = "*,";
		$select_fields .= 'CONCAT(IF(LENGTH(C.contact_prefix) > 0,CONCAT(C.contact_prefix," "),""),C.contact_first_name," ",C.contact_last_name) AS contact_name,';
		$select_fields .= 'IF(LENGTH(system_name) > 0,CONCAT(system_name,"-",sales_name),sales_name) AS sales_system_name';
		$search_array = array();
		$search_fields = array('sales_name','system_name','contact_id','contact_prefix','contact_first_name','contact_middle_name','contact_last_name','contact_suffix','email','address_1','city','state','zip','notes');
		$this->db->save_queries = false;
		$sales_info = array();
		$this->db->from('site_sales AS M');
		$this->db->join('site_sales_contacts AS MC', 'M.sales_id = MC.sales_id', 'INNER');
		$this->db->join('site_contacts AS C', 'C.contact_id = MC.contact_id', 'INNER');
		$this->db->select($select_fields,FALSE);
		$this->db->where('M.sales_id', $sales_id);
		$query = $this->db->get();
		$results = $query->result_array();
		foreach ($results as $row) 
		{
			foreach ($row as $field => $value) 
			{
				//*** Any fields that must have special formatting are processed here
				switch ($field) 
				{
					default :
						break;
				}
				$sales_info[$field] = (is_null($value)) ? "" : $value;
			}
		}
		$this->session->set_userdata(array('sales_info' => $sales_info));
		return array('sales_info' => $sales_info);
	}
	
	public function get_sales_list($sort_order = NULL, $search_terms = NULL)
	{
		$id_field = "sales_id";
		$column_label_array = array(
			'sales_name' => "Member",
			'system_name' => "System",
			'contact_name' => "Contact",
			'address_1' => "Address",
			'city' => "City",
			'state' => "State   ",
			'zip' => "Zip",		
		);
		$select_fields = "M.sales_id, sales_name, system_name, email, address_1, city, state, zip,";
		$select_fields .= 'CONCAT(IF(LENGTH(C.contact_prefix) > 0,CONCAT(C.contact_prefix," "),""),C.contact_first_name," ",C.contact_last_name) AS contact_name,';
		$select_fields .= 'IF(LENGTH(system_name) > 0,CONCAT(system_name,"-",sales_name),sales_name) AS sales_system_name';
		$search_array = array();
		$search_fields = array('sales_name','system_name','contact_first_name','contact_last_name','email','address_1','city','state','zip','notes');
		$this->db->save_queries = false;
		$sales_list = array();
		$this->db->from('site_sales AS M');
		$this->db->join('site_sales_contacts AS MC', 'M.sales_id = MC.sales_id', 'INNER');
		$this->db->join('site_contacts AS C', 'C.contact_id = MC.contact_id', 'INNER');
		$this->db->select($select_fields,FALSE);
		if (!is_null($sort_order) && $sort_order != "") 
		{
			switch (true)
			{ 
				case (strstr($sort_order,"contact_name")) :
					$sort_order = $this->correct_sort_order($sort_order,"contact_last_name","contact_first_name");
					break;
				case (strstr($sort_order,"sales_name")) :
					$sort_order = str_replace("sales_name","sales_system_name",$sort_order);
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
			$this->db->or_like($search_array);
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
					case "sales_name" :
						$value = $this->truncate($value,40);
						break;
					default :
						break;
				}
				$col_info[$field] = (is_null($value)) ? "" : $value;
			}
			$sales_list[] = $col_info;
		}
		return array('id_field' => $id_field, 'data_list' => $sales_list, 'column_list' => $column_label_array);
	}
	
	public function get_columns()
	{
		return parent::get_columns("site_sales");
	}
	
	public function get_state_code($name_or_code)
	{
		$state_code = null;
		$this->db->save_queries = false;
		$this->db->select('state_code')->from('site_states')->where('state_name',$name_or_code)->or_where('state_code',$name_or_code);
		$query = $this->db->get();
		$results = $query->result_array();
		foreach ($results as $row)
		{
			$state_code = $row['state_code'];
		}
		return $state_code;
	}
	
	public function get_states()
	{
		$states = array();
		$this->db->save_queries = false;
		$this->db->select('*')->from('site_states')->where('valid_state = 1')->order_by('state_name');
		$query = $this->db->get();
		$results = $query->result_array();
		foreach ($results as $row)
		{
			$states[$row['state_code']] = $row['state_name'];
		}
		return $states;
	}

	public function get_systems()
	{
		$systems = array();
		$this->db->save_queries = false;
		$this->db->select('*')->from('site_systems')->order_by('system_name');
		$query = $this->db->get();
		$results = $query->result_array();
		$systems[''] = "";
		foreach ($results as $row)
		{
			$systems[$row['system_name']] = $row['system_name'];
		}
		return $systems;
	}
	
	public function insert_new_state($field_name, $value)
	{
		$state_code = $value;
		if ($field_name == "state") {
			$states = $this->get_states();
			if (!in_array($value,$states) OR array_key_exists($value,$states))
			{
				$state_code = $this->add_new_state($value);
			}
		}
		return $state_code;
	}
	
	public function insert_new_system($field_name, $value)
	{
		$system_name = $value;
		if ($field_name == "system_name") {
			$systems = $this->get_systems();
			if (!in_array($value,$systems))
			{
				$system_name = $this->add_new_system($value);
			}
		}
		$system_name = ($system_name === "0") ? "" : $system_name;
		return $system_name;
	}
	
	public function parse_name($name)
	{
		$this->nameparser->parse($name);
		$parsed = array(
			'contact_prefix' => $this->nameparser->getTitle(),
			'contact_first_name' => $this->nameparser->getFirstName(),
			'contact_middle_name' => $this->nameparser->getMiddleName(),
			'contact_last_name' => $this->nameparser->getLastName(),
			'contact_suffix' =>$this->nameparser->getSuffix(),
		);
		return array('status' => "SUCCESS", 'parsed' => $parsed);	
	}
	
	public function set_sales($referred = FALSE)
	{
		//echo var_dump($_REQUEST);
		$out_array = array();
		$data = array();
		$field_count = 0;
		$columns = $this->get_columns();
		$this->request = $this->process_plus_fields($this->request);
		foreach ($columns as $field)
		{
			$value = $this->get_request($field);
			//echo $field." = ".$value."\n";
			switch ($field)
			{
				case "sales_id" :
					$sales_id = $value;
					break;
				case "state" :
					$value = $this->insert_new_state("state", $value);
					$data[$field] = $value;
					$field_count++;
					break;
				case "system_name" :
					$value = $this->insert_new_system("system_name", $value);
					$data[$field] = $value;
					$field_count++;
					break;
				default :
					$data[$field] = $value;
					$field_count++;
					break;
			}
			//$data[$field] = ($value == "") ? NULL : $value;
			//$field_count++;
		}
				//echo var_dump($data);
		if ($sales_id == "0")
		{
			if ($field_count > 2)
			{
				$this->db->save_queries = false;
				$this->db->insert('site_sales',$data);
				$new_id = $this->db->insert_id();
				if (!$referred)
				{
					$out_array['status'] = "SUCCESS";
				}
				$out_array['sales_id'] = $new_id;
				//$this->echo_output($new_id);
			}
		}
		else
		{
			//*** UPDATE current record
			$this->db->save_queries = false;
			$this->db->where('sales_id',$sales_id);
			$this->db->update('site_sales',$data);
			if (!$referred)
			{
				$out_array['status'] = "SUCCESS";
			}
			$affected = $this->db->affected_rows();
			if ($affected > 0) 
			{
				$changed_values = $this->update_audit_log($sales_id,$data);
				$this->session->set_userdata(array('sales_info' => $data));
				$out_array['changes'] = $changed_values;
			}
		}
		return $out_array;
	}
	
	public function set_saleship($mArray)
	{
		//echo var_dump($mArray);
		$this->db->save_queries = false;
		if ($mArray['saleship_tally_id'] == 0)
		{ 
			$this->db->insert('site_saleship_tally',$mArray);
		}
		else
		{
			$this->db->where('saleship_tally_id',$mArray['saleship_tally_id']);
			unset($mArray['saleship_tally_id']);
			$this->db->update('site_saleship_tally',$mArray);
		}
		return "SUCCESS";
	}
	
	private function update_audit_log($sales_id, $new_data)
	{
		$changed = array();
		$this->auditlog->set_fields('sales_id', $sales_id);
		$this->auditlog->set_context($this->user_id,'site_sales');
		$saved_data = $this->session->userdata('sales_info');
		foreach ($new_data as $field => $new_value)
		{
			$old_value = $saved_data[$field];
			if ($new_value != $old_value) 
			{
				$this->auditlog->write_log($field,$old_value,$new_value);
				$changed[$field] = $new_value;
			}
		}
		return $changed;
	}
		
} //*** End of class Sales
//*** END of FILE

