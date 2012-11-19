<?php 
 class CreateCountry extends Migrations{ 
	function up(){ 
		$this->Create_Table(array('Table'=>'countries', 
								array('field'=>'name', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255')
							)); 
	}
	function down(){
		$this->Drop_Table('countries');
	}
}
?>