<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once ('PHPMailer/class.phpmailer.php');

class CI_Mailer extends PHPMailer {
	
	public function __construct() 
	{
		parent::__construct();
	}
			
} //*** End of class CI_Mailer
//*** END of FILE

