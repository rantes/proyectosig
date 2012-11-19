<?php
class Country extends ActiveRecord {
	function __construct(){
		$this->has_many = array('campaign','place');
		$this->before_save = array('codify');
	}

	function codify(){
		$this->name = htmlentities($this->name,ENT_QUOTES,'utf-8');
	}
}
?>