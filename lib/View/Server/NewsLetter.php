<?php

namespace xecommApp;
class View_Server_NewsLetter extends \View{
	function init(){
		parent::init();

		$form=$this->add('Form');		
		$form->addClass( 'stacked' );
		$form->addField('line','email_id','')->setAttr('placeholder','Your Subscription E-mail id')->validateNotNull()->validateField('filter_var($this->get(), FILTER_VALIDATE_EMAIL)');
		$form->addSubmit('Subscribe');
		
		if($form->isSubmitted()){
			$subscriber=$this->add("xecommApp/Model_MemberAll");
			$subscriber->tryLoadAny();
			$subscriber->sendSubscribtionMail();
			// $subscriber->save();
		}

	}

}
