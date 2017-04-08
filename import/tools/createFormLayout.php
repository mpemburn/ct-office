<?php
error_reporting(E_ALL);
require_once("./classes/constants.php");
require_once("./classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();

$sql = "SHOW COLUMNS IN site_members;";
$results = mysql_query($sql,$conn);
while ($row = mysql_fetch_assoc($results))
{
	$field_name = $row['Field'];
	$field_label = ucwords(str_replace("_"," ",$field_name));
	$value_field = '{$member_info.' . $field_name . '}';
$cell = 
"			<div class=\"form_cell\">
				<div class=\"form_label\">
					$field_label
				</div>
				<div class=\"form_field\">
					<input id=\"$field_name\" name=\"$field_name\" class=\"text\" type=\"text\" value=\"$value_field\">
				</div>
			</div>
";
	
	echo $cell;
}

