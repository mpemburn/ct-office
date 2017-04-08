<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_Contract_List extends CI_DataManager {
	var $request;
	var $db;

	public function __construct()
	{
		$this->load->database();
		$this->db = $this->load->database('default', TRUE);
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
				$dates = array();
				$sort_order = $this->get_request('sort_order');
				$search_terms = $this->get_request('search_terms');
				$start_date = $this->get_request('start_date');
				$end_date = $this->get_request('end_date');
				if (is_null($start_date) || is_null($end_date))
				{
					$dates = $this->get_date_range();
					$start_date = $dates['extra_data']['start_date'];
					$end_date = $dates['extra_data']['end_date'];
				}
				else 
				{
					$date_data['extra_data'] = array('start_date' => $start_date, 'end_date' => $end_date);
				}
				$data = $this->get_contract_list($sort_order, $search_terms, $start_date, $end_date);
				$data = array('SUCCESS' => TRUE) + $data + $dates;
				break;
			case "GET_detail" :
				$contract_id = $this->get_request('contract_id');
				$data = $this->get_contract($contract_id);
				$data = array('SUCCESS' => TRUE) + $data;
				break;
			case "SAVE" :
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
	
	public function get_contract_list($sort_order = NULL, $search_terms = NULL, $start_date = NULL, $end_date = NULL)
	{
		$id_field = "contract_id";
		$add_dates = FALSE;
		$data_list = array();
		$column_label_array = $this->config->item('contract.columns');
		$column_clone = array_merge(array(), $column_label_array);
		//*** Need to remove the 'full_name' field and replace it with first and last fields for searching
		//unset($column_clone['full_name']);
		$search_fields = array_keys($column_clone);
		//$search_fields[] = "contract_last_name";
		//$search_fields[] = "contract_first_name";
		
		$criteria = "";
		$select_fields = '*, T.contract_type_abbrev';
		
		$this->db->save_queries = FALSE;
		$this->db->select($select_fields, FALSE);
		$this->db->from($this->main_table . " AS C");
		$this->db->join('cto_contract_types AS T', 'T.contract_type = C.contract_type', 'INNER');
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
			$criteria .= "(time_stamp >= '$start_date' AND time_stamp <= '$end_date')";
		}
		if ($criteria != "")
		{
			$this->db->where($criteria);
		}
		if (!is_null($sort_order) && $sort_order != "") 
		{
			$this->db->order_by($sort_order);
		}
		$query = $this->db->get();
		if ($this->no_db_error())
		{
			$results = $query->result_array();
			if (!empty($results))
			{
				foreach ($results as $row) 
				{
					$residence_customer_name = NULL;
					$billing_customer_name = NULL;
					foreach ($row as $field => $value) 
					{
						//*** Any fields that must have special formatting are processed here
						switch ($field) 
						{
							case "residence_customer_name" :
								$residence_customer_name = $value;
								$value = $this->truncate_words($value, 25);
								break;
							case "billing_customer_name" :
								$billing_customer_name = $value;
								$value = $this->truncate_words($value, 25);
								break;
							case "residence_street_address" :
								$value = $this->truncate_words($value, 25);
								break;
							case "time_stamp" :
								$value = date_format(date_create($value), 'M j, Y');
								break;
							default :
								break;
						}
						$col_info[$field] = (is_null($value)) ? "" : $value;
					}
					if (!is_null($billing_customer_name) && ($billing_customer_name === $residence_customer_name))
					{
						$col_info['billing_customer_name'] = "Same";
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
		
		$this->db->save_queries = false;
		$this->db->select('MIN(time_stamp) AS start_date, MAX(time_stamp) AS end_date');
		$this->db->from($this->main_table);
		$query = $this->db->get();
		if ($this->no_db_error())
		{
			$results = $query->result_array();
			if (!empty($results))
			{
				$date_data = $results[0];
				$end_date = $date_data['end_date'];
				$start_date = date('n/j/Y', strtotime("-1 months"));
				$date_data['start_date'] = $start_date;
				$date_data['end_date'] = date_format(date_create($end_date), 'n/j/Y');
			}
		}
		return array('extra_data' => $date_data);
	}

	public function get_contract($contract_id)
	{
		$contract_data = array();
		
		$this->db->save_queries = false;
		$this->db->from($this->main_table . " AS C");
		$this->db->join('cto_contract_types AS T', 'T.contract_type = C.contract_type', 'INNER');
		$this->db->where(array('contract_id' => $contract_id));
		$query = $this->db->get();
		if ($this->no_db_error())
		{
			$results = $query->result_array();
			if (!empty($results))
			{
				$contract_data = $results[0];
				$contract_data['time_stamp'] = date_format(date_create($contract_data['time_stamp']), 'M j, Y');
				//*** Turn the customer name to lower case with underscores, then replace an non-alpha characters except underscore
				$pdf_customer_name = str_replace(" ", "_", strtolower($contract_data['billing_customer_name']));
				$pdf_customer_name = preg_replace("/[^a-z_]/","",$pdf_customer_name);
				$pdf_date = date_format(date_create($contract_data['time_stamp']), 'm-d-Y');
				$pdf_name = $pdf_customer_name . "_" . $contract_data['contract_type_acronym'] . "_" . $pdf_date . ".pdf";
				$is_found = file_exists($this->config->item('data.path') . $pdf_name);
				$contract_data['pdf_name'] = ($is_found) ? $pdf_name : "Not found";
			}
		}
		return array('data' => $contract_data);
	}
} 
/*** End of class Contract_List ***/
/*** End of File /application/libraries/Contract_List.php ***/