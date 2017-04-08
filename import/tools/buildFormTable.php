<?php
require_once("../classes/ParseImagemap.php");
require_once("../classes/constants.php");
require_once("../classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();
$columns = array();

//$mode = "CREATE";
$mode = "ALTER";

$sql = "SHOW COLUMNS IN cto_contracts;";
$results = mysql_query($sql,$conn);

while ($row = mysql_fetch_assoc($results))
{
	$columns[] = $row['Field'];
}

$parser = new ParseImagemap();

//$out = $parser->read_map("../../documents/termite_contract_1.html");
//$out = $parser->read_map("../../documents/pest_contract_1.html");
$out = $parser->read_map("../../documents/construction_contract_1.html");
//echo var_dump($out);

$main_gen_fields = "";
$chk_gen_fields = "";
$already = array();
$field_sizes = array('state' => 2, 'phone' => 20, 'zip' => 10);

foreach ($out as $line)
{
	$field_name = $line['field_name'];
	$field_type = $line['field_type'];
	$field_action = $line['action'];
	$field_size = intval($line['coords']['width']);
	$field_size = intval(ceil($field_size/50) * 10);
	$field_size = set_size($field_name, $field_sizes, $field_size);
	$main_field = null;
	switch ($field_type)
	{
		case "service_checkbox" :
			$chk_field = "\t`$field_name` TINYINT (4) DEFAULT '0',\n";
			$chk_gen_fields .= $chk_field;			
		case "trigger_checkbox" :
			break;
		case "checkbox" :
			$main_field = "\t`$field_name` TINYINT (4) DEFAULT '0',\n";
			break;
		case "date" :
			$main_field = "\t`$field_name` DATE NOT NULL,\n";
			break;
		case "radio" :
			$main_field = "\t`$field_action` INT(11) NULL,\n";
			break;
		case "image" :
			break;
		case "textarea" :
			$main_field = "\t`$field_name` TEXT NULL,\n";
			break;
		case "dollar_text" :
			$main_field = "\t`$field_name` DECIMAL (19,2) NOT NULL DEFAULT '0.00',\n";
			break;
		case "hidden_text" :
		case "cc_text" :
			$main_field = "\t`$field_name` VARCHAR($field_size) NULL,\n";
			break;
		case "text" :
		case "numeric_text" :
		case "phone_text" :
		case "zip_text" :
		case "select" :
			$main_field = "\t`$field_name` VARCHAR($field_size) NOT NULL,\n";
			break;
	}
	if (!is_null($main_field) && !in_array($main_field, $already))
	{
		$main_gen_fields .= $main_field;
		$already[] = $main_field;
		
		if ($mode == "ALTER" && !in_array($field_name, $columns))
		{
			$field_info = str_replace(array(",\n","\t"), array(";\n"," "), $main_field);
			$alter = "ALTER TABLE `cto_contracts` ADD $field_info";
			//ALTER TABLE  `cto_contracts` ADD  `zzz` DECIMAL( 19.3 ) NOT NULL DEFAULT  '0.00'
			echo $alter;
		}
	}
}

$main_stub = "
DROP TABLE IF EXISTS `cto_contracts`;
CREATE TABLE `cto_contracts` (
	`contract_id` INT (11) NOT NULL AUTO_INCREMENT,
	`guid` VARCHAR (40) NOT NULL,
	`cc_encrypted` VARCHAR (50) NOT NULL,
	`signature_encrypted` TEXT NOT NULL,
	`customer_email` VARCHAR (100) NOT NULL,
$main_gen_fields
	`time_stamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`contract_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
\n\n";

$check_stub = "
DROP TABLE IF EXISTS `cto_contract_items`;
CREATE TABLE `cto_contract_items` (
	`contract_item_id` int(11) NOT NULL AUTO_INCREMENT,
	`contract_id` int(11),
$chk_gen_fields
	`time_stamp` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`contract_item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
";


if ($mode == "CREATE")
{
	echo $main_stub;
	echo $check_stub;
}

function set_size($field_name, $size_array, $default_size)
{
	foreach ($size_array as $key => $value)
	{
		if (strstr($field_name,$key))
		{
			return $value;
		}
	}
	return $default_size;
}

//*** END OF FILE buildFormTable.php