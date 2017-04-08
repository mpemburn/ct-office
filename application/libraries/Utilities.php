<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_Utilities {
	var $conn = null;
	var $request;
	var $resources = null;
	var $subcategories = null;
	var $resource_id = null;
	var $resource_name = null;
	var $resource_info = null;
	
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
	
	//*** Restore field names to array of coordinates orignated by sigPad jQuery plug-in
	public function expand_coordinates($coords_in, $output_type = "json")
	{
		$coord_array = explode(",", $coords_in);
		
		$i = 0;
		$c = 0;
		$coord_set = null;
		$coords = array();
		$fields = array('lx','ly','mx','my');
		
		foreach ($coord_array as $coord)
		{
			if ($i % 4 == 0)
			{
				if (isset($lx))
				{
					$coord_set = array('lx' => $lx, 'ly' => $ly, 'mx' => $mx, 'my' => $my);
					$coords[] = $coord_set;
				}
				$c = 0;
			}
			$$fields[$c] = $coord;
			$c++;
			$i++;
		}
		
		if ($output_type == "json")
		{
			$coords = json_encode($coords);
		}
		
		return $coords;
	}

	public function get_month_array($full_name = FALSE)
	{
		$format = ($full_name) ? "F" : "M";
		$month_array = array();
		for ($i=1; $i<=12; $i++)
		{
			$month_array[] = date($format, strtotime("$i/1/2000"));
		}
		return $month_array;
	}

	public function hex2bin($str)
	{
		return pack("H*",$str);
	}
	
	function replace_var($in_string, $var, $replace)
	{
		$out_string = $in_string;
		$m = preg_match_all("/{[a-z_]+}/",$in_string,$matches);
		if ($m)
		{
			foreach ($matches[0] as $match)
			{
				$out_string = str_replace($match,$replace,$out_string);
			}
		}
		return $out_string;
	}
	
	/* 	$in_string: String containing variable to be replaced, enclosed in curly braces
	*	e.g., The {precip} in Spain {action} mainly on the plain.
	*
	*	$replace: May be the replacement value as a string:
	*	If $replace is "dogs", the result would be "The dogs in Spain dogs mainly on the plain"
	* 	- or -
	*	$replace may be an associative array as: array('precip' => "rain", 'action' => "falls")
	*	results in: "The rain in Spain falls mainly on the plain";
	*/
	
	public function replace_vars($in_string, $replace)
	{
		$out_string = $in_string;
		$the_relpace = (is_array($replace)) ? "" : $replace;
		$m = preg_match_all("/{[a-z_]+}/",$in_string, $matches);
		if ($m)
		{
			foreach ($matches[0] as $match)
			{
				$clean_match = preg_replace("/[{}]+/","",$match);
				if (is_array($replace))
				{
					if (array_key_exists($clean_match,$replace))
					{
						$the_relpace = $replace[$clean_match];
					}
				}
				$out_string = str_replace($match, $the_relpace, $out_string);
			}
		}
		return $out_string;
	}

	public function rc4($key, $data)
	{
		// Store the vectors "S" has calculated
		static $SC;
		// Function to swaps values of the vector "S"
		$swap = create_function('&$v1, &$v2', '
			$v1 = $v1 ^ $v2;
			$v2 = $v1 ^ $v2;
			$v1 = $v1 ^ $v2;
		');
		$ikey = crc32($key);
		if (!isset($SC[$ikey])) {
			// Make the vector "S", basead in the key
			$S	= range(0, 255);
			$j	= 0;
			$n	= strlen($key);
			for ($i = 0; $i < 255; $i++) {
				$char  = ord($key{$i % $n});
				$j	 = ($j + $S[$i] + $char) % 256;
				$swap($S[$i], $S[$j]);
			}
			$SC[$ikey] = $S;
		} else {
			$S = $SC[$ikey];
		}
		// Crypt/decrypt the data
		$n	= strlen($data);
		$data = str_split($data, 1);
		$i	= $j = 0;
		for ($m = 0; $m < $n; $m++) {
			$i		= ($i + 1) % 256;
			$j		= ($j + $S[$i]) % 256;
			$swap($S[$i], $S[$j]);
			$char	 = ord($data[$m]);
			$char	 = $S[($S[$i] + $S[$j]) % 256] ^ $char;
			$data[$m] = chr($char);
		}
		return implode('', $data);
	}
	
} //*** End of class Utilities
//*** END of FILE

