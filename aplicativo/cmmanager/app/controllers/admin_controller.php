<?php
require 'facebook-php-sdk/src/facebook.php';
class AdminController extends Page{
	public $layout = 'admin_layout';
	public $helper = array('Services');
	public $noTemplate = array('setDefaultStat','toggleHasMore');
	/**
	 * Keeps the json decodified from facebook
	 * @var object
	 */
	public $activefbpage = null;
	/**
	 * Facebook api object
	 * @var facebook object
	 */
	public $facebookApi = null;
	/**
	 * Token from facebook
	 * @var string
	 */
	public $fbToken = '';
	/**
	 * Stores the facebook fan pages
	 * @var array
	 */
	public $fbpages = array();
	/**
	 * Current social network id
	 * @var integer
	 */
	public $social_network = 0;
	function __construct(){
		$this->mainSocialNetworks = $this->SocialNetwork->Find();
		if(empty($_SESSION['fbuserId']) and !empty($_SESSION['fbdata'])):
			Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
			Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;
			$facebookApi = new Facebook(array(
					'appId'  => $_SESSION['fbdata'][0]['public_key'],
					'secret' => $_SESSION['fbdata'][0]['private_key'],
					'cookie' => true
			));
			$_SESSION['fbuserId'] = $facebookApi->getUser();
		endif;
		//default stat
		$this->defaulStat = $this->Stat->Find_by_default('1')->id;
		//Facebook fan pages
		if(!empty($_SESSION['fbuserId'])):
			Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYPEER] = false;
			Facebook::$CURL_OPTS[CURLOPT_SSL_VERIFYHOST] = 2;
			$this->facebookApi = new Facebook(array(
					'appId'  => $_SESSION['fbdata'][0]['public_key'],
					'secret' => $_SESSION['fbdata'][0]['private_key'],
					'cookie' => true
			));
			$this->fbToken=$this->facebookApi->getAccessToken();
			$this->fbpages = $this->facebookApi->api('/me/accounts');
// 			foreach($this->fbpages['data'] as $page):
// 				$this->
// 			endforeach;

			if(empty($_SESSION['fbfanpage']) or empty($_SESSION['fbfanpagetoken'])):
				$_SESSION['fbfanpage'] = $this->fbpages['data'][0]['id'];
				$_SESSION['fbfanpagetoken'] = $this->fbpages['data'][0]['access_token'];
				$this->full_current_page = $this->fbpages['data'][0];
				if(!empty($this->params['id']))$_SESSION['fanpageId'] = $this->Fanpage->Find_by_original_id($this->params['id'])->id;
			endif;
			if(empty($_SESSION['fanpageId']) or empty($_SESSION['clientId']) or empty($this->clientId) or empty($this->fanpageId)):
				$fp = $this->Fanpage->Find_by_original_id($_SESSION['fbfanpage']);
				$_SESSION['fanpageId'] = $fp->id;
				$_SESSION['clientId'] = $fp->client_id;
// 				$this->fanpageId = $fp->id;
			endif;
			$this->clientId = $_SESSION['clientId'];
			$this->fanpageId = $_SESSION['fanpageId'];
			$this->social_network = $_SESSION['network_id'];
			$this->id_current_page = $_SESSION['fbfanpage'];
			$this->access_token_current_page = $_SESSION['fbfanpagetoken'];
			$this->full_current_page = $this->facebookApi->api('/'.$this->id_current_page);

			$this->fburl_posts = "https://graph.facebook.com/".$this->id_current_page."/posts?access_token=".$this->access_token_current_page;
			$this->fburl_feeds = "https://graph.facebook.com/".$this->id_current_page."/feed?access_token=".$this->access_token_current_page;
			$this->fburl_inbok = "https://graph.facebook.com/".$this->id_current_page."/conversations?access_token=".$this->access_token_current_page;

		endif;

		////////////////////
		// Manager session handler
// 		echo $_SESSION['fbuserId'];
		if(empty($_SESSION['manager_id'])):
			if(!empty($_SESSION['fbuserId'])):
				$_SESSION['manager_id'] = $this->Manager->Find_by_fb_profile($_SESSION['fbuserId'])->id;
			elseif($this->__action != 'login'):
				header('Location: '.INST_URI.'admin/login');
				exit;
			endif;
		endif;

