<?php 
 class CreateStat extends Migrations{ 
	function up(){ 
		$this->Create_Table(array('Table'=>'stats', 
								array('field'=>'stat', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'default', 'type'=>'INT', 'null'=>'false', 'default'=>'0')
							)); 
	}
	function down(){
		$this->Drop_Table('stats');
	}
}
?>