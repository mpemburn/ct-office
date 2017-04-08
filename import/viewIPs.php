<?php
error_reporting(E_ALL);
require_once("./classes/constants.php");
require_once("./classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();

$sql = "SELECT ip_addresses FROM site_members WHERE LENGTH(ip_addresses) > 0;";
$results = mysql_query($sql,$conn);

while ($row = mysql_fetch_assoc($results))
{
	$ip_addresses = $row['ip_addresses'];
	$ip_addresses = str_replace(";","\n",$ip_addresses);
	echo $ip_addresses."\n\n";
	
}
