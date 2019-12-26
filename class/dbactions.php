<?php

class Database{
	
	public $result;
	
	public function __construct(){ }
	
	public function insert($query){
		$this->result = mysql_query($query) or die(mysql_error());
	}
	
	public function select($query){
		return $this->result = mysql_query($query);
	}
	
	public function update($query){
		$this->result = mysql_query($query) or die(mysql_error());
	}
	
	public function delete($query){
		mysql_query($query);
	}
	
}

?>