<?php
class DB_import {
	var $fields = array();
	var $rows = array();
	var $sizes = array();
	var $types = array();
	var $file_name;
	var $table_name;
	var $table_prefix;
	var $create_sql = null;
	var $inserts = array();
	
	public function __construct($file_name, $table_name, $table_prefix = NULL) 
	{
		$this->file_name = $file_name;
		$this->table_name = $table_name;
		$this->table_prefix = $table_prefix;

		$this->read();
		$this->create_table();
		$this->create_inserts();
	}
	
	public function get_create_table() {
		$this->create_sql = str_replace(array("\n","\t"),"",$this->create_sql);
		return $this->create_sql;
	}
	
	public function get_inserts() {
		return $this->inserts;
	}
	
	private function read() 
	{
		$i = 0;
		$is_int = false;
		$infile = file($this->file_name);
		
		foreach ($infile as $line) 
		{
			$line = str_replace("\n","",$line);
			$parseLine = explode("\t",$line);
			if ($i == 0) 
			{
				foreach ($parseLine as $field) 
				{
					$field = strtolower($field);
					$this->fields[] = $field;
					$this->sizes[$field] = 0;
					$this->types[$field] = "INT";
				}
			} 
			else 
			{
				$row = array();
				$j = 0;
				foreach ($parseLine as $value) 
				{
					if (isset($this->fields[$j])) 
					{
						$field = $this->fields[$j];
						$row[$field] = $this->enquote($value);
						$len = strlen($value);
						if ($len > 0 && !is_numeric($value))
						{
							$this->types[$field] = "VARCHAR";
						}
						if ($len > $this->sizes[$field]) 
						{
							$len = ($len == 0) ? 10 : $len;
							$this->sizes[$field] = intval(ceil($len/10) * 10);
						}
						if ($this->sizes[$field] >= 100) 
						{
							$this->types[$field] = "TEXT";
						}
					}
					$j++;
				}
				$this->rows[] = $row;
			}
			$i++;
		}
	}
	
	private function create_table()
	{
		$singular = $this->depluralize($this->table_name);
		
		$this->create_sql = "CREATE TABLE IF NOT EXISTS `" . $this->table_prefix . $this->table_name . "` (\n\t`" . $singular . "_id` int(10) unsigned NOT NULL AUTO_INCREMENT,\n";
		
		foreach ($this->fields as $field) {
			$size = ($this->sizes[$field] > 0) ?  $this->sizes[$field] : 10;
			$this->create_sql .= "\t`" . $field . "` ";
			switch ($this->types[$field]) 
			{
				case "INT" :
					$this->create_sql .= "INT(10),\n";
					break;
				case "VARCHAR" :
					$this->create_sql .= "VARCHAR(" . $size . "),\n";
					break;
				case "TEXT" :
					$this->create_sql .= "TEXT,\n";
					break;
			}
		}
		
		$this->create_sql .= "PRIMARY KEY (`" . $singular . "_id`)\n) ENGINE=INNODB  DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1;";
		
		$this->create_sql .= "\n";
	}

	private function create_inserts()
	{
		$insert_stub = "INSERT INTO " . $this->table_prefix . $this->table_name . " (" . implode(",",$this->fields) . ") VALUES (#VALUES#);";

		foreach ($this->rows as $row) {
			 $insert = str_replace("#VALUES#",implode(",",$row),$insert_stub);
			 $this->inserts[] = $insert;
		}
	}


	private function enquote($inString) 
	{
		$inString = str_replace("\"","",$inString);
		return "'" . str_replace("'","''",$inString) . "'";
	}
	
	private function depluralize($word)
	{
		$rules = array( 
			'ss' => false, 
			'os' => 'o', 
			'ies' => 'y', 
			'xes' => 'x', 
			'oes' => 'o', 
			'ies' => 'y', 
			'ves' => 'f', 
			's' => '');
		// Loop through all the rules and do the replacement. 
		foreach(array_keys($rules) as $key)
		{
			// If the end of the word doesn't match the key,
			// it's not a candidate for replacement. Move on
			// to the next plural ending. 
			if(substr($word, (strlen($key) * -1)) != $key) 
			{
				continue;
			}
			// If the value of the key is false, stop looping
			// and return the original version of the word. 
			if($key === false)
			{ 
				return $word;
			}
			// We've made it this far, so we can do the
			// replacement. 
			return substr($word, 0, strlen($word) - strlen($key)) . $rules[$key]; 
		}
		return $word;
	}

}
//*** End of DB_import.php