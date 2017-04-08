<?php
error_reporting(E_ALL);
require_once("./classes/constants.php");
require_once("./classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();

$sql = "SELECT * FROM cto_contracts WHERE LENGTH(services_count) > 0;";
$results = mysql_query($sql,$conn);

while ($row = mysql_fetch_assoc($results))
{
	$data = array();
	$data['contract_id'] =  "'" . $row['contract_id'] . "'";
	$data['services_count'] =  "'" . $row['services_count'] . "'";
	$data['services_total_amount'] =  "'" . $row['services_total_amount'] . "'";
	$data['services_interval'] = "'" . $row['services_interval'] . "'";
	$data['services_start_date'] =  "'" . $row['services_start_date'] . "'";
	$keys = array_keys($data);
	$values = array_values($data);
	$insert = "INSERT INTO cto_contract_services (" . implode(",", $keys) .") VALUES(" . implode(",", $values) .");";
	echo $insert . "<br />";	
}