		////////////////////

	}
	function before_filter(){
		if(!empty($_SESSION['fbuserId'])):
			// pagina activa:
			$this->activefbpage = json_decode(Curl("https://graph.facebook.com/".$this->id_current_page."?access_token=".$this->access_token_current_page));
		endif;
		// current user to display its data
		if(!empty($_SESSION['manager_id'])) $this->useractive = $this->Manager->Find($_SESSION['manager_id']);
	}
	function indexAction(){
		if(!empty($_POST['setSocialNetwork'])):
			$response = array();
			if(!empty($_POST['network'])):
				switch(strtolower($_POST['network'])):
					case 'facebook':
						$_SESSION['network_id'] = (integer)$_POST['network_id'];
						$_SESSION['fbdata'] = $this->SocialNetwork->Find($_POST['network_id'])->getArray();
						$facebook = new Facebook(array(
								'appId'  => $_SESSION['fbdata'][0]['public_key'],
								'secret' => $_SESSION['fbdata'][0]['private_key'],
								'cookie' => true
						));
						$_SESSION['fbuserId'] = $facebook->getUser();
						if(empty($_SESSION['fbuserId'])):
							$response['success'] = false;
							$response['url'] = $facebook->getLoginUrl(array('scope' =>'email,user_birthday,status_update,publish_stream,user_hometown,user_interests,user_education_history,user_likes,user_location,read_mailbox,read_page_mailboxes,read_requests,manage_pages','registration_url'=>$_SESSION['fbdata'][0]['app_url']));
						else:
							$response['success'] = true;
						endif;
					break;
				endswitch;
			endif;
			$this->respondToAJAX(json_encode($response));
		endif;
		if(!empty($_POST['reloadFanPages'])):
			foreach($this->fbpages['data'] as $page):
				$fbfanpage = $this->Fanpage->Find_by_original_id($page['id']);
				if($fbfanpage->counter() < 1):
					$newpage = $this->Fanpage->Niu();
					$newpage->name = $page['name'];
					$newpage->original_id = $page['id'];
					$newpage->token = $page['access_token'];
					$newpage->url = "https://graph.facebook.com/".$newpage->original_id."/";
					$newpage->Save() or print $newpage->_error;
				endif;
			endforeach;
			$this->render = array('layout'=>false,'text'=>'up');
		endif;
	}
	function paramsAction(){
		if(!empty($_POST)):
			$pos = key($_POST);
			$model = Camelize($pos);
			$objCat = $this->{$model}->Niu($_POST[$pos]);
			$objCat->Save() or print($objCat->_error);
		endif;
		//social networks
		$this->network = $this->SocialNetwork->Niu();
		$this->networks = $this->SocialNetwork->Find();
		//stats
		$this->stat = $this->Stat->Niu();
		$this->stats = $this->Stat->Find();
		//countries
		$this->country = $this->Country->Niu();
		$this->countries = $this->Country->Find();
		//clients
		$this->client = $this->Client->Niu();
		$this->clients = $this->Client->Find();
		//clasifications
		$this->clasification = $this->Clasification->Niu();
		$this->clasifications = $this->Clasification->Find();
		//profiles
		$this->profile = $this->Profile->Niu();
		$this->profiles = $this->Profile->Find();
		//lugares (restaurante, etc)
		$this->place = $this->Place->Niu();
		$this->places = $this->Place->Find();
		//campaigns
		$this->campaign = $this->Campaign->Niu();
		$this->campaigns = $this->Campaign->Find();
		// message kinds
		$this->message_kind = $this->MessageKind->Niu();
		$this->message_kinds = $this->MessageKind->Find();
		// Fanpages
		$this->fanpage = $this->Fanpage->Niu();
		$this->fanpages = $this->Fanpage->Find();

		$this->title = 'Par&aacute;metros';
	}
	function setSocialNetworkAction(){

		$this->render = array('layout'=>false,'action'=>'index');
	}
	/**
	 * Sets the needed params
	 */
	function setparams(){
		$this->stats = $this->Stat->Find();
		//countries
		$this->countries = $this->Country->Find();
		//clients
		$this->clients = $this->Client->Find();
		//clasifications
		$this->clasifications = $this->Clasification->Find();
		//lugares (restaurante, etc)
		$this->places = $this->Place->Find();
		//campaigns
		$this->campaigns = $this->Campaign->Find();
		// message kinds
		$this->message_kinds = (!empty($this->feed->client_id))? $this->MessageKind->Find_by_client_id($this->feed->client_id):$this->MessageKind->Find();
		// messages levels
		$this->message_levels = array('Positivo'=>'Positivo','Negativo'=>'Negativo','Neutro'=>'Neutro');
	}
	function setFbFanPageAction(){
		if(!empty($this->params['id']) and !empty($this->params['token'])):
		$this->facebookApi = new Facebook(array(
				'appId'  => $_SESSION['fbdata'][0]['public_key'],
				'secret' => $_SESSION['fbdata'][0]['private_key'],
				'cookie' => true
		));
			$this->fbToken=$this->facebookApi->getAccessToken();
			$this->id_current_page = $this->params['id'];
			$this->access_token_current_page = $this->params['token'];
			$this->full_current_page = $this->facebookApi->api('/'.$this->params['id']);
			$fp = $this->Fanpage->Find_by_original_id($this->params['id']);
			$this->fanpageId = $fp->id;
			$this->clientId = $fp->client_id;

			$_SESSION['fanpageId'] = $this->fanpageId;
			$_SESSION['clientId'] = $this->clientId;
			$_SESSION['fbfanpage'] = $this->id_current_page;
			$_SESSION['fbfanpagetoken'] = $this->access_token_current_page;

			$this->fburl_posts = "https://graph.facebook.com/".$this->id_current_page."/posts?access_token=".$this->access_token_current_page;
			$this->fburl_feeds = "https://graph.facebook.com/".$this->id_current_page."/feed?access_token=".$this->access_token_current_page;
			$this->fburl_inbok = "https://graph.facebook.com/".$this->id_current_page."/conversations?access_token=".$this->access_token_current_page;
		endif;
		header('Location: '.INST_URI.'admin/viewFbFeeds/');
		exit;
	}
	function viewFbFeedsAction(){
		$next = null;
		$this->firstPage = true;
		if(!empty($_POST['next'])):
			$this->render = array('layout'=>false);
			$next = $_POST['next'];
		endif;
		$this->feeds = GetFbFeeds($next);
		if(!empty($_POST['next']) and empty($this->feeds->data)):
			$this->feeds = GetFbFeeds();
		endif;
		$this->clasifications = $this->Clasification->Find();
	}
	function viewFbMessagesAction(){
		$next = null;
		$this->firstPage = true;
		if(!empty($_POST['next'])):
			$this->render = array('layout'=>false);
			$next = $_POST['next'];
		endif;
		$this->feeds = GetFbConversations($next);
		if(empty($this->feeds->data)):
			$this->feeds = GetFbConversations();
		endif;
		$this->clasifications = $this->Clasification->Find();
	}
	function editFeedAction(){
		if(!empty($_POST['feed_id'])):

		endif;
	}
	function setDefaultStatAction(){
		$this->render = array('layout'=>false);
		if(!empty($_POST['id'])):
			$stat = $this->Stat->Find($_POST['id']);
			$stat->default = 1;
			$stat->Save();
		endif;
	}
	function saveFeedAction(){
		$this->render = array('layout'=>false);
		$resp = array('success'=>false,'reason'=>'No data.');
		if(!empty($_POST['feed'])):
			$this->feed = $this->Feed->Niu($_POST['feed']);
			if($this->feed->Save()):
				$resp['success']=true;
				$resp['reason']='';
				$this->setparams();
			else:
				$resp['reason']=(string)$this->feed->_error;
			endif;
			if(empty($_GET['edit'])):
				$this->respondToAJAX(json_encode($resp));
			endif;
		endif;

	}
	function contentsAction(){
		$this->title = 'Contenidos';
		//feeds
		$this->feeds = $this->Feed->Find_by_feed_kind('feed');
		$this->replys = $this->Feed->Find_by_feed_kind('reply');
		$this->messages = $this->Feed->Find_by_feed_kind('message');
	}
	function vieweditfeedAction(){
		if(!empty($_POST['id'])):
			$this->setparams();
			$this->feed = $this->Feed->Find($_POST['id']);
			$this->render = array('layout'=>false,'file'=>'admin/saveFeed.phtml');
		endif;
	}
	function managersAction(){
		$this->manager = $this->Manager->Niu();
		$this->activemanagers = $this->Manager->Find_by_is_active(1);
		$this->inactivemanagers = $this->Manager->Find_by_is_active(0);
		$this->profiles = $this->Profile->Find();
		$this->title = 'Managers';
	}
	function loginAction(){
		$this->render = array('layout'=>false);
		if(!empty($_POST['login'])):
			$user = $this->Manager->Find_by_email($_POST['login']['email']);
			if($user->count() > 0):
				if($user->password == md5($_POST['login']['password'])):
					$_SESSION['manager_id'] = $user->id;
					header('Location: '.INST_URI.'admin/');
					exit;
				else:
					$this->flash = 'Usuario o password incorrectos';
				endif;
			else:
				$this->flash = 'Usuario o password incorrectos';
			endif;
		endif;
	}
	function getParamEditAction(){
		if(!empty($_POST['param'])):
			$this->networks = $this->SocialNetwork->Find();
			//stats
			$this->stats = $this->Stat->Find();
			//countries
			$this->countries = $this->Country->Find();
			//clients
			$this->clients = $this->Client->Find();
			//clasifications
			$this->clasifications = $this->Clasification->Find();
			//profiles
			$this->profiles = $this->Profile->Find();
			//lugares (restaurante, etc)
			$this->places = $this->Place->Find();
			//campaigns
			$this->campaigns = $this->Campaign->Find();
			$this->data = $this->{$_POST['param']}->Find($_POST['id']);
			$this->render = array('layout'=>false,'partial'=>'editParam'.$_POST['param']);
		else:
			die();
		endif;
	}
	function deleteParamAction(){
		if(!empty($_POST['param'])):
			$this->{$_POST['param']}->Delete($_POST['id']);
			die();
		else:
			die();
		endif;
	}
	function toggleHasMoreAction(){
		$this->render = array('layout'=>false);
		if(!empty($_POST['id'])):
			$obj = $this->MessageKind->Find($_POST['id']);
			$obj->has_more = (integer)!$obj->has_more;
			$obj->Save();
		endif;
	}
}
?>
