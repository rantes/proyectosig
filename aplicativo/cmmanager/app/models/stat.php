<?php 
class Stat extends ActiveRecord {
	function __construct(){
		$this->has_many = array('feed');
	} 
} 
?>