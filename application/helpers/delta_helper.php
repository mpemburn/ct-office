<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Code Igniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		Rick Ellis
 * @copyright	Copyright (c) 2006, pMachine, Inc.
 * @license		http://www.codeignitor.com/user_guide/license.html 
 * @link		http://www.codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
 
// ------------------------------------------------------------------------

/**
 * Code Igniter Delta Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Mark Pemburn
 */

// ------------------------------------------------------------------------

if (function_exists('delta_html')) 
{
	return;
} 
else 
{

	function delta_html($old, $new) 
	{
		$ret = null;
		$diff = delta_diff(explode(' ', $old), explode(' ', $new));
		foreach($diff as $k) 
		{
			if (is_array($k))
				$ret .= (!empty($k['d'])?"<del>".implode(' ',$k['d'])."</del> ":'').(!empty($k['i'])?"<ins>".implode(' ',$k['i'])."</ins> ":'');
			else $ret .= $k . ' ';
		}
		return $ret;
	}
	
	
	function delta_diff($old, $new)
	{
		$maxlen = 0;
		foreach($old as $oindex => $ovalue) 
		{
			$nkeys = array_keys($new, $ovalue);
			foreach($nkeys as $nindex) {
				$matrix[$oindex][$nindex] = isset($matrix[$oindex - 1][$nindex - 1]) ? $matrix[$oindex - 1][$nindex - 1] + 1 : 1;
				if($matrix[$oindex][$nindex] > $maxlen) 
				{
					$maxlen = $matrix[$oindex][$nindex];
					$omax = $oindex + 1 - $maxlen;
					$nmax = $nindex + 1 - $maxlen;
				}
			}
		}
		if ($maxlen == 0)
		{
			return array(array('d'=>$old, 'i'=>$new));
		}
		
		return array_merge(delta_diff(array_slice($old, 0, $omax), array_slice($new, 0, $nmax)),array_slice($new, $nmax, $maxlen),delta_diff(array_slice($old, $omax + $maxlen), array_slice($new, $nmax + $maxlen)));
	}
	 


}

//*** END OF FILE delta_helper.php

