<?php

namespace xecommApp;

class Plugins_AuthenticationCheck extends \componentBase\Plugin{
	public $namespace = 'xecommApp';

	function init(){
		parent::init();

		
		$this->addHook('website-page-loaded',array($this,'AuthenticatePage'));
	}

	function AuthenticatePage($obj,&$page){

		$subpage = $_GET['subpage'];
		
		if(strpos($subpage,	'xecomm-') === 0){
			$this->api->template->appendHTML('js_include','<link type="text/css" href="epan-components/xecommApp/templates/css/xecomm.css" rel="stylesheet" />'."\n");
		}
		// ONLY WORKS FOR PAGES CONTAINS "xecomm-" IN PAGE
		// DO NOT CHECK FOR xecomm-login PAGE
		$allowed_pages =array('xecomm-verifyaccount','xecomm-dashboard','xecomm-login','xecomm-home','xecomm-about','xecomm-registration');
		
		if(strpos($subpage,	'xecomm-') === 0 AND !in_array($subpage, $allowed_pages)){

			// IF session has logged_in_user value meanse user is there
			// load auth in api->xecommauth and login this user
			if($login_email = $this->api->recall('logged_in_ecomm_user',false) /*and !$this->api->xecommauth*/){
				$xecomm_auth =$this->add('BasicAuth',array('is_default_auth'=>false));
				$xecomm_auth->setModel('xecommApp/AllVerifiedMembers','emailID','password');
				$this->api->xecommauth = $xecomm_auth;
				$this->api->cu_id = $xecomm_auth->model['id'];
				$this->api->cu_name = $xecomm_auth->model['first_name'] . ' ' . $xecomm_auth->model['last_name'];
				$this->api->cu_emailid = $xecomm_auth->model['emailID'];
				
				// TODO :: Set cu_id = null when logout

				$xecomm_auth->login($login_email);
			}else{
				// User is not logged in .. redirect to login page
				$this->api->redirect($this->api->url(null,array('subpage'=>'xecomm-login','next_page'=>$_GET['subpage'])));
				return;
			}			
		}
	}

	function getDefaultParams($new_epan){}
}

