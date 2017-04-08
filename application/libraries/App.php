<?php

class App {
	var $is_mobile = FALSE;
	
	function __construct()
	{
		$this->is_mobile = $this->detect_mobile();
	}
	
	public function css($script_set)
	{
		$file_array = array();
		$css_stub = "<link rel=\"stylesheet\" href=\"#FILE_SRC#\" type=\"text/css\" media=\"screen\" />";
		switch ($script_set)
		{
			case "app_form" :
				$file_array[] = "jquery.mobile.css";
				$file_array[] = "app/theme/ui-custom.css";
				$file_array[] = "app/contract.css";
				$file_array[] = "app/form.css";
				break;
			case "sales" :
				$file_array[] = "popover/popover.css";
				break;
			case "pest_contract" :
				$file_array[] = "jquery.mobile.css";
				$file_array[] = "app/theme/ui-custom.css";
				$file_array[] = "app/contract.css";
				$file_array[] = "app/form.css";
				break;
		}
		
		return $this->build_file_list($file_array,$css_stub,"css/");
	}

	public function scripts($script_set)
	{
		if ($this->is_mobile)
		{
			$file_array[] =  "http://code.jquery.com/mobile/1.1.0-rc.1/jquery.mobile-1.1.0-rc.1.min.js";
		}
		
		$file_array = array();
		$js_stub = "<script type=\"text/javascript\" src=\"#FILE_SRC#\"></script>";
		switch ($script_set)
		{
			case "app_form" :
				$file_array[] = "signature/jquery.signaturepad.js";
				$file_array[] = "jquery-rc4.js";
				$file_array[] = "app/form_helper.js";
				$file_array[] = "app/form_builder.js";
				$file_array[] = "app/contract.js";
				break;
			case "office" :
				$file_array[] = "jquery-rc4.js";
				break;
			case "sales" :
				$file_array[] = "jquery.popover-1.0.8.js";
				$file_array[] = "app/sales.js";
				break;
			case "pest_contract" :
				$file_array[] = "signature/jquery.signaturepad.js";
				$file_array[] = "jquery-rc4.js";
				$file_array[] = "app/form_helper.js";
				$file_array[] = "app/contract.js";
				break;
		}
		return $this->build_file_list($file_array,$js_stub,"js/");
	}

	private function build_file_list ($file_array, $stub, $src_path)
	{
		$file_list = "";
		foreach ($file_array as $file)
		{
			$file_src = "";
			if (!strstr($file,"http://"))
			{
				$file_src .= base_url() . $src_path;
			}
			$file_src .= $file;
			$file_list .= str_replace("#FILE_SRC#",$file_src,$stub) . "\n";
		}
		return $file_list;
	}
	
	public function js_vars($page, $in_vars = NULL)
	{
		$output = "";
		$vars = array();
		$vars['image_path'] = base_url() . "images";
		$mobile = ($this->is_mobile) ? "true" : "false";
		$vars['is_mobile'] = "{literal}" . $mobile;
		switch ($page)
		{
			case "office" :
				$vars['office_ajax_url'] = base_url() . "office/ajax_office_manager";
				break;
			case "app_form" :
				$vars['document_pages'] = "2";			
				$vars['layout_ajax_url'] = base_url() . "app_form/ajax_contract_layout";
				$vars['generate_doc_ajax_url'] = base_url() . "app_form/ajax_generate_contract";
				$vars['form_helper_ajax_url'] = base_url() . "app_form/ajax_form_helper";
				$vars['sales_page_url'] = base_url() . "index.php/sales";
				break;
			case "pest_contract" :
				$vars['document_name'] = "pest_contract";
				$vars['document_pages'] = "2";			
				$vars['layout_ajax_url'] = base_url() . "pest_contract/ajax_contract_layout";
				$vars['generate_doc_ajax_url'] = base_url() . "pest_contract/ajax_generate_contract";
				$vars['form_helper_ajax_url'] = base_url() . "pest_contract/ajax_form_helper";
				$vars['sales_page_url'] = base_url() . "index.php/sales";
				break;
			default :
				break;
		}
		if (!is_null($in_vars))
		{
			$vars = array_merge($vars,$in_vars);
		}
		foreach ($vars as $key => $var)
		{
			if (!$this->is_literal($var))
			{
				$var = $this->enquote($var);
			}
			$output .= "\tvar " . $key . " = " . $var . ";\n";
		}
		return $output;
	}
	
	private function detect_mobile()
	{
		if (preg_match('/(alcatel|amoi|android|avantgo|blackberry|benq|cell|cricket|docomo|elaine|htc|iemobile|iphone|ipad|ipaq|ipod|j2me|java|midp|mini|mmp|mobi|motorola|nec-|nokia|palm|panasonic|philips|phone|sagem|sharp|sie-|smartphone|sony|symbian|t-mobile|telus|up\.browser|up\.link|vodafone|wap|webos|wireless|xda|xoom|zte)/i', $_SERVER['HTTP_USER_AGENT']))
		{
			return true;
		}
		return false;
	
	}
	
	private function enquote($in_string)
	{
		return '"' . $in_string . '"';
	}
	
	private function is_literal(&$in_string)
	{
		if (strstr($in_string,"{literal}"))
		{
			$in_string = str_replace("{literal}","",$in_string);
			return true;
		}
		return false;
	}
}

//*** END of FILE app.php