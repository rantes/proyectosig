<?php
 class CreateComment extends Migrations{
	function up(){
		$this->Create_Table(array('Table'=>'comments',
								array('field'=>'feed_id', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'date_published', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'from_name', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'from_id', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'content', 'type'=>'TEXT', 'null'=>'false')
							));
	}
	function down(){
		$this->Drop_Table('comments');
	}
}
?>