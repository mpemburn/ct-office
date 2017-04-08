<?php
class ParseImagemap
{
	var $document = null;
	
	public function __construct() 
	{
	}
	
	public function read_map($file_name, $output_type = "integer")
	{
		$map_array = file($file_name);		
		
		$out_values = array();
		foreach ($map_array as $line)
		{
			$parsed = array();
			if (strstr($line,"<area"))
			{
				$line = str_replace("\"","",$line);
				if ($output_type == "percent")
				{
					$parsed['coords'] = $this->get_coords_as_percent($line,$image_width,$image_height);
				}
				if ($output_type == "integer")
				{
					$parsed['coords'] = $this->get_coords($line);
				}
				$parsed['field_name'] = $this->get_value($line,"href");
				$parsed['field_type'] = $this->get_value($line,"target");
				$parsed['action'] = $this->get_value($line,"alt");
			}
			if (sizeof($parsed) != 0)
			{
				$out_values[] = $parsed;
			}
		}
		return $out_values;
		
	}
	
	private function get_coords_as_percent($in_string, $image_width, $image_height)
	{
		$out_coords = array();
		$coords = $this->get_coords($in_string);
		foreach ($coords as $key => $value)
		{
			//*** Create a value named for the coordinate
			switch ($key)
			{
				case "x" :
				 	$value = $value / $image_width;
					break;
				case "y" :
				 	$value = $value / $image_height;
					break;
				case "width" :
				 	$value = $value / $image_width;
					break;
				case "height" :
				 	$value = $value / $image_height;
					break;
			}
			$value = $this->fnumber_format(($value * 100),2,".","") . "%";
			$out_coords[$key] = $value;
			//echo $key . " - " . $value . "\n";
		}
		return $out_coords;
	}
	
	private function get_coords($in_string)
	{
		$coords = array('x','y','width','height');
		$coords = array_flip($coords);
		$m = preg_match("/coords\=[0-9,]+/",$in_string,$matches);
		if ($m)
		{
			$c = str_replace("coords=","",$matches[0]);
			$c_array = explode(",",$c);
			foreach ($coords as $coord => $key)
			{
				$value = intval($c_array[$key]);
				$$coord = $value;
				switch ($coord)
				{
					case "width" :
					 	$value = $value - $x;
						break;
					case "height" :
					 	$value = $value - $y;
						break;
				}
				 $coords[$coord] = $value;
			}
		}
		return $coords;
	}
	
	private function get_value($in_string, $attribute)
	{
		$m = preg_match("/$attribute\=[a-zA-Z_]+/",$in_string,$matches);
		if ($m)
		{
			$field = str_replace("$attribute=","",$matches[0]);
			return $field;
		}
		return NULL;
	}
	
	private function fnumber_format($number, $decimals='', $sep1='', $sep2='') {
	
		if (($number * pow(10 , $decimals + 1) % 10 ) == 5)  //if next not significant digit is 5
		{
			$number -= pow(10 , -($decimals+1));
		}
	
		return number_format($number, $decimals, $sep1, $sep2);
	
	}
}

//*** END OF FILE ParseImagemap.php