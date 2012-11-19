<?php 
 class CreateProfile extends Migrations{ 
	function up(){ 
		$this->Create_Table(array('Table'=>'profiles', 
								array('field'=>'name', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255')
							)); 
	}
	function down(){
		$this->Drop_Table('profiles');
	}
}
?>