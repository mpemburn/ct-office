<?php
require_once("./classes/constants.php");
require_once("./classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();

$sql = "SELECT member_id,ebsco,ovid,mgh,stat_ref,nejm,bmj FROM site_members;";

$results = mysql_query($sql,$conn);

$insert_stub = "INSERT INTO site_member_resources (resource_id,member_id,fiscal_year) VALUES (#VALUES#);";
$insert_sql = null;
$fiscal_year = "2012";

while ($row = mysql_fetch_assoc($results)) 
{
	$member_id = $row['member_id'];
    foreach ($row as $field => $value)
	{
		if ($field != "member_id")
		{
			if ($value == "1")
			{
				$values = "'" . $field . "','" . $member_id . "','" . $fiscal_year . "'";
				$insert_sql = str_replace("#VALUES#",$values,$insert_stub);
				$success = mysql_query($insert_sql,$conn);
				if ($success)
				{
					echo $insert_sql."<br />";
				}
			}
		}
	}
}

//*** END of import_Create_Member_Resources.php