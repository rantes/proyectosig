<?php
class Comment extends ActiveRecord {
	function __construct(){
		$this->belongs_to = array('feed');
		$this->before_save = array('codify');
		$this->after_insert = array('tracknew');
		$this->after_save = array('checkstatus');
	}
	/**
	 * Codifies the contents to html entities and utf8.
	 */
	function codify(){
		$this->another_message = htmlentities($this->another_message,ENT_QUOTES,'utf-8');
		$this->pending = htmlentities($this->pending,ENT_QUOTES,'utf-8');
		$this->content = htmlentities($this->content,ENT_QUOTES,'utf-8');
		$this->from_name = htmlentities($this->from_name,ENT_QUOTES,'utf-8');
		$this->page_name = htmlentities($this->page_name,ENT_QUOTES,'utf-8');
	}
	/**
	 * Tracks the add new feed action, according the user (manager)
	 */
	function tracknew(){
		$traker = $this->TrackManagerAction->Niu();
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

		$track = new TrackFeedAction();
		$traker = $track->Niu();
		$traker->manager_id = $_SESSION['manager_id'];
		$traker->feed_id = $this->id;

		if ($bef->stat != $this->stat):
		switch($this->stat):
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

			$traker->Save();
	}
}
?>