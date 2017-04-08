<?php
error_reporting(E_ALL);
require_once("../../classes/constants.php");
require_once("../../classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();

$file = file("../../js/jquery.select_plus.js");
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
//*** End of File

exit;
	$found = array();
	preg_match_all("/`[A-Za-z]+`/",$line,$found);
	if (sizeof($found) > 0)
	{
		$matches = array();
		$replace = array();
		$match = $found[0];
		for ($m=0; $m<sizeof($match); $m++) 
		{
			$reword = "";
			$word = $match[$m];
			$len = strlen($word);
			$i = 0;
			while ($i < $len)
			{
				$char = substr($word,$i,1);
				if ($i > 1 && $char != "`" && $char == strtoupper($char))
				{
					$char = "_" . $char;
				}
				$reword .= $char;
				$i++;
			}
			$reword = strtolower($reword);
			$reword = str_replace("i_d","id",$reword);
			$matches[] = $word;
			$replace[] = $reword;
		}
		$line = str_replace($matches,$replace,$line);
	}
