<?php
require_once 'facebook-php-sdk/src/facebook.php';

/**
 * Gets the basic data from facebook if is there a facebook session active
 * @return array[uid,username,email,first_name,last_name,pic_big] | null
 */
function getBasicDataFromFB(){
	$facebook = new Facebook(array(
		'appId'  => FB_APP_ID,
		'secret' => FB_APP_SECRET,
		'cookie' => true
	));
	$userId = $facebook->getUser();
	$fbme = null;
	if(!empty($userId)):
		$fql = 'SELECT uid, username, email, name, first_name, last_name, pic_big FROM user WHERE uid = me()';
		$fbme1 = $facebook->api(array(
				'method' => 'fql.query',
				'query' => $fql,
		));
		$fbme = $fbme1[0];
	endif;
	return $fbme;
}
?>