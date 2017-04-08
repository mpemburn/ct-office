<?php

class CI_DataManager {
	var $error_message = null;
	var $last_call = null;
	var $prev_call = null;
	var $main_table = null;
	
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
    
	protected function build_mixed_where($and_array, $or_array, $use_like = FALSE)
	{
		$query = "";
		$ands = array();
		$ors = array();
		$likey = ($use_like) ? "%" : "";
		foreach ($and_array as $field => $criteria)
		{
			$ands[] = $field . "='" . $this->requote($criteria) . "'";
		}
		$query = "(" . implode(" AND ",$ands) . ")";
		
		foreach ($or_array as $field => $criteria)
		{
			$ors[] = $field . " LIKE('" . $likey . $this->requote($criteria) . $likey . "')";
		}
		$query .= " AND (" . implode(" OR ",$ors) . ")";
		//echo $query;
		return $query;
	}
	
	protected function correct_date($in_date)
	{
		$in_date = str_replace("-", "/", $in_date);
		$parts = explode("/", $in_date);
		if (sizeof($parts) == 2)
		{
			//*** Two-part date (e.g., for credit card expiry)
			return date('Y-m-t', mktime(0, 0, 0, $parts[0], 1, $parts[1]));
		}
		else
		{
			return date("Y-m-d",strtotime($in_date));
		}
	}
	
	protected function correct_for_type($field, $value, $table_name)
	{
		$data_types = $this->get_data_types($table_name);
		if (isset($data_types[$field]))
		{
			$data_type = preg_replace("/[^a-z]/", "", strtolower($data_types[$field]));
			switch ($data_type)
			{
				case "double" :
					$value = preg_replace("/[^0-9.]/", "", $value);
					break;
				case "date" :
					$value = date("Y-m-d",strtotime($value));
					if (strstr($value,"1969"))
					{
						$value = NULL;
					}
					break;
				case "time" :
					$value = date("H:i:s",strtotime($value));
					break;
				case "datetime" :
				case "timestamp" :
					$value = date("Y-m-d H:i:s",strtotime($value));
					break;
			}
		}
		return $value;
	}
	
	protected function correct_input_by_type($field, $value, $table_name)
	{
		$value = urldecode($value);
		//echo "Incoming: " . $field . " = " . $value . "\n";
		$data_types = $this->get_data_types($table_name);
		if (isset($data_types[$field]))
		{
			$data_type = preg_replace("/[^a-z]/", "", strtolower($data_types[$field]));
			switch ($data_type)
			{
				case "double" :
				case "decimal" :
					$value = preg_replace("/[^0-9.]/", "", $value);
					break;
				case "date" :
					$value = date("Y-m-d", strtotime($value));
					if (strstr($value,"1969"))
					{
						$value = NULL;
					}
					break;
				case "time" :
					$value = date("H:i:s", strtotime($value));
					break;
				case "datetime" :
				case "timestamp" :
					$value = date("Y-m-d H:i:s", strtotime($value));
					break;
			}
			//echo $field . ": " . $data_type . " = " . $value . "\n";
		}
		return $value;
	}
	
	protected function correct_output_by_type($field, $value, $table_name)
	{
		$data_types = $this->get_data_types($table_name);
		if (isset($data_types[$field]))
		{
			$data_type = preg_replace("/[^a-z]/", "", strtolower($data_types[$field]));
			switch ($data_type)
			{
				case "decimal" :
					$value = '$' . number_format($value, 2, ".", ",");
					break;
				case "double" :
					$value = preg_replace("/[^0-9.]/", "", $value);
				case "date" :
					$value = date("Y-m-d", strtotime($value));
					if (strstr($value,"1969"))
					{
						$value = NULL;
					}
					break;
				case "time" :
					$value = date("H:i:s", strtotime($value));
					break;
				case "datetime" :
				case "timestamp" :
					$value = date("Y-m-d H:i:s", strtotime($value));
					break;
			}
			//echo $field . ": " . $data_type . " = " . $value . "\n";
		}
		return $value;
	}
	
	//*** Used to chain multiple fields together with the same sort order
	protected function correct_sort_order()
	{
		$direction = "ASC";
		$corrected = array();
		$numargs = func_num_args();
		$arg_list = func_get_args();
		for ($i=0; $i<$numargs; $i++)
		{
			if ($i == 0)
			{
				$sort_parts = explode(" ",$arg_list[$i]);
				if (sizeof($sort_parts) != 1) 
				{
					$direction = $sort_parts[1];
				}
			}
			else
			{
				$corrected[] = $arg_list[$i] . " " . $direction;
			}
		}
		return implode(",",$corrected);
	}
	
	protected function enquote($in_string)
	{
		return "'" . $in_string . "'";
	}

	protected function get_columns($table_name, $nulls_only = FALSE)
	{
		$columns = array();
		$no_nulls = ($nulls_only) ? "WHERE  `Null` =  'No' AND NOT `Key` = 'PRI'" : "";
		
		$sql = "SHOW COLUMNS IN $table_name $no_nulls;";
		$this->db->save_queries = false;
		$query = $this->db->query($sql);
		foreach ($query->result() as $row)
		{
			$columns[] = $row->Field;
		}
		return $columns;
	}
	
