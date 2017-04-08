<?php
class DB_connect {
	var $host;
	var $user;
	var $password;
	var $db_name;
	var $conn;
	
	function __construct($host, $user, $password, $db_name) 
	{
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->db_name = $db_name;
	}

	function get() 
	{
		//*** Connecting, selecting database
		$this->conn = mysql_connect($this->host,$this->user,$this->password)
		    or die('Could not connect: ' . mysql_error());
		
		mysql_select_db($this->db_name) or die('Could not get connection object: ' . mysql_error());
		return $this->conn;
	}
}

//*** End of DB_connect.php