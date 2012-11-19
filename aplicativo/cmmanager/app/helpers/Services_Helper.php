<?php
function Curl($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,  $url);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	$response = curl_exec($ch);
	curl_close($ch);
	return $response;
}
function GetFbFeeds($next=null){
	$url = "https://graph.facebook.com/".$_SESSION['fbfanpage']."/feed?access_token=".$_SESSION['fbfanpagetoken'];
	if($next!=null) $url = $next;
	return json_decode(Curl($url));
}
function getfbpostcomments($feedId){
	$url = "https://graph.facebook.com/".$feedId."/comments";
	return json_decode(Curl($url));
}
function GetFbConversations($next){
	$url = !empty($next)?$next:"https://graph.facebook.com/".$_SESSION['fbfanpage']."/conversations?access_token=".$_SESSION['fbfanpagetoken'];
	return json_decode(Curl($url));
}
function GetFbPosts(){
	return json_decode(Curl("https://graph.facebook.com/".$_SESSION['fbfanpage']."/posts?access_token=".$_SESSION['fbfanpagetoken']));
}
/**
 * Splits the string from facebook with format (2012-10-17T23:05:21+0000) into day,month,year,hour,minute,second
 * @param string $str
 */
function cleanDateTime($str){
	$str = preg_replace('@\+[0-9]{4}@U', '', $str);
	list($date, $time) = explode('T',$str);
	$dateTime = array();
	list($dateTime['year'],$dateTime['month'],$dateTime['day']) = explode('-', $date);
	list($dateTime['hour'],$dateTime['minute'],$dateTime['second']) = explode(':', $time);
	return $dateTime;
}
/**
 * Transforms the datetime array to timestamp
 * @param array $array
 * @return timestamp
 */
function getStamp($array = array('day'=>null,'month'=>null,'year'=>null,'hour'=>null,'minute'=>null,'second'=>null)){
	return mktime($array['hour'],$array['minute'],$array['second'],$array['month'],$array['day'],$array['year']);
}
function isSavedFeed($feedId = ''){
	if(!class_exists('Feed')) include_once INST_PATH.'app/models/feed.php';
	$Feed = new Feed();
	return false or ($Feed->Find_by_original_id_feed($feedId)->count() > 0);
}
?>