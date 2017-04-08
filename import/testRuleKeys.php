<?php
require_once("./classes/constants.php");
require_once("./classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();

$sql = "SELECT * FROM site_resource_rules;";
$results = mysql_query($sql,$conn);

while ($row = mysql_fetch_assoc($results))
{
	$resource_id = $row['resource_id'];
	$t_sql = "SELECT * FROM site_vendor_resources WHERE resource_id = '" . $resource_id . "';";
	//echo $t_sql."<br />";
	$t_results = mysql_query($t_sql,$conn);
	if ($t_row = mysql_fetch_assoc($t_results))
	{
		//echo "OK<br />";
	}
	else
	{
		$vendor_id = $t_row['vendor_id'];
		echo "NOK - $resource_id -- $vendor_id <br />";
	}
}
