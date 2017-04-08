<?php
require_once("./classes/DB_import.php");
require_once("./classes/constants.php");
require_once("./classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();
//echo $conn;

$db_import = new DB_import("Members_File.txt","members","site_");

$create_sql = $db_import->get_create_table();

$success = mysql_query($create_sql,$conn);
//echo $result;
if ($success)
{
	$inserts = $db_import->get_inserts();
	foreach ($inserts as $insert)
	{
		$success = mysql_query($insert,$conn);
	}
}

//*** End of import_Members_File.php