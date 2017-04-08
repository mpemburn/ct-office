<?php

function replace_var($in_string, $replace)
{
	$out_string = $in_string;
	$the_relpace = $replace;
	$m = preg_match_all("/{[a-z_]+}/",$in_string,$matches);
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
			$out_string = str_replace($match,$the_relpace,$out_string);
		}
	}
	return $out_string;
}

echo replace_var('here is a bit of {goop} for your {fluff}ernutter',array('fluff' => "dog",'goop' => "chicken"));
echo "<br />";
echo replace_var('here is a bit of {fluff} for your {fluff}ernutter',"cat");

	