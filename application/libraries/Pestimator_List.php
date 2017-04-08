<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_Pestimator_List extends CI_DataManager {
	var $request;
	var $db_site;

	public function __construct()
	{
		$this->load->database();
		$this->db_site = $this->load->database('site', TRUE);
		//*** Get the main table name from array the config file, using the class name as the key
		$main_tables = $this->config->item('main.data.table');
		$this->set_main_table($main_tables[__CLASS__]);
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

		switch($this->get_request('type'))
		{
			case "GET_list" :
				$sort_order = $this->get_request('sort_order');
				$search_terms = $this->get_request('search_terms');
				$start_date = $this->get_request('start_date');
				$end_date = $this->get_request('end_date');
				$data = $this->get_pestimator_list($sort_order, $search_terms, $start_date, $end_date);
				$data = array('SUCCESS' => TRUE) + $data;
				if (is_null($start_date) || is_null($end_date))
				{
					$dates = $this->get_date_range();
					$data = $data + $dates;
				}
				break;
			case "GET_detail" :
				$estimate_id = $this->get_request('estimate_id');
				$data = $this->get_estimate($estimate_id);
				$data = array('SUCCESS' => TRUE) + $data;
				break;
			case "SAVE" :
				break;
			default:
				break;	
		}
		$error_pestimator_list = $this->get_error_message();
		if (strlen($error_pestimator_list) > 0)
		{
			$data = array('status' => "ERROR", 'error_pestimator_list' => $error_pestimator_list);
			$last_call = $this->get_last_call();
			if (!is_null($last_call))
			{
				$data = array_merge($data, $last_call);
			}
		}
		//*** Send data back to caller
		$this->echo_output(json_encode($data));
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
	
	public function get_pestimator_list($sort_order = NULL, $search_terms = NULL, $start_date = NULL, $end_date = NULL)
	{
		$id_field = "estimate_id";
		$add_dates = FALSE;
		$data_list = array();
		$column_label_array = $this->config->item('pestimator.columns');
		$column_clone = array_merge(array(), $column_label_array);
		//*** Need to remove the 'full_name' field and replace it with first and last fields for searching
		unset($column_clone['full_name']);
		$search_fields = array_keys($column_clone);
		$search_fields[] = "estimate_last_name";
		$search_fields[] = "estimate_first_name";
		
		$criteria = "";
		$select_fields = '*, CONCAT(estimate_last_name, ", ", estimate_first_name) AS full_name';
		
		$this->db_site->save_queries = FALSE;
		$this->db_site->select($select_fields, FALSE);
		$this->db_site->from($this->main_table);
		if (!is_null($search_terms)) 
		{
			foreach ($search_fields as $field)
			{
				$search_array[] = "(" . $field . " LIKE(" . $this->enquote("%" . $search_terms . "%") . "))";	
			}
			$criteria = "(" . implode(" OR ", $search_array) . ")";
				
		}
		if (!is_null($start_date) && !is_null($end_date))
		{
			$add_dates = TRUE;
			$start_date = date_format(date_create($start_date), 'Y-m-d 00:00:00');
			$end_date = date_format(date_create($end_date), 'Y-m-d 23:59:59');
			$criteria .= ($criteria == "") ? "" : " AND ";
			$criteria .= "(estimate_datetime >= '$start_date' AND estimate_datetime <= '$end_date')";
		}
		if ($criteria != "")
		{
			$this->db_site->where($criteria);
		}
		if (!is_null($sort_order) && $sort_order != "") 
		{
			$this->db_site->order_by($sort_order);
		}
		$query = $this->db_site->get();
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
							case "estimate_datetime" :
								$value = date_format(date_create($value), 'M j, Y g:i A');
								break;
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
		if ($add_dates)
		{
			$start_date = date_format(date_create($start_date), 'n/j/Y');
			$end_date = date_format(date_create($end_date), 'n/j/Y');
			$data_array = $data_array + array('extra_data' => array('start_date' => $start_date, 'end_date' => $end_date));
		}
		return $data_array;
	}
	
	public function get_date_range()
	{
		$date_data = array();
		
		$this->db_site->save_queries = false;
		$this->db_site->select('MIN(estimate_datetime) AS start_date, MAX(estimate_datetime) AS end_date');
		$this->db_site->from($this->main_table);
		$query = $this->db_site->get();
		if ($this->no_db_error())
		{
			$results = $query->result_array();
			if (!empty($results))
			{
				$date_data = $results[0];
				$date_data['start_date'] = date_format(date_create($date_data['start_date']), 'n/j/Y');
				$date_data['end_date'] = date_format(date_create($date_data['end_date']), 'n/j/Y');
			}
		}
		return array('extra_data' => $date_data);
	}

	public function get_estimate($estimate_id)
	{
		$estimate_data = array();
		
		$this->db_site->save_queries = false;
		$this->db_site->from($this->main_table);
		$this->db_site->where(array('estimate_id' => $estimate_id));
		$query = $this->db_site->get();
		if ($this->no_db_error())
		{
			$results = $query->result_array();
			if (!empty($results))
			{
				$estimate_data = $results[0];
				$estimate_data['estimate_datetime'] = date_format(date_create($estimate_data['estimate_datetime']), 'M j, Y g:i A');
			}
		}
		return array('data' => $estimate_data);
	}
} 
/*** End of class Pestimator_List ***/
/*** End of File /application/libraries/Pestimator_List.php ***/