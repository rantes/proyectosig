<?php
class Profile extends ActiveRecord {
	function __construct(){
		$this->has_many = array('manager');
	}
}
?>