/**********************************************************************************
 * 
 * {ClassName} Includes 
 * 
 **********************************************************************************/
 
 //*** {ClassName} CSS
$config['include.css.{ClassNameToLower}'] = array(
	'app/{ClassNameToLower}.css'
);

//*** {ClassName} Javascript
$config['include.javascript.{ClassNameToLower}'] = array(
	'app/{ClassNameToLower}_manager.js',
	'app/{ClassNameToLower}.js'
);

//*** {ClassName} JSVars
$config['include.jsvars.{ClassNameToLower}'] = array(
	'{ClassNameToLower}_ajax_url' => base_url() . '{ClassNameToLower}/ajax_{ClassNameToLower}',
	'has_changes' => '{literal}false'
);

