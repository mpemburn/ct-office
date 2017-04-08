<?php
require_once("./classes/constants.php");
require_once("./classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();

$in_file = file("vendor_resources.txt");
$insert_stub = "INSERT INTO site_vendor_resources (vendor_id,resource_id,resource_has_children,resource_subcategory_of,resource_name) VALUES (#VALUES#);";
$insert_sql = null;
$has_children = "0";
$subcat_of = null;
$has_subcat = FALSE;
$already = array();
$i = 0;

foreach ($in_file as $vendor)
{
	$i = 0;
	if (strstr($vendor,"#"))
	{
		continue;
	}
	$resources = explode("\t",$vendor);
	foreach ($resources as $resource)
	{
		if ($i == 0)
		{
			$vendor_id = $resource;
			if (strstr($vendor_id,">"))
			{
				$vendor_id = str_replace(">","",$vendor_id);
				$has_subcat = TRUE;
			}
		}
		else
		{
			$abbrev = create_abbrev($resource);
			if (in_array($abbrev,$already))
			{
				$abbrev .= "_" . $vendor_id;
			}
			$has_children = ($has_subcat) ? "1" : "0";
			//$abbrev = get_unique($conn,$abbrev,$vendor_id);
			$values = "'" . $vendor_id . "','" . $abbrev . "','" . $has_children . "','" . $subcat_of . "','" . str_replace("'","''",$resource) . "'";
			$insert_sql = str_replace("#VALUES#",$values,$insert_stub);
			echo $insert_sql . "<br />";
			$already[] = $abbrev;
			
		}
		$i++;
	}
	if ($has_subcat) {
		$subcat_of = $abbrev;
		$has_subcat = FALSE;
	}
	else
	{
		$subcat_of = null;
	}
}

function create_abbrev($in_string)
{
	$out_string = strtolower($in_string);
	$out_string = preg_replace("/[^a-z 0-9]+/","",$out_string);
	$out_string = str_replace(" ","_",$out_string);
	$find = array(
		"hospital",
		"nursing",
		"collection",
		"surgery",
		"critical",
		"medicine",
		"medical",
		"england",
		"with",
		"of_",
		"and_",
		"for_",
		"essentials",
		"rehabilitation",
		"hypertension",
		"infection",
		"reference",
		"source",
		"comprehensive",
		"complementary",
		"alternative",
		"diagnostic",
		"laboratory",
		"journal",
		"psychiatric",
		"pediatric",
		"obstetric",
		"gynecologic",
		"gynecology",
		"physiology",
		"nephrology",
		"cardiovascular",
		"cardiology",
		"circulation",
		"management",
		"manual",
		"computers",
		"universal",
		"lippincott",
		"documentation",
		"education",
		"association",
		"extended",
		"practice",
		"principles",
		"intravenous",
		"current_opinion",
		"__"
	);
	$replace = array(
		"hosp",
		"nur",
		"coll",
		"surg",
		"crit",
		"med",
		"med",
		"eng",
		"w",
		"",
		"",
		"",
		"ess",
		"rehab",
		"hyprten",
		"inf",
		"ref",
		"src",
		"comp",
		"comp",
		"alt",
		"diag",
		"lab",
		"jnl",
		"psych",
		"ped",
		"ob",
		"gyn",
		"gyn",
		"phys",
		"neph",
		"cardio",
		"cardio",
		"circ",
		"mgmt",
		"man",
		"comp",
		"univ",
		"lipp",
		"doc",
		"edu",
		"assn",
		"ext",
		"prac",
		"prn",
		"iv",
		"curr_op",
		"_"
	);
	/*
	for ($i=0; $i<sizeof($find); $i++) {
		echo $find[$i]."-".$replace[$i]."<br />";
	}
	*/
	if (strstr($out_string,"_")) {
		$out_string = str_replace($find,$replace,$out_string);
	}
	//echo strlen($out_string)." -- ";
	return $out_string;
}

function get_unique($conn, $abbrev, $vendor_id) 
{
	$sql = "SELECT resource_id FROM site_vendor_resources WHERE resource_id = '" . $abbrev . "' AND NOT vendor_id = '" . $vendor_id . "';";
	$results = mysql_query($sql,$conn);
	
	if ($row = mysql_fetch_assoc($results))
	{
		$abbrev .= "_" . $vendor_id;
	}
	return $abbrev;
}

//*** END of import_Vendor_Resources.php