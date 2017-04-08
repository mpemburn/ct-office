<?php

$current_path = realpath(dirname(__FILE__));
$base_path = str_replace("application/config","",$current_path);
//*** Application paths
$config['base.path'] = $base_path;
$config['image.path'] = $base_path . "images/";
$config['image.url'] = base_url() . "images/";
$config['data.path'] = $base_path . "data/";
$config['data.url'] = base_url() . "data/";
$config['document.path'] = $base_path . "documents/";
$config['document.image.path'] = $base_path . "documents/images/";

$config['document.table'] = "cto_contracts";
$config['document.items.table'] = "cto_contract_items";
$config['document.services.table'] = "cto_contract_services";

$config['pdf.divisor'] = 6.333333;
$config['rc4.seed'] = "De gustibus non disputandum est";

//*** These controllers/methods are allowed without being logged in:
$config['allowed.pages'] = array(
	'login/logout',
);

$config['main.data.table'] = array(
	'CI_Contact_Us_List' => "tblContactUs",
	'CI_Pestimator_List' => "tblEstimates",
	'CI_Contract_List' => "cto_contracts"
);

$config['contact_us.columns'] = array(
	'timestamp' => "Date/Time",
	'message_name' => "Name",
	'message_email' => "Email",
	'message_body' => "Message"
);

$config['pestimator.columns'] = array(
	'estimate_datetime' => "Date/Time",
	'full_name' => "Name",
	'estimate_phone' => "Phone",
	'estimate_address1' => "Address",
	'estimate_city' => "City",
	'estimate_state' => "State",
	'estimate_zip' => "Zip",
	'estimate_email' => "Email"
);

$config['contract.columns'] = array(
	'time_stamp' => "Date",
	'contract_type_abbrev' => "Type",
	'residence_customer_name' => "Name",
	'residence_street_address' => "Address",
	'residence_city' => "City",
	'residence_state' => "State",
	'residence_zip' => "Zip",
	'residence_phone' => "Phone",
	'billing_customer_name' => "Bill To"
);

$config['role.columns'] = array(
	'first_name' => "First Name",
	'last_name' => "Last Name",
	'email' => "Email",
	'role' => "Role"
);


$config['prefix'] = "ct.office";
$config['application_name']	= "CT Office";
$config['application_version']	= "1.0";

$config['ct.office.nav.links'] = array(
		'Sales' => base_url() . 'sales',
		'Office' => base_url() . 'office',
		'Contracts' => base_url() . 'contract_list',
		'Roles' => base_url() . 'contract_roles',
		'Messages' => base_url() . 'contact_us_list',
		'Pestimator' => base_url() . 'pestimator_list',
		'Logout' => base_url() . 'login/logout'
);

$config['ct.office.contract.links'] = array(
		'Pest Control Agreement' => base_url() . 'app_form/pest_contract',
		'Termite Re-Treatment Guarantee' => base_url() . 'app_form/termite_contract',
		'Construction Division Proposal' => base_url() . 'app_form/construction_contract'
);

$config['ct.office.loading.image'] = base_url() . 'images/big-loader.gif';
$config['ct.office.no_really.image'] = base_url() . 'images/red_arrow.png';
$config['ct.office.required.image'] = base_url() . 'images/required.png';
$config['ct.office.plus.image'] = base_url() . 'images/plus.png';

//*** Pest Control Agreement config items
$config['ct.office.pest_contract.identifier'] = 'pga';
$config['ct.office.pest_contract.page.1'] = 'pest_contract_4-7-17_1';
$config['ct.office.pest_contract.page.2'] = 'pest_contract_2';
$config['ct.office.pest_contract.map'] = file_get_contents($config['document.path'] . $config['ct.office.pest_contract.page.1'] . '.html');
$config['ct.office.pest_contract.pixel.width'] = 1275;
$config['ct.office.pest_contract.pixel.height'] = 1651;
$config['ct.office.pest_contract.pdf.width'] = 1275;
$config['ct.office.pest_contract.pdf.height'] = 1651;
$config['ct.office.pga.signature.top'] = 228;

$config['ct.office.pest_contract.image'] = base_url() . 'documents/' . $config['ct.office.pest_contract.page.1'] . '.png';

$config['ct.office.pest_contract.default.number.of.services_1'] = '4';
$config['ct.office.pest_contract.default.number.of.services_2'] = '';

$config['ct.office.pest_contract.optional.fields'] = array(
	'use_billing_address',
	'account_number',
	'other_follow_up',
	'services_interval_2',
	'services_count_2',
	'services_start_date_2',
	'services_total_amount_2',
	'services_month_qtr_fee_2',
	'cc_number',
	'signature'
);

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
$config['ct.office.trg.signature.top'] = 223;

