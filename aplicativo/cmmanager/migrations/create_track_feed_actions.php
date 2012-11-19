<?php
 class CreateTrackFeedAction extends Migrations{
	function up(){
		$this->Create_Table(array('Table'=>'track_feed_actions',
								array('field'=>'manager_id', 'type'=>'INT', 'null'=>'false'),
								array('field'=>'action', 'type'=>'VARCHAR', 'null'=>'false', 'limit'=>'255'),
								array('field'=>'feed_id', 'type'=>'INT', 'null'=>'false')
							));
	}
	function down(){
		$this->Drop_Table('track_feed_actions');
	}
}
?>