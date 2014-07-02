<?php

namespace xecommApp;

class Plugins_0xSocialAuthCheck extends \componentBase\Plugin{
	public $namespace = 'xecommApp';

	function init(){
		parent::init();

		
		$this->addHook('website-page-loaded',array($this,'AuthenticateSocialUser'));
	}

	function AuthenticateSocialUser($obj,&$page){

		$subpage = $_GET['subpage'];
		
		if(strpos($subpage,	'xecomm-') === 0){
			$this->api->template->appendHTML('js_include','<link type="text/css" href="epan-components/xecommApp/templates/css/xecomm.css" rel="stylesheet" />'."\n");
		}
		// ONLY WORKS FOR PAGES CONTAINS "xecomm-" IN PAGE
		// DO NOT CHECK FOR xecomm-login PAGE
		$allowed_pages =array('xecomm-verifyaccount','xecomm-dashboard','xecomm-home','xecomm-about','xecomm-registration');
		
		if(strpos($subpage,	'xecomm-') === 0 AND !in_array($subpage, $allowed_pages)){

			// check if user is logged in ecomm
			if(! $this->api->recall('logged_in_ecomm_user',false)){
			// if no
				// check if any user is logged in social
				if($social_login_user_email = $this->api->recall('logged_in_social_user',false)){
				// if yes
					// check if that user is also in ecomm
					$active_member = $this->add('xecommApp/Model_MemberAll');
					$active_member->tryLoadby('emailID',$social_login_user_email);
					if(!$active_member->loaded()){
					// if no
						// crete user from social details in ecomm 
						$social_user = $this->add('xsocialApp/Model_MemberAll')->loadBy('emailID',$social_login_user_email);

						$social_user_info =array(
							'first_name'=>$social_user['first_name'],
							'last_name'=>$social_user['last_name'],
							'password'=>$social_user['password'],
							'emailID' =>$social_user['emailID'],
							);
						$active_member->register($social_user_info);
						$active_member['is_verify']=true;
						$active_member->save();
					}else{
						// If not verified.. mark verified as well
						if(!$active_member['is_verify']){
							$active_member['is_verify']=true;
							$active_member->save();
						}
					}
					// login that user via xecommauth


					$xecomm_auth =$this->add('BasicAuth',array('is_default_auth'=>false));
					$xecomm_auth->setModel('xecommApp/AllVerifiedMembers','emailID','password');
					$this->api->xecommauth = $xecomm_auth;
					$this->api->cu_id = $xecomm_auth->model['id'];
					$this->api->cu_name = $xecomm_auth->model['first_name'] . ' ' . $xecomm_auth->model['last_name'];
					$this->api->cu_emailid = $xecomm_auth->model['emailID'];
					
					// TODO :: Set cu_id = null when logout

					$xecomm_auth->login($social_login_user_email);
					// Function memrize is explicitly called as we have not logged in via login panel
					// and login panel do this ... but here we are from social ... auto login .. so ...
					$this->api->memorize('logged_in_ecomm_user',$social_login_user_email);
				}
				// else
					// --- 
			}
		}
	}

	function getDefaultParams($new_epan){}
}

