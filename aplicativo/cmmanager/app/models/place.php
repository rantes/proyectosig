<?php
class Place extends ActiveRecord {
	function __construct(){
		$this->has_many = array('feed');
		$this->belongs_to = array('country','client');
		$this->before_save = array('codify');
	}
	/**
	 * Codifies the contents to html entities and utf8.
	 */
	function codify(){
		$this->name = htmlentities($this->name,ENT_QUOTES,'utf-8');
		$this->phone = htmlentities($this->phone,ENT_QUOTES,'utf-8');
		$this->address = htmlentities($this->address,ENT_QUOTES,'utf-8');
		$this->schedule = htmlentities($this->schedule,ENT_QUOTES,'utf-8');
		$this->manager = htmlentities($this->manager,ENT_QUOTES,'utf-8');
	}
}
?>