<?php 
 class CreateClient extends Migrations{ 
	function up(){ 
		$this->Create_Table(array('Table'=>'clients', 
								array('field'=>'name', 'type'=>'VARCHAR', 'null'=>'false')
							)); 
	}
	function down(){
		$this->Drop_Table('clients');
	}
}
?>