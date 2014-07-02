<?php

namespace xecommApp;

class View_Server_Logout extends \View{
	function init(){
		parent::init();


		$btn = $this->add('Button',null,'logout')->set('Logout')->setAttr(array('title'=>'Logout','data-toggle'=>'tooltip', 'data-placement'=>'bottom'));
		$btn->js(true)->hide();
		if($login_email = $this->api->recall('logged_in_ecomm_user',false)){
			$xecomm_auth =$this->add('BasicAuth',array('is_default_auth'=>false));
			$xecomm_auth->setModel('xecommApp/AllVerifiedMembers','emailID','password');
			$this->api->xecommauth = $xecomm_auth;
			$this->api->cu_id = $xecomm_auth->model['id'];
			$this->api->cu_name = $xecomm_auth->model['first_name'] . ' ' . $xecomm_auth->model['last_name'];
			$this->api->cu_emailid = $xecomm_auth->model['emailID'];
			
			// TODO :: Set cu_id = null when logout
			$xecomm_auth->login($login_email);
			$this->add('View',null,'member_login')->set($xecomm_auth->model['name']);
			$btn->js(true)->show();			
		}
		
		if($btn->isClicked()){
			// $login_email = $this->api->recall('logged_in_user',false);
			// $login_email="";
			$this->api->xecommauth->logout();
			$this->api->redirect($this->api->url(null,array('subpage'=>'xecomm-home')));
		}
	}	


	function defaultTemplate(){
		$l=$this->api->locate('addons',__NAMESPACE__, 'location');
		$this->api->pathfinder->addLocation(
			$this->api->locate('addons',__NAMESPACE__),
			array(
		  		'template'=>'templates',
		  		'css'=>'templates/css'
				)
			)->setParent($l);
		return array('view/xecommApp-logout');
	}
}
