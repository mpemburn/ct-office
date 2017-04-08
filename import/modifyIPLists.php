<?php
error_reporting(E_ALL);
require_once("./classes/constants.php");
require_once("./classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();

$sql = "SELECT member_id,ip_addresses FROM site_members WHERE ip_addresses LIKE('%;%') OR ip_addresses LIKE('%,%');";
$results = mysql_query($sql,$conn);
while ($row = mysql_fetch_assoc($results))
{
	$member_id = $row['member_id'];
	$ip_addresses = $row['ip_addresses'];
	$ip_addresses = str_replace("; ","\n",$ip_addresses);
	
	echo "UPDATE site_members SET ip_addresses = '$ip_addresses' WHERE member_id = '$member_id';";
}

function get_system_id($conn, $system_name)
{
	$system_id = null;
	$sql = "SELECT system_id FROM site_systems WHERE system_name = '$system_name';";
	$results = mysql_query($sql,$conn);
	
	while ($row = mysql_fetch_assoc($results))
	{
		$system_id = $row['system_id'];
	}
	
	return $system_id;
}