$config['ct.office.termite_contract.image'] = base_url() . 'documents/' . $config['ct.office.termite_contract.page.1'] . '.png';

$config['ct.office.termite_contract.optional.fields'] = array('use_billing_address','use_billing_coverup','account_number','optional_advance_payment','down_payment_amount','payment_balance_amount','cc_number','signature');
$config['ct.office.termite_contract.coverup.fields'] = array('use_billing_coverup' => 'true');

//*** Construction Division Proposal config items
$config['ct.office.construction_contract.identifier'] = 'cdp';
$config['ct.office.construction_contract.page.1'] = 'construction_contract_1';
$config['ct.office.construction_contract.map'] = file_get_contents($config['document.path'] . $config['ct.office.construction_contract.page.1'] . '.html');
$config['ct.office.construction_contract.pixel.width'] = 1275;
$config['ct.office.construction_contract.pixel.height'] = 1651;
$config['ct.office.construction_contract.pdf.width'] = 1275;
$config['ct.office.construction_contract.pdf.height'] = 1651;
$config['ct.office.cdp.signature.top'] = 221;

$config['ct.office.construction_contract.image'] = base_url() . 'documents/' . $config['ct.office.construction_contract.page.1'] . '.png';

$config['ct.office.construction_contract.optional.fields'] = array('use_billing_address','use_billing_coverup','account_number','optional_advance_payment','cc_number','signature');
$config['ct.office.construction_contract.coverup.fields'] = array('use_billing_coverup' => 'true');
$config['ct.office.construction_contract.extensible.key.field'] = "specifications";
$config['ct.office.construction_contract.extensible.array'] = array("specifications","spec_number","spec_amount");
$config['ct.office.construction_contract.auxiliary.table'] = "cto_specifications";

/* Deprecated: Now drawn from cto_contract_roles table.
 * See: libraries/Sales->get_dd_list()
 * See: libraries/Sales->get_dd_list()
 *
$config['ct.office.representatives'] = array(
	'Shiraz Asumah' => "",
	'David Gonzalez' => "isellnova1@gmail.com",
	'Shawn Michaels' => "sm22152@yahoo.com",
	'Patrick McKinney' => "patrick.r.mckinney@gmail.com",
	'Brett Seace' => "brett.seace@gmail.com",
	'Brett Nunn' => "bnunn@centurytermite.com",
);

$config['ct.office.technicians'] = array(
	'Andy Nguyen' => "",
	'Brian Simpson' => "",
	'Brian Stockley' => "",
	'Chuck Gaylor' => "",
	'David Kemp' => "",
	'Gary Irving Jr.' => "",
	'Gerry Avalos' => "",
	'J.R. Lambert' => "",
	'Jassen Russell' => "",
	'Joe Sison' => "",
	'Juan Mercado' => "",
	'Nick Reilly' => "",
	'Pierre Ashton' => "",
	'Rey Daguiso' => "",
	'Ron Humphrey' => "",
	'Scott Morgan' => "",
	'Termite Crew' => "",
	'Repair Crew' => "",
	'Insulation Crew' => "",
) + $config['ct.office.representatives'];

$config['ct.office.all_reps_and_techs'] = $config['ct.office.technicians'];
$config['ct.office.tech_name'] = implode(",",array_keys($config['ct.office.all_reps_and_techs']));
$config['ct.office.ct_representative'] = implode(",",array_keys($config['ct.office.all_reps_and_techs']));

*/

//*** Dropdown lists.  Names originally defined in ImageReady and processed via libraries/Sales.php AJAX calls (see relevant controllers and models)
$config['ct.office.billing_state'] = "DC,MD,VA,AK,AL,AR,AZ,CA,CO,CT,DE,FL,GA,HI,IA,ID,IL,IN,KS,KY,LA,MA,ME,MI,MN,MO,MS,MT,NC,NE,ND,NH,NJ,NM,NV,NY,OH,OK,OR,PA,PR,RI,SC,SD,TN,TX,UT,VA,VT,WA,WI,WV,WY";
$config['ct.office.residence_state'] = "DC,MD,VA";
$config['ct.office.follow_up_schedule'] = "Monthly,Quarterly,Yearly,Special,2 Week follow-up,Other:";
$config['ct.office.services_block.count'] = 2;
//$config['ct.office.services_interval_1'] = "Month,Quarter,6 Months,Year";
//$config['ct.office.services_interval_2'] = "Month,Quarter,6 Months,Year";
$config['ct.office.services_interval_1'] = "Weekly, Bi-Weekly, Monthly, Bi-Monthly, Quarterly, Semi-Annually";
$config['ct.office.services_interval_2'] = "Weekly, Bi-Weekly, Monthly, Bi-Monthly, Quarterly, Semi-Annually";

