<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_Contacts extends CI_DataManager {
	var $request;
	var $resource = null;
	var $resource_id = null;
	var $resource_name = null;
	var $contact_info = null;
	var $user_id = null;
	
	public function __construct() 
	{
		$this->load->database();
		$this->load->library('AuditLog');
		$this->load->library('NameParser');
		$this->load->helper('json');
		
		$user_data = $this->session->userdata('currentsession','contact_info');
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
				$data = $this->get_contacts_list($sort_order,$search_terms);
				//$data = array('contacts_list' => $contacts_list);
				
				$this->echo_output(json_encode($data));
				break;
			case "GET_ddlist" :
				$list_name = $this->get_request('list_name');
				$data = $this->get_dd_list($list_name);
				
				$this->echo_output(json_encode($data));
				break;
			case "GET_parse_contact" :
				$conctact_name = $this->get_request('conctact_name');
				$data = $this->parse_name($conctact_name);
				
				$this->echo_output(json_encode($data));
				break;
			case "SAVE" :
				$data = $this->set_contact();
				$this->echo_output(json_encode($data));
				break;
			case "DELETE" :
				$contact_id = $this->get_request('contact_id');
				$this->archive_contact($contact_id);
				break;
			default:
				break;	
		}
	}
	
	public function echo_output($data)
	{
		echo $data;
	}
	
	public function add_new_prefix($prefix_name)
	{
		$this->db->save_queries = false;
		$this->db->where('prefix_code', $prefix_name);
		$this->db->or_where('prefix_name', $prefix_name); 
		$this->db->update('site_prefixes',array('use_prefix' => "1"));
		return $this->get_prefix_code($prefix_name);
	}
	
	public function archive_contact($contact_id) {
		$this->db->save_queries = false;
		//$this->db->delete('site_contacts', array('contact_id' => $contact_id));
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
		$list_array = null;
		switch ($list_name)
		{
			case "prefix" :
				$list_array = $this->get_prefixes();
				break;
			case "suffix" :
				$list_array = $this->get_suffixes();
				break;
		}
		return $list_array;
	}
	
	public function get_contact($contact_id)
	{
		$contact_info = null;
		$select_fields = "*,";
		$select_fields .= 'CONCAT(IF(LENGTH(C.contact_prefix) > 0,CONCAT(C.contact_prefix," "),""),C.contact_first_name," ",C.contact_last_name) AS contact_name,';
		$select_fields .= 'IF(LENGTH(suffix_name) > 0,CONCAT(suffix_name,"-",contact_name),contact_name) AS contact_suffix_name';
		$search_array = array();
		$search_fields = array('contact_name','suffix_name','contact_first_name','contact_last_name','email','address_1','city','prefix','zip','notes');
		$this->db->save_queries = false;
		$contacts_info = array();
		$this->db->from('site_contacts AS M');
		$this->db->join('site_contact_contacts AS MC', 'M.contact_id = MC.contact_id', 'INNER');
		$this->db->join('site_contacts AS C', 'C.contact_id = MC.contact_id', 'INNER');
		$this->db->select($select_fields,FALSE);
		$this->db->where('M.contact_id', $contact_id);
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
				$contact_info[$field] = (is_null($value)) ? "" : $value;
			}
		}
		$this->session->set_userdata(array('contact_info' => $contact_info));
		return array('contact_info' => $contact_info);
	}
	
	public function get_contacts_list($sort_order = NULL, $search_terms = NULL)
	{
		$id_field = "contact_id";
		$column_label_array = array(
			'contact_name' => "Contact",
			'suffix_name' => "System",
			'contact_name' => "Contact",
			'address_1' => "Address",
			'city' => "City",
			'prefix' => "State   ",
			'zip' => "Zip",		
		);
		$select_fields = "M.contact_id, contact_name, suffix_name, email, address_1, city, prefix, zip,";
		$select_fields .= 'CONCAT(IF(LENGTH(C.contact_prefix) > 0,CONCAT(C.contact_prefix," "),""),C.contact_first_name," ",C.contact_last_name) AS contact_name,';
		$select_fields .= 'IF(LENGTH(suffix_name) > 0,CONCAT(suffix_name,"-",contact_name),contact_name) AS contact_suffix_name';
		$search_array = array();
		$search_fields = array('contact_name','suffix_name','contact_first_name','contact_last_name','email','address_1','city','prefix','zip','notes');
		$this->db->save_queries = false;
		$contacts_list = array();
		$this->db->from('site_contacts AS M');
		$this->db->join('site_contact_contacts AS MC', 'M.contact_id = MC.contact_id', 'INNER');
		$this->db->join('site_contacts AS C', 'C.contact_id = MC.contact_id', 'INNER');
		$this->db->select($select_fields,FALSE);
		if (!is_null($sort_order) && $sort_order != "") 
		{
			switch (true)
			{ 
				case (strstr($sort_order,"contact_name")) :
					$sort_order = $this->correct_sort_order($sort_order,"contact_last_name","contact_first_name");
					break;
				case (strstr($sort_order,"contact_name")) :
					$sort_order = str_replace("contact_name","contact_suffix_name",$sort_order);
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
					case "contact_name" :
						$value = $this->truncate($value,40);
						break;
					default :
						break;
				}
				$col_info[$field] = (is_null($value)) ? "" : $value;
			}
			$contacts_list[] = $col_info;
		}
		return array('id_field' => $id_field, 'data_list' => $contacts_list, 'column_list' => $column_label_array);
	}
	
	public function get_columns()
	{
		$columns = array();
		$sql = "SHOW COLUMNS IN site_contacts;";
		$this->db->save_queries = false;
		$query = $this->db->query($sql);
		foreach ($query->result() as $row)
		{
			$columns[] = $row->Field;

			//$columns[] = $row['Field'];
		}
		return $columns;
	}
	
	public function get_prefix_code($name_or_code)
	{
		$prefix_code = null;
		$this->db->save_queries = false;
		$this->db->select('prefix_code')->from('site_prefixes')->where('prefix_name',$name_or_code)->or_where('prefix_code',$name_or_code);
		$query = $this->db->get();
		$results = $query->result_array();
		foreach ($results as $row)
		{
			$prefix_code = $row['prefix_code'];
		}
		return $prefix_code;
	}
	
	public function get_prefixes()
	{
		$prefixes = array();
		$this->db->save_queries = false;
		$this->db->select('*')->from('site_prefixes')->where('use_prefix = 1')->order_by('prefix');
		$query = $this->db->get();
		$results = $query->result_array();
		foreach ($results as $row)
		{
			$prefixes[$row['prefix']] = $row['prefix'];
		}
		return $prefixes;
	}
	
	public function get_suffixes()
	{
		$suffixes = array();
		$this->db->save_queries = false;
		$this->db->select('*')->from('site_suffixes')->where('use_suffix = 1')->order_by('suffix');
		$query = $this->db->get();
		$results = $query->result_array();
		$suffixes[''] = "";
		foreach ($results as $row)
		{
			$suffixes[$row['suffix']] = $row['suffix'];
		}
		return $suffixes;
	}
	
	public function insert_new_prefix($field_name, $value)
	{
		$prefix_code = $value;
		if ($field_name == "prefix") {
			$prefixes = $this->get_prefixes();
			if (!in_array($value,$prefixes) OR array_key_exists($value,$prefixes))
			{
				$prefix_code = $this->add_new_prefix($value);
			}
		}
		return $prefix_code;
	}
	
	public function insert_new_suffix($field_name, $value)
	{
		$suffix_name = $value;
		if ($field_name == "suffix_name") {
			$suffixes = $this->get_suffixes();
			if (!in_array($value,$suffixes))
			{
				$suffix_name = $this->add_new_suffix($value);
			}
		}
		$suffix_name = ($suffix_name === "0") ? "" : $suffix_name;
		return $suffix_name;
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
	
	public function set_contact($referred = FALSE)
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
				case "contact_id" :
					$contact_id = $value;
					break;
				case "prefix" :
					$value = $this->insert_new_prefix("prefix", $value);
					$data[$field] = $value;
					$field_count++;
					break;
				case "suffix_name" :
					$value = $this->insert_new_suffix("suffix_name", $value);
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
		if ($contact_id == "0")
		{
			if ($field_count > 2)
			{
				$this->db->save_queries = false;
				$this->db->insert('site_contacts',$data);
				$new_id = $this->db->insert_id();
				if (!$referred)
				{
					$out_array['status'] = "SUCCESS";
				}
				$out_array['contact_id'] = $new_id;
				//$this->echo_output($new_id);
			}
		}
		else
		{
			//*** UPDATE current record
			$this->db->save_queries = false;
			$this->db->where('contact_id',$contact_id);
			$this->db->update('site_contacts',$data);
			if (!$referred)
			{
				$out_array['status'] = "SUCCESS";
			}
			$affected = $this->db->affected_rows();
			if ($affected > 0) 
			{
				$changed_values = $this->update_audit_log($contact_id,$data);
				$this->session->set_userdata(array('contact_info' => $data));
				$out_array['changes'] = $changed_values;
			}
		}
		return $out_array;
	}
	
	private function update_audit_log($contact_id, $new_data)
	{
		$changed = array();
		$this->auditlog->set_fields('contact_id', $contact_id);
		$this->auditlog->set_context($this->user_id,'site_contacts');
		$saved_data = $this->session->userdata('contact_info');
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
		
} //*** End of class Contacts
//*** END of FILE

