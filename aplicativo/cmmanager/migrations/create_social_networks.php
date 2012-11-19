<?php
 class CreateSocialNetwork extends Migrations{
	function up(){
		$this->Create_Table(array('Table'=>'social_networks',
								array('field'=>'name', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'kind', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'public_key', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'private_key', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'app_url', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'logo', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255')
							));
	}
	function down(){
		$this->Drop_Table('social_networks');
	}
}
?>