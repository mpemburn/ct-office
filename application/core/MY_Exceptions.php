<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY_Exceptions Class
 *
 * Extends Exceptions core
 *
*/
class MY_Exceptions extends CI_Exceptions {
	
	function __construct()
	{
		parent::__construct();
	}
	
	function show_dialog($message, $heading = NULL, $template = NULL, $redirect = NULL)
	{
		$heading = (is_null($heading)) ? 'Error' : $heading;
		
		$template = (is_null($template)) ? 'error_dialog' : $template;
				
		$message = '<p>'.implode('</p><p>', ( ! is_array($message)) ? array($message) : $message).'</p>';
		
		$redirect_url = (is_null($redirect)) ? NULL : base_url() . $redirect;		

		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}
		ob_start();
		include(APPPATH.'errors/'.$template.'.php');
		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}

    
}
//*** END OF FILE MY_Exceptions.php
//*** Location: /application/core/MY_Exceptions.php