<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_Generate_Mvc {
	var $stub_path;

	public function __construct() 
	{
		$this->stub_path = "mvc_stubs";
	}

	//*** Magic method __get gives us access to the parent CI object
	public function __get($var)    
	{
	   static $CI;
	   (is_object($CI)) OR $CI = get_instance();
	   return $CI->$var;
	}

	public function generate($mvc_name, $over_write = FALSE)
	{
		$output = "";
		if (strlen($mvc_name) == 0) {
		    return array('output' => "No MVC has been specified.");
		}
		//** Convert name to title case 
		$library_name = $this->make_title_case($mvc_name);
		
		$output .= $this->generate_file($mvc_name, "css/app/", ".css");
		$output .= $this->generate_file($mvc_name, "js/app/", ".js");
		$output .= $this->generate_file($mvc_name, "js/app/", ".js", "manager_stub");
		$output .= $this->generate_file($mvc_name, "application/controllers/", ".php", "controller_stub");
		$output .= $this->generate_file($mvc_name, "application/models/", ".php", "model_stub", $mvc_name . "_model");
		$output .= $this->generate_file($mvc_name, "application/libraries/", ".php", "library_stub", $library_name);
		$output .= $this->generate_view($mvc_name, "application/views/", ".php", "index");
		
		$config_snippet = $this->generate_config($mvc_name, "config_stub");
		return array('config_snippet' => $config_snippet, 'output' => $output);
		
	}
	
	private function generate_file($mvc_name, $file_path, $file_ext, $stub_name = "stub", $new_file_name = NULL)
	{
		$output = "";
		$start_comment = "/***";
		$end_comment = "***/";
		$manager_suffix = (stristr($stub_name, "manager") !== FALSE) ? "_manager" : "";
		$uc_mvc = $this->make_title_case($mvc_name);
		$new_file_name = (is_null($new_file_name)) ? $mvc_name : $new_file_name;
		$filename = $file_path . $new_file_name . $manager_suffix . $file_ext;
		if (!file_exists($filename)) 
		{
			$stub_file = $this->stub_path . "/$stub_name$file_ext";
			if (file_exists($stub_file))
			{
				if (strstr($stub_name, "index") !== FALSE)
				{
					$start_comment = "<!--";
					$end_comment = "-->";
				}
				$stub = file($stub_file);
				$fp = fopen($filename, 'w');
				foreach ($stub as $line)
				{
					$line = str_replace("{ClassName}", $uc_mvc, $line);
					$line = str_replace("{ClassNameToLower}", $mvc_name, $line);
					$line = str_replace("{ModelName}", $mvc_name . "_model", $line);
					fwrite($fp, $line);
				}
				fwrite($fp, "$start_comment End of File /$filename $end_comment");
				fclose($fp);
				$output = "Generated $filename file<br />";
			}
			else 
			{
				$output = "Can't find $stub_file<br />";
			}
		}
		else 
		{
			$output = "File already exists: $filename<br />";
		}
		return $output;
	}

	private function generate_config($mvc_name, $stub_name = "stub")
	{
		$config_snippet = "\n\n\n\n\n";
		$uc_mvc = $this->make_title_case($mvc_name);
		$mvc_name = strtolower($mvc_name);
		$stub_file = "mvc_stubs/$stub_name.php";
		if (file_exists($stub_file))
		{
			$stub = file($stub_file);
			foreach ($stub as $line)
			{
				$line = str_replace("{ClassName}", $uc_mvc, $line);
				$line = str_replace("{ClassNameToLower}", $mvc_name, $line);
				$config_snippet .= $line;
			}
		}
		
		return "<pre>" . $config_snippet . "</pre>";
	}

	private function generate_view($mvc_name, $file_path, $file_ext, $view_name)
	{
		$view_dir = $file_path . strtolower($mvc_name);
		if (!file_exists($view_dir))
		{
			mkdir($view_dir);
		}
		$output = $this->generate_file($mvc_name, $view_dir . "/", ".php", $view_name . "_stub");
		rename($view_dir . "/" . $mvc_name . ".php", $view_dir . "/$view_name$file_ext");
		
		return $output;
	}

	private function make_title_case ($name)
	{
		$space_name = str_replace("_", " ", $name);
		$uc_name = ucwords($space_name);
		$uc_name = str_replace(" ", "_", $uc_name);
		
		return $uc_name;
	}

} //*** End of class Generate_Mvc
//*** END of FILE

