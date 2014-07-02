<?php

namespace xecommApp;

class View_Server_Register extends \View{
	function init(){
		parent::init();


		$form=$this->add('Form');
		$form->addClass('stacked');
		$form->addField('line','first_name')->validateNotNull('Required Field');
		$form->addField('line','last_name')->validateNotNull('Required Field');
		$form->addField('line','emailId','Email id')->validateNotNull()->validateField('filter_var($this->get(), FILTER_VALIDATE_EMAIL)');
		$form->addField('password','password')->validateNotNull('Required Field');
		$form->addField('password','repassword')->validateNotNull('Required Field');
		$form->addField('line','referId');
		// $form->addField('line','captcha')->add('x_captcha/Controller_Captcha');
		$form->addSubmit('Register');

			
		
		if($form->isSubmitted()){
			//TODO PASSWORD AND RE-PASSWORD CHECK 
			if($form['password'] != $form['repassword']){	
				//$form->js()->univ()->errorMessage('Re-type Password')->execute();
				$form->displayError('repassword','Re-password not Match');
			}

			$member=$this->add('xecommApp/Model_MemberAll');
			//TODO CHECK REFER ID 
			if($form['referId'] != null){
				if(!$member->has_referId($form['referId'])){
					//$form->js()->univ()->errorMessage('Refer id is not Found')->execute();
					$form->displayError('referId','Refer Id Not Found');
				}
			}	

			//TODO CHECK EXISTING USER
			$user=$this->add('xecommApp/Model_MemberAll');
			if($user->is_registered($form['emailId'])){
				$form->displayError('emailId','Email id Alredy Existing');
			}	



			$visitor=$this->add('xecommApp/Model_MemberAll');			
			if($visitor->register($form->getAllFields())){
				$visitor->sendVerificationMail();
				$this->api->redirect($this->api->url(null,array('subpage'=>'xsocial-verifyaccount')));
			}


		}

	}
}