<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_Wdi_List extends CI_DataManager {
	var $request;

	public function __construct() 
	{
		$this->load->database();
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
			case "GET" :
				break;
			case "SAVE" :
				break;
			default:
				break;	
		}
		$error_wdi_list = $this->get_error_message();
		if (strlen($error_wdi_list) > 0)
		{
			$data = array('status' => "ERROR", 'error_wdi_list' => $error_wdi_list);
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
	

	
} 
/*** End of class Wdi_List ***/
/*** End of File /application/libraries/Wdi_List.php ***/