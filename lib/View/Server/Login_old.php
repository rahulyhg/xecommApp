<?php

namespace xecommApp;

class View_Server_Login extends \View{
	function init(){
		parent::init();
		
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
				$this->api->redirect($this->api->url(null,array('subpage'=>'xsocial-verify-account')));
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
