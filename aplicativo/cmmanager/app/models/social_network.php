<?php
class SocialNetwork extends ActiveRecord {
	function __construct(){
		$this->has_many = array('feed');
	}
}
?>