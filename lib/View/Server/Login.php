<?php

namespace xecommApp;

class View_Server_Login extends \View{
	function init(){
		parent::init();
		
		if($_GET['next_page'])
			$this->api->stickyGET('next_page');

		// check if we are already logged in but still going for this page
		if($this->api->recall('logged_in_ecomm_user',false) ){
		// if yes
			if($_GET['next_page']){
			// if we have $_GET['next_page'] 
				// go to that
				$this->api->redirect($this->api->url(null,array('subpage'=>$_GET['next_page'])));
				return;
			}else{
			// else
				// go to home
				$this->api->redirect($this->api->url(null,array('subpage'=>'xecomm-home')));
				return;
			}
		}

		// $this->add('p')->set('Login Form');
		$form=$this->add('Form',null,null);
		$form->addClass('stacked');
		$form->addField('line','emailID','User  Name')->validateNotNull('Required Field');
		$form->addField('password','password','Password')->validateNotNull('Required Field');
		//$form->addSubmit('login');

		$form->add('Button')->set('Login')
		->addStyle(array('margin-top'=>'25px','margin-left'=>'auto','margin-right'=>'auto'))
			->js('click')->submit();
		
		// Redirect to Verify Account
		$verify_btn=$this->add('Button')->set('Verification');
			if($verify_btn->isClicked()){
				$this->api->redirect($this->api->url(null,array('subpage'=>'xecomm-verifyaccount')));
		 	}

		if($form->isSubmitted()){
		
			$member=$this->add('xecommApp/Model_AllVerifiedMembers');

		 	if(!$member->tryLogin($form['emailID'],$form['password']))
		 		$form->displayError('emailID','wrong username');
				// Redirect to Dashboard	
				$this->js()->univ()->redirect($this->api->url(null,array('subpage'=>'xecomm-dashboard')))->execute();
			}

		 	// throw new \Exception($this->api->cu_id);

	}
	// 	function defaultTemplate(){
	// 	$l=$this->api->locate('addons',__NAMESPACE__, 'location');
	// 	$this->api->pathfinder->addLocation(
	// 		$this->api->locate('addons',__NAMESPACE__),
	// 		array(
	// 	  		'template'=>'templates',
	// 	  		'css'=>'templates/css'
	// 			)
	// 		)->setParent($l);
	// 	return array('view/xecomm-login');
	// }
}
