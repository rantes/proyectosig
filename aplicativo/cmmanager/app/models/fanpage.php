<?php
class Fanpage extends ActiveRecord {
	function __construct(){
		$this->has_many = array('feed');
		$this->belongs_to = array('social_network','client');

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