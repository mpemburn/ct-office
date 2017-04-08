<?php

$sig_coords = "41,43,41,42,40,42,41,43,38,41,40,42,35,40,38,41,30,37,35,40,26,33,30,37,23,28,26,33,21,23,23,28,21,20,21,23,21,18,21,20,21,16,21,18,23,13,21,16,27,12,23,13,32,12,27,12,40,11,32,12,43,11,40,11,50,11,43,11,55,11,50,11,59,11,55,11,61,11,59,11,63,12,61,11,64,14,63,12,65,18,64,14,65,21,65,18,65,25,65,21,65,33,65,25,64,36,65,33,58,44,64,36,57,46,58,44,53,48,57,46,51,49,53,48,49,50,51,49,47,50,49,50,43,54,47,50,42,55,43,54,42,56,42,55,42,57,42,56,42,58,42,57,42,59,42,58,43,59,42,59,47,59,43,59,52,59,47,59,61,55,52,59,69,51,61,55,74,50,69,51,80,47,74,50,88,44,80,47,91,42,88,44,92,41,91,42,94,41,92,41,95,41,94,41,96,41,95,41,97,41,96,41,99,41,97,41,100,41,99,41,100,43,100,41,101,46,100,43,102,47,101,46,102,48,102,47,102,49,102,48,103,49,102,49,104,49,103,49,107,49,104,49,112,49,107,49,114,49,112,49,117,49,114,49,120,49,117,49,124,48,120,49,127,47,124,48,130,47,127,47,131,47,130,47,131,46,131,47,136,46,131,46,138,46,136,46,139,46,138,46,144,50,139,46,148,57,144,50,152,63,148,57,153,64,152,63,155,69,153,64,158,71,155,69,160,73,158,71,161,73,160,73,162,73,161,73,164,73,162,73,170,71,164,73,178,67,170,71,187,62,178,67,199,56,187,62,209,51,199,56,212,49,209,51,221,45,212,49,233,39,221,45,240,37,233,39,243,36,240,37,251,34,243,36,258,33,251,34,263,32,258,33,272,31,263,32,278,31,272,31,286,31,278,31,297,31,286,31,301,32,297,31,313,39,301,32,324,47,313,39,334,56,324,47,342,64,334,56,346,68,342,64,349,71,346,68,350,73,349,71,351,74,350,73,352,74,351,74,353,75,352,74,354,75,353,75,355,75,354,75,357,75,355,75,358,75,357,75,359,75,358,75,360,75,359,75,360,73,360,75,360,72,360,73,360,71,360,72,360,70,360,71,360,69,360,70,360,68,360,69,361,68,360,68,364,67,361,68,366,66,364,67,370,65,366,66,373,63,370,65,374,63,373,63,377,62,374,63,378,62,377,62,380,61,378,62,382,61,380,61,383,61,382,61";

$coord_array = explode(",", $sig_coords);

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
echo var_dump(json_encode($coords));