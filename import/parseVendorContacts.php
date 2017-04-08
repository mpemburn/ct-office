<?php
require_once("./classes/constants.php");
require_once("./classes/DB_connect.php");
require_once("./classes/nameParser.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();
$parser = new nameParser();

$contacts = file("Vendor_Contacts.txt");
$record = array();
$i = 0;
foreach ($contacts as $contact)
{
	$cFields = explode("\t",$contact);
	$f = 0;
	foreach ($cFields as $field)
	{
		if ($i == 0)
		{
			$fields[] = trim($field);
			//echo "`$field`,";
		}
		else
		{
			$record[$fields[$f]] = $field;
		}
		$f++;
	}
	if ($i > 0)
	{
		//echo var_dump($record);
		$parser->setFullName($record['contact_name']);
		$parser->parse();
		$prefix = requote($parser->getTitle());
		$last_name = requote($parser->getLastName());
		$first_name = requote($parser->getFirstName());
		$middle_name = requote($parser->getMiddleName());
		$suffix = requote($parser->getSuffix());
		$contact_name = requote($record['contact_name']);
		foreach ($fields as $field)
		{
			if ($field == "vendor_name")
			{
				$record[$field] = strtolower(str_replace("!","_",$record[$field]));
			}
			$$field = requote($record[$field]);
		}
		
		$sql = "INSERT INTO `site_contacts` (`contact_type`,`contact_entity_id`,`full_name`,`contact_address_1`,`contact_city`,`contact_state`,`contact_zip`,`contact_phone_1`,`contact_phone_2`,`contact_fax`,`contact_email_address`,`contact_prefix`,`contact_first_name`,`contact_middle_name`,`contact_last_name`,`contact_suffix`) ";
		$sql .= "VALUES ('vendor','$vendor_name','$contact_name','$contact_address_1','$contact_city','$contact_state','$contact_zip','$contact_phone_1','$contact_phone_2','$contact_fax','$contact_email_address','$prefix','$first_name','$middle_name','$last_name','$suffix');";
		echo $sql."<br />";
	}
	$i++;
}

exit;

$sql = "SELECT * FROM site_members WHERE NOT system_id = 0;";
$results = mysql_query($sql,$conn);

while ($row = mysql_fetch_assoc($results))
{
	$system_id = $row['system_id'];
	$system_name = get_system_name($conn,$system_id);
	echo "UPDATE site_members SET system_name = '$system_name' WHERE system_id = '$system_id';<br />";
}

function get_system_name($conn,$system_id)
{
	$sql = "SELECT * FROM site_systems WHERE system_id = '$system_id';";
	$system_name = null;
	$results = mysql_query($sql,$conn);
	if ($row = mysql_fetch_assoc($results))
	{
		$system_name = $row['system_name'];
	}
	return $system_name;
}
exit;
$parser = new nameParser();

$sql = "SELECT DISTINCT `contact_name` FROM  `site_members` ORDER BY  `contact_name` ";
$results = mysql_query($sql,$conn);

while ($row = mysql_fetch_assoc($results))
{
	$contact_name = $row['contact_name'];
	$parser->setFullName($contact_name);
	$parser->parse();
	$prefix = requote($parser->getTitle());
	$last_name = requote($parser->getLastName());
	$first_name = requote($parser->getFirstName());
	$middle_name = requote($parser->getMiddleName());
	$suffix = requote($parser->getSuffix());
	$contact_name = requote($contact_name);
	
	$sql = "INSERT INTO `site_contacts` (`contact_prefix`, `contact_first_name`, `contact_middle_name`, `contact_last_name`, `contact_suffix`, `full_name`) ";
	$sql .= "VALUES ('$prefix','$first_name','$middle_name','$last_name','$suffix','$contact_name');";
	echo $sql."<br />";
}

function requote($in)
{
	return str_replace("'","''",$in);
}