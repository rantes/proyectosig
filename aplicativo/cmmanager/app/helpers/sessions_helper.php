<?php
function Require_User_Login(){
	if(empty($_SESSION['user']) or !is_array($_SESSION['owner'])):
		$_SESSION['backlink'] = INST_URI._CONTROLLER.'/'._ACTION;
		header("Location: ".INST_URI);
		exit;
	else:
		return true;
	endif;
}
?>