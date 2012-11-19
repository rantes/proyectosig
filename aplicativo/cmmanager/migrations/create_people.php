<?php 
 class CreatePerson extends Migrations{ 
	function up(){ 
		$this->Create_Table(array('Table'=>'people', 
								array('field'=>'name', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'), 
								array('field'=>'lastname', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'), 
								array('field'=>'email', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255')
							)); 
	}
	function down(){
		$this->Drop_Table('people');
	}
}
?>