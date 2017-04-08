<?php
/*
 * CI_AppInclude
 * 
 * This class pulls config values in from the application's 
 * custom config file and uses them to generate css and javascript
 * file references as well as javascript variables inserted into
 * a script tag set at the top of the page.
 * 
 * It is called from the page's controller and uses this syntax:
	$this->local_data['scripts'] = $this->appinclude->scripts('vendor_resources');

 * The config file will have corresponding entries like:
	$config['include.javascript.vendor_resources'] = array(
		'jquery.ui.core.js',
		'app/vendor_resources.js'
	);

*/

class CI_AppInclude {
	
	function __construct()
	{
	}
	
	//*** Eagic method __get gives us access to the parent CI object
    public function __get($var)    
    {
        static $CI;
        (is_object($CI)) OR $CI = get_instance();
        return $CI->$var;
    }
	
	public function css($script_set, $in_scripts = NULL)
	{
		//echo $script_set;
		$css_stub = "<link rel=\"stylesheet\" href=\"#FILE_SRC#\" type=\"text/css\" media=\"screen\" />";
		$file_array = $this->config->item('include.css.' . $script_set);
		if (!is_array($file_array))
		{
			$file_array = array();
		}
		if (is_array($in_scripts))
		{
			$file_array = $file_array + $in_scripts;
		}
		
		return $this->build_file_list($file_array,$css_stub,"css/");
	}

	public function scripts($script_set, $in_scripts = NULL)
	{
		//echo $script_set;
		$js_stub = "<script type=\"text/javascript\" src=\"#FILE_SRC#\"></script>";
		$file_array = $this->config->item('include.javascript.' . $script_set);
		if (!is_array($file_array))
		{
			$file_array = array();
		}
		if (is_array($in_scripts))
		{
			$file_array = $file_array + $in_scripts;
		}
		
		return $this->build_file_list($file_array,$js_stub,"js/");
	}

	public function js_vars($page, $in_vars = NULL)
	{
		$output = "";
		$config_vars = $this->config->item('include.jsvars.' . $page); 
		$vars = $this->config->item('include.jsvars.global');
		if (is_array($config_vars))
		{
			$vars = $vars + $config_vars;
		}
		//echo var_dump($vars);
		$vars['image_path'] = base_url() . "images";

		if (!is_null($in_vars))
		{
			$vars = array_merge($vars,$in_vars);
		}
		foreach ($vars as $key => $var)
		{
			if (is_array($var))
			{
				$var = $this->array_to_var($var);
			}
			if (!$this->is_literal($var))
			{
				$var = $this->enquote($var);
			}
			$output .= "\tvar " . $key . " = " . $var . ";\n";
		}
		return $output;
	}
	
	private function array_to_var($array_var)
	{
		$out_var = "";
		$object_parts = array();
		$array_parts = array();
		foreach ($array_var as $key => $value)
		{
			$object_parts[] = "'" . $key . "' : \"$value\"";
			$array_parts[] = "\"$value\"";
		}
		if ($this->is_assoc($array_var))
		{
			$out_var = "{ " . implode(",", $object_parts) . " }{literal}";
		}
		else 
		{
			$out_var = "[ " . implode(",", $array_parts) . " ]{literal}";
		}
		return $out_var;
	}
	
	private function build_file_list ($file_array, $stub, $src_path)
	{
		$file_list = "";
		//echo var_dump($file_array);
		if (!is_array($file_array))
		{
			return null;
		}
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
	
	private function enquote($in_string)
	{
		return '"' . $in_string . '"';
	}
	
	//*** Test whether array is associative
	private function is_assoc($array) 
	{
	  return (bool)count(array_filter(array_keys($array), 'is_string'));
	}

	//*** When you need to pass true or false to a JS var, prefix with {literal} (e.g., "{literal}true")
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

//*** END of FILE AppInclude.php