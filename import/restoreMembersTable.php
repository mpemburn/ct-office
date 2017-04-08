<?php
error_reporting(E_ALL);
require_once("./classes/constants.php");
require_once("./classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();

$column = array();

$columnsSQL = "SHOW COLUMNS IN site_members;";
$results = mysql_query($columnsSQL,$conn);
while ($row = mysql_fetch_assoc($results))
{
	$column[] = $row['Field'];
}

$sql = "SELECT * FROM site_members_archive;";
$results = mysql_query($sql,$conn);

while ($row = mysql_fetch_assoc($results))
{
	$member_id = $row['member_id']; 
	foreach ($row as $field => $value)
	{
		$value = str_replace("'","''",$value);
		if ($field == "address_2" && $value == "0")
		{
			$value = "";
		}
		echo "UPDATE site_members SET $field = '$value' WHERE member_id = '$member_id';<br />";
	}
}
