<?php
 class CreateFeed extends Migrations{
	function up(){
		$this->Create_Table(array('Table'=>'feeds',
								array('field'=>'date_published', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'stat_id', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'feed_kind', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'original_id_parent', 'type'=>'VARCHAR', 'limit'=>'255', 'null'=>'false'),
								array('field'=>'pending', 'type'=>'TEXT', 'null'=>'false'),
								array('field'=>'observations', 'type'=>'TEXT', 'null'=>'true'),
								array('field'=>'response_time', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'solution_time', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'client_id', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'country_id', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'social_network_id', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'fanpage_id', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'message_kind_id', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'message_level', 'type'=>'VARCHAR', 'limit'=>'255', 'null'=>'false'),
								array('field'=>'another_message', 'type'=>'TEXT', 'null'=>'false'),
								array('field'=>'from_id', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'from_name', 'type'=>'TEXT', 'null'=>'false'),
								array('field'=>'original_id_feed', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'campaign_id', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'content', 'type'=>'TEXT', 'null'=>'false'),
								array('field'=>'clasification_id', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'place_id', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'qualify', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'page_name', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'message_stat_id', 'type'=>'INT', 'null'=>'false')
							));
	}
	function down(){
		$this->Drop_Table('feeds');
	}
}
?>