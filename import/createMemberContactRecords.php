<?php
error_reporting(0);
require_once("./classes/constants.php");
require_once("./classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();

//$sql = "SELECT contact_name FROM site_members ORDER BY contact_name ";
$sql = "SELECT * FROM site_members;";
$results = mysql_query($sql,$conn);

while ($row = mysql_fetch_assoc($results))
{
	$full_name = $row['contact_name'];
	$member_id = $row['member_id'];
	$contact_id = get_contact_id($conn,$full_name);
	echo "INSERT INTO site_member_contacts (member_id,contact_id) VALUES ($member_id,$contact_id);<br />";
}

function requote($in)
{
	return str_replace("'","''",$in);
}

function get_contact_id($conn,$full_name)
{
	$full_name = requote($full_name);
	$sql = "SELECT * FROM site_contacts WHERE full_name = '$full_name';";
	$contact_id = null;
	$results = mysql_query($sql,$conn);
	if ($row = mysql_fetch_assoc($results))
	{
		$contact_id = $row['contact_id'];
	}
	return $contact_id;
}