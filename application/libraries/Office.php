<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_Office extends CI_DataManager {
	var $request;
	var $key = null;
	var $user_id = null;
	
	public function __construct() 
	{
		$this->load->database();
		$this->load->library('AuditLog');
		$this->load->library('NameParser');
		$this->load->helper('json');
		$this->config->load('ct_office');
		
		$user_data = $this->session->userdata('currentsession','office_info');
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
			case "GET_key" :
				$this->key = md5($this->config->item('rc4.seed'));
				$data = array('status' => "SUCCESS", 'data' => $this->key);
				$this->echo_output(json_encode($data));
				break;
			case "GET_ddlist" :
				$list_name = $this->get_request('list_name');
				$data = $this->get_dd_list($list_name);
				
				$this->echo_output(json_encode($data));
				break;
			case "SAVE" :
				$this->request['type'] = "";
				$mdata = $this->set_office();
				$this->contacts->parse_request($this->request);
				$cdata = $this->contacts->set_contact(TRUE);
				$data = array_merge($mdata,$cdata);
				$this->echo_output(json_encode($data));
				break;
		}
	}
	
	public function echo_output($data)
	{
		echo $data;
	}
	
	public function get_dd_list($list_name)
	{
		$list_array = null;
		switch ($list_name)
		{
			case "state" :
				$list_array = $this->get_states();
				break;
		}
		return $list_array;
	}
	
	public function get_columns()
	{
		return parent::get_columns("site_office");
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
	
	public function set_office($referred = FALSE)
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
				case "office_id" :
					$office_id = $value;
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
		if ($office_id == "0")
		{
			if ($field_count > 2)
			{
				$this->db->save_queries = false;
				$this->db->insert('site_office',$data);
				$new_id = $this->db->insert_id();
				if (!$referred)
				{
					$out_array['status'] = "SUCCESS";
				}
				$out_array['office_id'] = $new_id;
				//$this->echo_output($new_id);
			}
		}
		else
		{
			//*** UPDATE current record
			$this->db->save_queries = false;
			$this->db->where('office_id',$office_id);
			$this->db->update('site_office',$data);
			if (!$referred)
			{
				$out_array['status'] = "SUCCESS";
			}
			$affected = $this->db->affected_rows();
			if ($affected > 0) 
			{
				$changed_values = $this->update_audit_log($office_id,$data);
				$this->session->set_userdata(array('office_info' => $data));
				$out_array['changes'] = $changed_values;
			}
		}
		return $out_array;
	}
	
	private function update_audit_log($office_id, $new_data)
	{
		$changed = array();
		$this->auditlog->set_fields('office_id', $office_id);
		$this->auditlog->set_context($this->user_id,'site_office');
		$saved_data = $this->session->userdata('office_info');
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
		
} //*** End of class Office
//*** END of FILE

