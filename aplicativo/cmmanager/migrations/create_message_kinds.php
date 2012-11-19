<?php
 class CreateMessageKind extends Migrations{
	function up(){
		$this->Create_Table(array('Table'=>'message_kinds',
								array('field'=>'name', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'client_id', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'has_more', 'type'=>'INT', 'null'=>'false', 'default'=>'0')
							));
	}
	function down(){
		$this->Drop_Table('message_kinds');
	}
}
?>