<?php
error_reporting(E_ALL);
require_once("./classes/constants.php");
require_once("./classes/DB_connect.php");

$db = new DB_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
$conn = $db->get();

$prefixes = array('sr','dr','doctor','miss','misses','mr','mister','mrs','ms','judge','sir','madam','madame','AB','2ndLt','Amn','1stLt','A1C','Capt','SrA','Maj','SSgt','LtCol','TSgt','Col','BrigGen','1stSgt','MajGen','SMSgt','LtGen','1stSgt','Gen','CMSgt','1stSgt','CCMSgt','CMSAF','PVT','2LT','PV2','1LT','PFC','CPT','SPC','MAJ','CPL','LTC','SGT','COL','SSG','BG','SFC','MG','MSG','LTG','1SGT','GEN','SGM','CSM','SMA','WO1','WO2','WO3','WO4','WO5','ENS','SA','LTJG','SN','LT','PO3','LCDR','PO2','CDR','PO1','CAPT','CPO','RADM(LH)','SCPO','RADM(UH)','MCPO','VADM','MCPOC','ADM','MPCO-CG','CWO-2','CWO-3','CWO-4','Pvt','2ndLt','PFC','1stLt','LCpl','Capt','Cpl','Maj','Sgt','LtCol','SSgt','Col','GySgt','BGen','MSgt','MajGen','1stSgt','LtGen','MGySgt','Gen','SgtMaj','SgtMajMC','WO-1','CWO-2','CWO-3','CWO-4','CWO-5','ENS','SA','LTJG','SN','LT','PO3','LCDR','PO2','CDR','PO1','CAPT','CPO','RDML','SCPO','RADM','MCPO','VADM','MCPON','ADM','FADM','WO1','CWO2','CWO3','CWO4','CWO5');
$suffixes = array('Esq','Esquire','Jr','Sr','MD','PhD','I','II','III','IV','V','Clu','Chfc','Cfp');

$i = 0;
foreach ($prefixes as $prefix)
{
	$use = "1";
	if ($prefix == strtolower($prefix))
	{
		$prefix = ucwords($prefix);
	}
	if ($i > 12)
	{
		$use = "0";
	}
	$insert = "INSERT INTO site_prefixes (prefix,use_prefix) VALUES ('$prefix',$use);";
	echo $insert . "<br />";
	$i++;
}

$i = 0;
foreach ($suffixes as $suffix)
{
	$insert = "INSERT INTO site_suffixes (suffix,use_suffix) VALUES ('$suffix',$use);";
	echo $insert . "<br />";
	$i++;
}

