<?php
error_reporting(E_ALL);
require_once("../classes/constants.php");
require_once("../classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();

$fileA = file_get_contents("../test/tabTest.php");
$fileB = file_get_contents("../test/tabTestB.php");

$fileA = clean($fileA);
$fileB = clean($fileB);

echo "<style>
ins { 
	color: blue; text-decoration: none; 
}

del { 
	color: red; 
}
</style>";

echo delta_html($fileA,$fileB);
//echo delta_html("Yo mamba","Y mama");

/*
foreach ($file as $line)
{
	$found = array();
	preg_match_all("/_[A-Za-z]+/",$line,$found);
	if (sizeof($found) > 0)
	{
		$matches = array();
		$replace = array();
		$match = $found[0];
		for ($m=0; $m<sizeof($match); $m++) 
		{
			$word = $match[$m];
			$reword = ucwords(str_replace(array("_","id"),array("","ID"),$word));
			$line = str_replace($word,$reword,$line);
			if (strstr($line,"	function"))
			{
				$line = str_replace(array("	function ","("),array("	this."," = function ("),$line);
				//echo $line."\n";
			}
		}
	}
	echo $line;
}
*/

function clean($instring) {
	return str_replace(array("<",">","\n","\t"),array("&lt;","&gt;","<br />","&nbsp;"),$instring);
}

function delta_html($old, $new) {
	$ret = null;
	$diff = delta_diff(explode(' ', $old), explode(' ', $new));
	foreach($diff as $k) {
		if (is_array($k))
			$ret .= (!empty($k['d'])?"<del>".implode(' ',$k['d'])."</del> ":'').(!empty($k['i'])?"<ins>".implode(' ',$k['i'])."</ins> ":'');
		else $ret .= $k . ' ';
	}
	return $ret;
}


function delta_diff($old, $new) {
	$maxlen = 0;
	foreach($old as $oindex => $ovalue) {
		$nkeys = array_keys($new, $ovalue);
		foreach($nkeys as $nindex) {
			$matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ?
			$matrix[$oindex - 1][$nindex - 1] + 1 : 1;
			if($matrix[$oindex][$nindex] > $maxlen) {
				$maxlen = $matrix[$oindex][$nindex];
				$omax = $oindex + 1 - $maxlen;
				$nmax = $nindex + 1 - $maxlen;
			}
		}
	}
	if ($maxlen == 0) return array(array('d'=>$old, 'i'=>$new));
		return array_merge(delta_diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),array_slice($new, $nmax, $maxlen),delta_diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen)));
}
 

//*** End of File