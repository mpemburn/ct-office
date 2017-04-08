<?php
error_reporting(E_ALL);
require_once("./classes/constants.php");
require_once("./classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();

/*
$sql = "SELECT * FROM site_members WHERE LENGTH(system_name) > 0;";
$results = mysql_query($sql,$conn);
while ($row = mysql_fetch_assoc($results))
{
	$system_name = $row['system_name'];
	$system_id = get_system_id($conn,$system_name);
	
	echo "UPDATE site_members SET system_id = '$system_id' WHERE system_name = '$system_name';<br />";
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
exit;
*/
$in = "'2','3','11','12','20','21','34','35','36','37','38','43','44','49','55','56','60','61','62','64','65','66','67'";

$sql = "SELECT * FROM site_members WHERE member_id IN($in);";
$results = mysql_query($sql,$conn);

while ($row = mysql_fetch_assoc($results))
{
	$member_id = $row['member_id']; 
	$member_name = $row['member_name'];
	if (strstr($member_name," - "))
	{
		$name_split = explode(" - ",$member_name);
		$system_name = $name_split[0];
		$member_name = $name_split[1];
		echo "UPDATE site_members SET member_name = '$member_name', system_name = '$system_name' WHERE member_id = '$member_id';<br />";
	}
}
