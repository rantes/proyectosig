<?php 
 class CreateCampaign extends Migrations{ 
	function up(){ 
		$this->Create_Table(array('Table'=>'campaigns', 
								array('field'=>'name', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'), 
								array('field'=>'country_id', 'type'=>'INT', 'null'=>'false'), 
								array('field'=>'client_id', 'type'=>'INT', 'null'=>'false')
							)); 
	}
	function down(){
		$this->Drop_Table('campaigns');
	}
}
?>