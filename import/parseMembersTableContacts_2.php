<?php
error_reporting(0);
require_once("./classes/constants.php");
require_once("./classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();

//$sql = "SELECT contact_name FROM site_members ORDER BY contact_name ";
$sql = "SELECT * FROM site_contacts;";
$results = mysql_query($sql,$conn);

while ($row = mysql_fetch_assoc($results))
{
	$full_name = $row['full_name'];
	$m_sql = "SELECT * FROM site_members WHERE contact_name = '$full_name';";
	$data = get_member_data($conn,$m_sql);
	if (sizeof($data) > 1)
	{	
		echo $full_name."\n";
		echo var_dump($data);
	}
}

function requote($in)
{
	return str_replace("'","''",$in);
}

function get_member_data($conn,$sql)
{
	$data = array();
	$results = mysql_query($sql,$conn);
	while ($row = mysql_fetch_assoc($results))
	{
		$data[] = $row['contact_title'];
	}
	return $data;
}