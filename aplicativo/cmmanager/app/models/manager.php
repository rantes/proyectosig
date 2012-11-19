<?php
class Manager extends ActiveRecord {
	function __construct(){
		$this->has_many = array('track_manager_action');
		$this->belongs_to = array('profile');
		$this->dependents = 'destroy';

		$this->before_save = array('setPassword');
		$this->validate = array('unique'=>array('email'));
	}
	function setPassword(){
		$bef = new Manager();
		$ant = $bef->Find($this->id);
		if ($bef->password != $this->password) $this->password = md5($this->password);
	}
}
?>