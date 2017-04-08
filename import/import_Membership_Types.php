<?php
require_once("./classes/constants.php");
require_once("./classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();


$insert_stub = "INSERT INTO site_membership_tally (member_id,member_type_id,membership_year,membership_dues_paid) VALUES (#VALUES#);";
$insert_sql = null;
$fiscal_year = "2012";
$value;
$sql = "SELECT * FROM site_members;";

$results = mysql_query($sql,$conn);

while ($row = mysql_fetch_assoc($results)) 
{
	$member_id = $row['member_id'];
    foreach ($row as $field => $value)
	{
		switch ($field)
		{
			case 'MemberTypeID2003' :
			case 'MemberTypeID2004' :
			case 'MemberTypeID2005' :
			case 'MemberTypeID2006' :
			case 'MemberTypeID2007' :
				if (strlen($row[$field]) > 0)
				{
					$member_type_id = $row[$field];
					$member_dues = get_membership_info($conn, $member_type_id);
					$year = str_replace("MemberTypeID","",$field);
					$insert_sql = str_replace("#VALUES#",$member_id . "," . $member_type_id . ",'" . $year . "','" . $member_dues . "'",$insert_stub);
					echo $insert_sql . "<br />";
				}
				break;
		}
	}
}

function get_membership_info($conn, $member_type_id)
{
	$member_dues = null;
	$sql = "SELECT * FROM site_member_types WHERE member_type_id = '$member_type_id';";
	$results = mysql_query($sql,$conn);
	if ($row = mysql_fetch_assoc($results)) 
	{
		$member_dues = $row['member_dues'];
	}
	return $member_dues;
}
//*** END of import_Membership_Types.php