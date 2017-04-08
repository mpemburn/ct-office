<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_Vendors {
	var $conn = null;
	var $request;
	var $vendor = null;
	var $vendor_id = null;
	var $vendor_name = null;
	var $vendor_info = null;
	
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
		$this->request = $request;
		switch($this->get_request('type'))
		{
			case "GET" :
				$vr_id = $this->get_request('vendor_id');
				if (!is_numeric($vr_id)) {
					$this->echo_output("ERROR during get: No vendor_id");
					return;
				}
				$this->vendor = $this->get_vendor($vr_id);
				if (!is_null($this->vendor))
				{
					$fiscal_year = $this->get_request('fiscal_year');
					$vendor_info = $this->get_vendor_info($this->vendor['vendor_id']);
					$this->vendor_info = $this->get_vendors($this->vendor['vendor_id'],$fiscal_year);
					$data = array('vendor' => $this->vendor, 'vendor_info' => $this->vendor_info, 'vendor_info' => $vendor_info);
					
					$this->echo_output(json_encode($data));
				}
				break;
			case "SAVE" :
				$this->set_vendor();
				break;
		}
	}
	
	private function get_request($key)
	{
		 return isset($this->request[$key]) ? rawurldecode($this->request[$key]) : null;
	}
	
	public function echo_output($data)
	{
		echo $data;
	}
	
	public function get_vendor($vendor_id)
	{
		$this->db->save_queries = false;
		$vendor = null;
		$query = $this->db->get_where('site_vendors', array('vendor_id' => $vendor_id));
		$results = $query->result_array();
		foreach ($results as $row) 
		{
			$vendor_id = $row['vendor_id'];
			$vendor_id = $row['vendor_id'];
			$vendor_name = $row['vendor_name'];
		}
		if (!is_null($vendor_id))
		{
			$vendor = array('vendor_id' => $vendor_id, 'vendor_id' => $vendor_id, 'vendor_name' => $vendor_name);
		}
		return $vendor;
	}
	
	public function get_vendors()
	{
		$this->db->save_queries = false;
		$vendor_info = array();
		$this->db->order_by('vendor_precedence');
		$query = $this->db->get_where('site_vendors');
		$results = $query->result_array();
		foreach ($results as $row) 
		{
			foreach ($row as $field => $value) 
			{
				$col_info[$field] = (is_null($value)) ? "" : $value;
			}
			$vendor_info[] = $col_info;
		}
		return $vendor_info;
	}
	
	public function get_columns()
	{
		$columns = array();
		$sql = "SHOW COLUMNS IN site_vendors;";
		$this->db->save_queries = false;
		$query = $this->db->query($sql);
		foreach ($query->result() as $row)
		{
			$columns[] = $row->Field;

			//$columns[] = $row['Field'];
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
	
	public function get_vendor_info($vendor_id)
	{
		$vendor_info = null;
		$this->db->save_queries = false;
		$vendor = null;
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
	
	public function set_vendor()
	{
		$data = array();
		$field_count = 0;
		$columns = $this->get_columns();
		foreach ($columns as $field)
		{
			$value = $this->get_request($field);
			switch ($field)
			{
				case "vendor_id" :
					$vendor_id = $value;
					break;
				default :
					if ($value != "")
					{
						$data[$field] = $value;
						$field_count++;
					}
					break;
			}
		}
		if ($vendor_id == "0")
		{
			if ($field_count > 2)
			{
				$this->db->save_queries = false;
				$this->db->insert('site_vendors',$data);
				$new_id = $this->db->insert_id();
				$this->echo_output($new_id);
			}
		}
		else
		{
			$this->db->save_queries = false;
			$this->db->where('vendor_id',$vendor_id);
			$this->db->update('site_vendors',$data);
			$affected = $this->db->affected_rows();
			if ($affected > 0) 
			{
				$this->echo_output("SUCCESS");
			}
		}
	}
	
} //*** End of class Vendors
//*** END of FILE

