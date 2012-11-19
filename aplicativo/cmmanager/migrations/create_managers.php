<?php
 class CreateManager extends Migrations{
	function up(){
		$this->Create_Table(array('Table'=>'managers',
								array('field'=>'name', 'type'=>'TEXT', 'null'=>'false'),
								array('field'=>'email', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'password', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'fb_profile', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'tw_profile', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'gplus_profile', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'is_active', 'type'=>'INT', 'null'=>'false', 'default'=>'1'),
								array('field'=>'profile_id', 'type'=>'INT', 'null'=>'false')
							));
	}
	function down(){
		$this->Drop_Table('managers');
	}
}
?>