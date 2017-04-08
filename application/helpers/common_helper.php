<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('show_dialog'))
{
	function show_dialog($message, $heading = NULL, $redirect = NULL)
	{
		$_error =& load_class('Exceptions', 'core');
		echo $_error->show_dialog($message, $heading, NULL, $redirect);
		exit;
	}
}

/* End of file common_helper.php */
/* Location: ./application/helpers/common_helper.php */