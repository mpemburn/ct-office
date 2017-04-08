<?php
error_reporting(E_ALL);
require_once("../classes/constants.php");
require_once("../classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();

$columns = array();
$query = array();

$table = 'site_membership_tally';

$sql = "SHOW COLUMNS IN $table;";

$results = mysql_query($sql,$conn);

while ($row = mysql_fetch_assoc($results))
{
	$columns[] = "'" . $row['Field'] . "' => $" . $row['Field'];
	$query[] = $row['Field'] . "=\" + $(\"#" . $row['Field'] . "\").val() + \"";
}

//echo "array(" . implode(", ",$columns) . ")";
echo "\"" . implode("&",$query) . "";
