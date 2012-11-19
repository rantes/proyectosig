<?php
 class CreatePlace extends Migrations{
	function up(){
		$this->Create_Table(array('Table'=>'places',
								array('field'=>'name', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'client_id', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'country_id', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'phone', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'address', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'email', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'schedule', 'type'=>'TEXT', 'null'=>'false'),
								array('field'=>'manager', 'type'=>'TEXT', 'null'=>'false')
							));
	}
	function down(){
		$this->Drop_Table('places');
	}
}
?>