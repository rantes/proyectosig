<?php
 class CreateFanpage extends Migrations{
	function up(){
		$this->Create_Table(array('Table'=>'fanpages',
								array('field'=>'name', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'300'),
								array('field'=>'original_id', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'social_network_id', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'client_id', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'token', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'300'),
								array('field'=>'url', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'300')
							));
	}
	function down(){
		$this->Drop_Table('fanpages');
	}
}
?>