$config['ct.office.from.email'] = "contracts@centurytermite.com";
$config['ct.office.mail.host'] = "mail.centurytermite.com";
$config['ct.office.smtp.port'] = 587;
$config['ct.office.user.name'] = "support@centurytermite.com";
$config['ct.office.password'] = "rubr1ck";
//$config['ct.office.home.office.email'] = "mark@pemburn.com";
$config['ct.office.home.office.email'] = "rhonda_century@hotmail.com,melinda.centurytermite@gmail.com, kelly_century@live.com, tracy.centurytermite@gmail.com";

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

/**********************************************************************************
 * 
 * Global Includes 
 * 
 **********************************************************************************/
$config['include.css.global'] = array(
	'reset.css',
	'grid.css',
	'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.21/themes/cupertino/jquery-ui.css',
	'app/theme/custom.css',
	'app/template.css',
	'popover/popover.css'
);

//*** Included Javascript files (parsed with AppIncludes library)
$config['include.javascript.global'] = array(
	'app/base_class.js',
);

//*** Included Javascript variables (parsed with AppInclude library)
$config['include.jsvars.global'] = array(
);

/**********************************************************************************
 * 
 * Contact_Us_List Includes 
 * 
 **********************************************************************************/
 
 //*** Contact_Us_List CSS
$config['include.css.contact_us_list'] = array(
	'app/contact_us_list.css'
);

//*** Contact_Us_List Javascript
$config['include.javascript.contact_us_list'] = array(
	'app/list_manager.js',
	'app/contact_us_list_manager.js',
	'app/contact_us_list.js'
);

//*** Contact_Us_List JSVars
$config['include.jsvars.contact_us_list'] = array(
	'contact_us_list_ajax_url' => base_url() . 'contact_us_list/ajax_contact_us_list',
	'has_changes' => '{literal}false'
);

/**********************************************************************************
 * 
 * Contract_List Includes 
 * 
 **********************************************************************************/
 
 //*** Contract_List CSS
$config['include.css.contract_list'] = array(
	'app/contract_list.css'
);

//*** Contract_List Javascript
$config['include.javascript.contract_list'] = array(
	'app/list_manager.js',
	'app/contract_list_manager.js',
	'app/contract_list.js'
);

//*** Contract_List JSVars
$config['include.jsvars.contract_list'] = array(
	'contract_list_ajax_url' => base_url() . 'contract_list/ajax_contract_list',
	'has_changes' => '{literal}false'
);

 //*** Contract_Roles CSS
$config['include.css.contract_roles'] = array(
	'app/contract_roles.css'
);

//*** Contract_Roles Javascript
$config['include.javascript.contract_roles'] = array(
	'app/list_manager.js',
	'app/contract_roles_manager.js',
	'app/contract_roles.js'
);

//*** Contract_Roles JSVars
$config['include.jsvars.contract_roles'] = array(
	'contract_roles_ajax_url' => base_url() . 'contract_roles/ajax_contract_roles',
	'has_changes' => '{literal}false'
);

/**********************************************************************************
 * 
 * Pestimator_List Includes 
 * 
 **********************************************************************************/
 
 //*** Pestimator_List CSS
$config['include.css.pestimator_list'] = array(
	'app/pestimator_list.css'
);

//*** Pestimator_List Javascript
$config['include.javascript.pestimator_list'] = array(
	'app/list_manager.js',
	'app/pestimator_list_manager.js',
	'app/pestimator_list.js'
);

//*** Pestimator_List JSVars
$config['include.jsvars.pestimator_list'] = array(
	'pestimator_list_ajax_url' => base_url() . 'pestimator_list/ajax_pestimator_list',
	'has_changes' => '{literal}false'
);

/**********************************************************************************
 * 
 * Wdi_List Includes 
 * 
 **********************************************************************************/
 
 //*** Wdi_List CSS
$config['include.css.wdi_list'] = array(
	'app/wdi_list.css'
);

//*** Wdi_List Javascript
$config['include.javascript.wdi_list'] = array(
	'app/wdi_list_manager.js',
	'app/wdi_list.js'
);

//*** Wdi_List JSVars
$config['include.jsvars.wdi_list'] = array(
	'wdi_list_ajax_url' => base_url() . 'wdi_list/ajax_wdi_list',
	'has_changes' => '{literal}false'
);

//*** END OF FILE application/config/ct_office.php
