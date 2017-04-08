<?php

$current_path = realpath(dirname(__FILE__));
$base_path = str_replace("application/config","",$current_path);
//*** Application paths
$config['base.path'] = $base_path;
$config['image.path'] = $base_path . "images/";
$config['data.path'] = $base_path . "data/";
$config['document.path'] = $base_path . "documents/";
$config['document.image.path'] = $base_path . "documents/images/";

$config['document.table'] = "cto_contracts";
$config['document.items.table'] = "cto_contract_items";

$config['pdf.divisor'] = 6.333333;
$config['rc4.seed'] = "De gustibus non disputandum est";

$config['prefix'] = "ct.office";
$config['application_name']	= "CT Office";
$config['application_version']	= "1.0 Alpha";

$config['ct.office.nav.links'] = array(
		'sales_module' => base_url() . 'sales',
		'office_module' => base_url() . 'office',
		'logout' => base_url() . 'login/logout'
);

$config['ct.office.contract.links'] = array(
		'Pest Control Agreement' => base_url() . 'app_form/pest_contract',
		'Termite Re-Treatment Guarantee' => base_url() . 'app_form/termite_contract'
);

//*** Pest Control Agreement config items
$config['ct.office.pest_contract.identifier'] = 'pga';
$config['ct.office.pest_contract.page.1'] = 'pest_contract_1';
$config['ct.office.pest_contract.page.2'] = 'pest_contract_2';
$config['ct.office.pest_contract.map'] = file_get_contents($config['document.path'] . $config['ct.office.pest_contract.page.1'] . '.html');
$config['ct.office.pest_contract.pixel.width'] = 1275;
$config['ct.office.pest_contract.pixel.height'] = 1651;
$config['ct.office.pest_contract.pdf.width'] = 1275;
$config['ct.office.pest_contract.pdf.height'] = 1651;

$config['ct.office.pest_contract.image'] = base_url() . 'documents/' . $config['ct.office.pest_contract.page.1'] . '.png';
$config['ct.office.loading.image'] = base_url() . 'images/big-loader.gif';
$config['ct.office.no_really.image'] = base_url() . 'images/red_arrow.png';
$config['ct.office.required.image'] = base_url() . 'images/required.png';

$config['ct.office.pest_contract.optional.fields'] = array('use_billing_address','account_number','other_follow_up','special_instructions','cc_number','signature');
$config['ct.office.pest_contract.coverup.fields'] = array('use_billing_coverup' => 'true');

//*** Termite Agreement config items
$config['ct.office.termite_contract.identifier'] = 'trg';
$config['ct.office.termite_contract.page.1'] = 'termite_contract_1';
$config['ct.office.termite_contract.page.2'] = 'termite_contract_2';
$config['ct.office.termite_contract.map'] = file_get_contents($config['document.path'] . $config['ct.office.termite_contract.page.1'] . '.html');
$config['ct.office.termite_contract.pixel.width'] = 1275;
$config['ct.office.termite_contract.pixel.height'] = 1651;
$config['ct.office.termite_contract.pdf.width'] = 1275;
$config['ct.office.termite_contract.pdf.height'] = 1651;

$config['ct.office.termite_contract.image'] = base_url() . 'documents/' . $config['ct.office.termite_contract.page.1'] . '.png';
$config['ct.office.loading.image'] = base_url() . 'images/big-loader.gif';
$config['ct.office.no_really.image'] = base_url() . 'images/red_arrow.png';
$config['ct.office.required.image'] = base_url() . 'images/required.png';

$config['ct.office.termite_contract.optional.fields'] = array('use_billing_address','use_billing_coverup','account_number','optional_advance_payment','down_payment_amount','payment_balance','cc_number','signature');
$config['ct.office.termite_contract.coverup.fields'] = array('use_billing_coverup' => 'true');

$config['ct.office.technicians'] = array(
	'Zac Bestwick' => "",
	'Dun Boseman' => "",
	'Kelvin Lincoln' => "",
	'Randy Milbourne' => "",
	'Mundur Nyamaa' => "",
	'Brett Seace' => "",
	'Henry Suarez' => "",
	'William Washington' => ""
);

$config['ct.office.representatives'] = array(
	'Stephen Dimouro' => "spdimouro@gmail.com",
	'David Gonzalez' => "isellnova1@gmail.com",
	'Jairo Hernandez' => "jairoprc@yahoo.com",
	'R. Stephan Kinard' => "r.kinard@aol.com",
	'Patrick McKinney' => "patrick.r.mckinney@gmail.com",
	'Shawn Michaels' => "sm22152@yahoo.com",
	'Roger Washington' => "wrwash66@gmail.com"
);

//*** Dropdown lists.  Names originally defined in ImageReady and processed via libraries/Sales.php AJAX calls (see relevant controllers and models)
$config['ct.office.tech_name'] = implode(",",array_keys($config['ct.office.technicians']));
$config['ct.office.ct_representative'] = implode(",",array_keys($config['ct.office.representatives']));
$config['ct.office.billing_state'] = "MD,VA,AK,AL,AR,AZ,CA,CO,CT,DE,FL,GA,HI,IA,ID,IL,IN,KS,KY,LA,MA,ME,MI,MN,MO,MS,MT,NC,NE,ND,NH,NJ,NM,NV,NY,OH,OK,OR,PA,PR,RI,SC,SD,TN,TX,UT,VA,VT,WA,WI,WV,WY";
$config['ct.office.residence_state'] = "MD,VA";
$config['ct.office.follow_up_schedule'] = "Monthly,Quarterly,Yearly,Special,2 Week follow-up,Other:";
$config['ct.office.services_interval'] = "Month,Quarter,6 Months,Year";

$config['ct.office.from.email'] = "support@centurytermite.com";
$config['ct.office.home.office.email'] = "office@centurytermite.com,mark@pemburn.com,rhonda_century@hotmail.com,melinda4century@gmail.com";

$config['ct.office.to.customer.contract.email.subject'] = "Your Contract with Century Termite and Pest";

$config['ct.office.to.customer.contract.email.body'] =  "Dear {billing_customer_name},\r\n<br /><br />"
											."Here is a copy of your signed contract with Century Termite and Pest.  Thank You! \r\n\r\n<br /><br />"
											."Regards,\r\n<br />"
											."The Century Termite and Pest Team\r\n";

$config['ct.office.to.office.contract.email.subject'] = "Contract with {residence_customer_name}";											

$config['ct.office.to.office.contract.email.body'] =  "Hello,\r\n<br /><br />"
											."Attached is a copy of the signed contract from:\r\n\r\n<br /><br />"
											."{residence_customer_name}\r\n<br />"
											."{residence_street_address}\r\n<br />"
											."{residence_city} {residence_state}, {residence_zip}\r\n<br />"
											."\r\n<br />"
											."\r\n<br />"
											."Enter the following code into the Administrative system: {cc_encrypted} \r\n";

//*** END OF FILE application/config/ct_office.php