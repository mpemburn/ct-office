<?php

if ($_SERVER["HTTP_HOST"] == "localhost" || $_SERVER["HTTP_HOST"] == "mark-macbook") {		
	define('DB_HOST', 'localhost'); // database host		
	define('DB_USER', 'root'); // username		
	define('DB_PASS', 'root'); // password		
	define('DB_NAME', 'bugman_ct_office'); // database name
	define('ENV', 'Dev'); // environment
} else {		
	define('DB_HOST', 'localhost'); // database host		
	define('DB_USER', 'pembur5'); // username		
	define('DB_PASS', 'a110u3773'); // password		
	define('DB_NAME', 'pembur5_hslanj_manager'); // database name
	define('ENV', 'Prod'); // environment
}
/*
define('DB_HOST', 'localhost'); // database host		
define('DB_USER', 'root'); // username		
define('DB_PASS', 'root'); // password		
define('DB_NAME', 'hslanj_manager'); // database name
*/
//*** End of constants.php