	protected function get_index_columns($table_name, $key_name)
	{
		$columns = array();
		$sql = "SHOW INDEXES FROM " . $this->db->database . "." . $table_name . " WHERE Key_Name = '" . $key_name . "';";
		$this->db->save_queries = false;
		$query = $this->db->query($sql);
		if ($this->no_db_error())
		{
			foreach ($query->result() as $row)
			{
				$columns[] = $row->Column_name;
			}
		}
		return $columns;
	}
	
	function get_data_types($table_name = NULL)
	{
		if (is_null($table_name))
		{
			return NULL;
		}
		$columns = array();
		$sql = "SHOW COLUMNS IN $table_name;";
		$this->db->save_queries = FALSE;
		$query = $this->db->query($sql);
		foreach ($query->result() as $row)
		{
			$type = $row->Type;
			$type = preg_replace('/[^a-z]+/', "", $type);
			$type = str_replace(array("unsigned","controller","function"), "", $type);
			$columns[$row->Field] = $type;
		}
		return $columns;
	}
	
	protected function get_error_message()
	{
		return $this->error_message;
	}
		
	protected function get_field_nulls($table_name = NULL)
	{
		if (is_null($table_name))
		{
			return NULL;
		}
		$columns = array();
		$sql = "SHOW COLUMNS IN $table_name;";
		$this->db->save_queries = FALSE;
		$query = $this->db->query($sql);
		foreach ($query->result() as $row)
		{
			$columns[$row->Field] = $row->Null;
		}
		return $columns;
	}
	
	protected function get_request($key, $table_name = NULL, $field_suffix = NULL)
	{
		$field_suffix = (!is_null($field_suffix)) ? "_" . $field_suffix : NULL;
		$field_types = $this->get_data_types($table_name);
		$out_array = array();
		if (is_null($key))
		{
			$columns = $this->get_columns($table_name);
			foreach ($columns as $field)
			{
				if (isset($this->request[$field . $field_suffix]))
				{
					$value = rawurldecode($this->request[$field . $field_suffix]);
					if (!is_null($field_types))
					{
						if (isset($field_types[$field]))
						{
							switch ($field_types[$field])
							{
								case "date" :
									//echo "Before " . $value."<br />";
									$value = $this->correct_date($value);
									//echo "After " . $value."<br />";
									break;
							}
						}
					}
					$out_array[$field] = $value;
				}
			}
			return $out_array;
		}
		else
		{
			return isset($this->request[$key]) ? rawurldecode($this->request[$key]) : NULL;
		}
	}
	
	protected function get_request_group($search_key)
	{
		$group = array();
		foreach ($this->request as $key => $value)
		{
			$pos = stripos($key, $search_key);
			if ($pos !== FALSE)
			{
				$group[$key] = rawurldecode($value);
			}
		}
		return $group;
	}

	protected function get_suffix_number($in_field)
	{
		$parts = $this->split_field($in_field);
		return $parts['suffix'];
	}

	protected function no_db_error()
	{
		$success = TRUE;
		$this->error_message = null;
		$error_message = $this->db->_error_message();
		if ($error_message)
		{
			$this->error_message = $error_message;
			//*** Get the call stack
			$call_stack = debug_backtrace();
			$this->last_call = $call_stack[1];
			$this->prev_call = $call_stack[0];
			$success = FALSE;
		}
		return $success;
	}
	
	//*** Proccessing for the jquery-select-plus plug-in:
	//	Look for fields that begin with "plus_" and replace the values of the
	//	fields they are 'shadowing' with the the "plus_" values.
	protected function process_plus_fields($request)
	{
		foreach ($request as $key => $value)
		{
			$plus = substr($key,0,5);
			if ($plus == "plus_")
			{
				$no_blank = isset($request["no_blank_" + $key]) ? $request["no_blank_" + $key] : "false";
				$original = str_replace($plus,"",$key);
				if ($value == "" && $no_blank == "true")
				{
					continue;
				}
				//echo $request[$original] . " = " . $value;
				$request[$original] = $value;
			}
		}
		return $request;
	}
	
	protected function requote($in_string)
	{
		return str_replace("'","''",$in_string);
	}

	protected function set_main_table($table_name)
	{
		$this->main_table = $table_name;
	}

	protected function split_field($in_field)
	{
		$field_name = preg_replace("/_[0-9]+/","",$in_field);
		$suffix = str_replace($field_name . "_","",$in_field);
		return array('field_name' => $field_name, 'suffix' => intval($suffix));
	}
	
	protected function suffix_add($in_field)
	{
		$parts = $this->split_field($in_field);
		return $parts['field_name'] . "_" . $parts['suffix']++;
	}
	
	protected function truncate($in_string, $max_len)
	{
		return (strlen($in_string) > $max_len) ? substr($in_string,0,$max_len) . " . . ." : $in_string;
	}
	
	protected function truncate_words($string, $max_len) {
		$in_string = $string;
		$parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
		$parts_count = count($parts);

		$length = 0;
		$last_part = 0;
		for (; $last_part < $parts_count; ++$last_part) {
			$length += strlen($parts[$last_part]);
			if ($length > $max_len) { break; }
		}
		$out_string = implode(array_slice($parts, 0, $last_part));
		return (strlen($out_string) < strlen($in_string)) ? substr($out_string,0,$max_len) . " . . ." : $out_string;
	}

}

//*** END OF FILE /application/libraries/DataManager.php