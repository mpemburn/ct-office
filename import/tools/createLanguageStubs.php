<?php
error_reporting(E_ALL);
require_once("./classes/constants.php");
require_once("./classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();
$table_name = "site_contacts";
$sql = "SHOW COLUMNS IN $table_name;";
$results = mysql_query($sql,$conn);
while ($row = mysql_fetch_assoc($results))
{
	$field_name = $row['Field'];
	$field_label = ucwords(str_replace("_"," ",$field_name));
	$field_def = $table_name . "." . $field_name;
	$cell = '$'."lang['$field_def'] = \"$field_label\";\n";
	
	echo $cell;
}

