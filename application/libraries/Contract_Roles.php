<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_Contract_Roles extends CI_DataManager {
	var $request;
	var $db;

	public function __construct()
	{
		$this->load->database();
		$this->db = $this->load->database('default', TRUE);
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
		$data = array();
		if (sizeof($request) == 0) {
			$request = $_REQUEST;
		}
		$this->request = $request;

		$role_id = $this->get_request('role_id');
		switch($this->get_request('type'))
		{
			case "GET_list" :
				$dates = array();
				$sort_order = $this->get_request('sort_order');
				$search_terms = $this->get_request('search_terms');
				$start_date = $this->get_request('start_date');
				$end_date = $this->get_request('end_date');
				$data = $this->get_role_list($sort_order, $search_terms, $start_date, $end_date);
				$data = array('SUCCESS' => TRUE) + $data;
				break;
			case "GET_detail" :
				$data = $this->get_role($role_id);
				$data = array('SUCCESS' => TRUE) + $data;
				break;
			case "ADD_role" :
				$role_id = $this->add_role($request);
				$data = array('SUCCESS' => TRUE, 'role_id' => $role_id);
				break;
			case "DELETE_role" :
				$this->delete_role($role_id);
				break;
			case "UPDATE_role" :
				$this->update_role($request, $role_id);
				break;
			default:
				break;	
		}
		$error_contract_list = $this->get_error_message();
		if (strlen($error_contract_list) > 0)
		{
			$data = array('status' => "ERROR", 'error_contract_list' => $error_contract_list);
			$last_call = $this->get_last_call();
			if (!is_null($last_call))
			{
				$data = array_merge($data, $last_call);
			}
		}
		//*** Send data back to caller
		$this->echo_output(json_encode($data));
	}

	public function add_role($request)
	{
		unset($request['type']);
		$this->db->insert('cto_contract_roles', $request);

		return $this->db->insert_id();
	}

	public function delete_role($role_id)
	{
		$this->db->delete('cto_contract_roles', array('id' => $role_id));
	}

	public function update_role($request, $role_id)
	{
		unset($request['type']);
		unset($request['role_id']);
		$this->db->where('id', $role_id);
		$this->db->update('cto_contract_roles', $request);
	}

	public function echo_output($data)
	{
		//*** This is what gets sent back to the AJAX call
		echo $data;
	}
	
	public function get_columns($table = NULL)
	{
		$table = (is_null($table)) ? $this->main_table : $table;
		return parent::get_columns($table);
	}
	
	public function get_role_list($sort_order = NULL, $search_terms = NULL, $start_date = NULL, $end_date = NULL)
	{
		$id_field = "id";
		$add_dates = FALSE;
		$data_list = array();
		$column_label_array = $this->config->item('role.columns');
		$this->db->save_queries = FALSE;
		$this->db->select('*', FALSE);
		$this->db->from('cto_contract_roles');
		$this->db->order_by('role DESC, last_name, first_name');

		$query = $this->db->get();
		if ($this->no_db_error())
		{
			$results = $query->result_array();
			if (!empty($results))
			{
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
						$col_info[$field] = (is_null($value)) ? "" : $value;
					}
					$data_list[] = $col_info;
				}				
			}
		}
		$data_array = array('id_field' => $id_field, 'data_list' => $data_list, 'column_list' => $column_label_array);
		return $data_array;
	}
	
	public function get_role($role_id)
	{
		$role_data = array();
		
		$this->db->save_queries = false;
		$this->db->select('*, id AS role_id', FALSE);
		$this->db->from('cto_contract_roles');
		$this->db->where(array('id' => $role_id));
		$query = $this->db->get();
		if ($this->no_db_error())
		{
			$results = $query->result_array();
			if (!empty($results))
			{
				$role_data = $results[0];
			}
		}
		return array('data' => $role_data);
	}
} 
/*** End of class Contract_List ***/
/*** End of File /application/libraries/Contract_List.php ***/