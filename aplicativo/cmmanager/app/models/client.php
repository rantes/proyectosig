<?php
class Client extends ActiveRecord {
	function __construct(){
		$this->has_many = array('campaign','place','message_kind','fanpage');
		$this->before_save = array('codify');
	}

	function codify(){
		$this->name = htmlentities($this->name,ENT_QUOTES,'utf-8');
	}
}
?>