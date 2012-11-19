<?php 
 class CreateClasification extends Migrations{ 
	function up(){ 
		$this->Create_Table(array('Table'=>'clasifications', 
								array('field'=>'name', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'), 
								array('field'=>'icon', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255')
							)); 
	}
	function down(){
		$this->Drop_Table('clasifications');
	}
}
?>