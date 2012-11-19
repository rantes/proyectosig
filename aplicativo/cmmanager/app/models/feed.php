<?php
class Feed extends ActiveRecord {
	function __construct(){
		$this->belongs_to = array('clasification','stat','message_kind','social_network','fanpage');
		$this->has_many = array('comment');
		$this->before_save = array('codify','checkstatus');
		$this->after_insert = array('tracknew');
	}
	/**
	 * Codifies the contents to html entities and utf8.
	 */
	function codify(){
		if(!empty($this->another_message))$this->another_message = htmlentities($this->another_message,ENT_QUOTES,'utf-8');
		if(!empty($this->pending))$this->pending = htmlentities($this->pending,ENT_QUOTES,'utf-8');
		if(!empty($this->observations))$this->observations = htmlentities($this->observations,ENT_QUOTES,'utf-8');
		if(!empty($this->content))$this->content = htmlentities($this->content,ENT_QUOTES,'utf-8');
		if(!empty($this->from_name))$this->from_name = htmlentities($this->from_name,ENT_QUOTES,'utf-8');
		if(!empty($this->page_name))$this->page_name = htmlentities($this->page_name,ENT_QUOTES,'utf-8');
	}
	/**
	 * Tracks the add new feed action, according the user (manager)
	 */
	function tracknew(){
// 		$track = new TrackFeedAction();
		$traker = $this->TrackFeedAction->Niu();
// 		$traker = $track->Niu();
		$traker->manager_id = $_SESSION['manager_id'];
		$traker->action = 'Creado';
		$traker->feed_id = $this->id;
		$traker->Save();
	}
	/**
	 * Checks if changed status on the feed to track it.
	 */
	function checkstatus(){
		$bef = new Feed();
		$ant = $bef->Find($this->id);

// 		$track = new TrackFeedAction();
		$traker = $this->TrackFeedAction->Niu();
		$traker->manager_id = $_SESSION['manager_id'];
		$traker->feed_id = $this->id;

		if ($bef->counter() > 0 and $bef->stat_id != $this->stat_id):
			switch($this->stat_id):
				case 5:
					$traker->action = 'Pendiente';
				break;
				case 4:
					$traker->action = 'Cerrado';
				break;
			endswitch;
		else:
			$traker->action = 'Modificado';
		endif;
		unset($this->TrackFeedAction);
		$traker->Save();
	}
}
?>