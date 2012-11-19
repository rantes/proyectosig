<?php
class Campaign extends ActiveRecord {
	function __construct(){
		$this->belongs_to = array('client','country');

		$this->before_save = array('codify');
	}
	/**
	 * Codifies the contents to html entities and utf8.
	 */
	function codify(){
		$this->name = htmlentities($this->name,ENT_QUOTES,'utf-8');
	}
}
?>