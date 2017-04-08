<?php
require_once("./classes/constants.php");
require_once("./classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();
//echo $conn;

$sql = "SELECT * 
FROM  `z_import_HSLANJ Membership Directory` 
WHERE LENGTH(  `Institution` ) >0
GROUP BY  `Institution` ;";

$count = 0;
/*
Field
MemberID
Institution
Library Name
Last Name
First Name
MemberTypeID2003
MemberTypeID2004
MemberTypeID2005
MemberTypeID2006
MemberTypeID2007
Title
Address
City
State
Zip
Phone
Ext
Fax
Email
Degrees
AHIPID
CHIS
Library Website
Institutional Website
JerseyCat
Consortium
Serhold
Docline
Docline ID
Region
CD&L
CD&LNumber
PageNumber
*/

$var_lengths = array();
$var_length = "40";
$after = "ip_addresses";
$alter = "ALTER TABLE  `site_members` ADD  `foo` VARCHAR($var_length) NULL AFTER `$after`;";

$include = array('MemberTypeID2003','MemberTypeID2004','MemberTypeID2005','MemberTypeID2006','MemberTypeID2007','Degrees','AHIPID','CHIS','Library Website','Institutional Website','PageNumber');

$institution_names = array();
$member_names = array();

$results = mysql_query($sql,$conn);
while ($row = mysql_fetch_assoc($results))
{
	$MemberTypeID2007 = $row['MemberTypeID2007'];
	$member_id = $row['MemberID'];
	$institution = $row['Institution'];
	//$member_name = find_member($conn,$institution);
	$institution_names[$member_id] = array(
		'member_name' => $institution
	);
	foreach ($row as $field => $value)
	{
		$len = strlen($value);
		if (!isset($var_lengths[$field]))
		{
			$var_lengths[$field] = $len;
		}
		else
		{
			$var_lengths[$field] = ($len > $var_lengths[$field]) ? $len : $var_lengths[$field];
		}
		if (in_array($field,$include))
		{
			$institution_names[$member_id][$field] = $value;
		}
	}
}
/*
foreach ($include as $field)
{
	$len = $var_lengths[$field]."<br />";
	$len = intval(ceil($len/10) * 10);
	$alter = "ALTER TABLE  `site_members` ADD  `$field` VARCHAR($len) NULL AFTER `$after`;";
	$sql = $alter; //str_replace(array(),array(),$alter);
	echo $alter."<br />";
	$after = $field;
}

exit;
*/
$sql = "SELECT * FROM site_members;";
$results = mysql_query($sql,$conn);
while ($row = mysql_fetch_assoc($results))
{
	$member_id = $row['member_id'];
	$member_name = $row['member_name'];
	$member_names[$member_id]  = array(
		'member_name' => $member_name
	);
}

foreach ($institution_names as $institution)
{
	foreach ($member_names as $member_id => $member_name)
	{
		$distance = levenshtein(strtolower($institution['member_name']),strtolower($member_name['member_name']));
		if ($distance < 4)
		{
			//echo $institution['member_name'] . " = " . $member_name['member_name'] . "<br />";
			$vals = array();
			foreach ($include as $field)
			{
				$values[] = "`$field` = '" . requote($institution[$field]) . "'";
			}
			echo "UPDATE site_members SET " . implode(",",$values) . " WHERE member_id = '$member_id';"."<br />";
			//$count++;
		}
	}
}


//echo $count;
function find_member($conn,$member_name)
{
	$member_name = requote($member_name);
	$sql = "SELECT * FROM site_members WHERE member_name = '$member_name';";
	//echo $sql."<br />";
	$member_name = null;
	$results = mysql_query($sql,$conn);
	if ($row = mysql_fetch_assoc($results))
	{
		$member_name = $row['member_name'];
	}
	return $member_name;
}

function requote($in)
{
	return str_replace("'","''",$in);
}