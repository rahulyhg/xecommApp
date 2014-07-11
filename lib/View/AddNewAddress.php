<?php

namespace xecommApp;

class View_AddNewAddress extends \View{
function init(){
	parent::init();

		$this->add('View_Info')->setHtml($this->api->cu_emailid);
		$form=$this->add('Form');	
		$form->addField('text','street_address')->validateNotNull('Required Field');
		$form->addField('line','landmark')->validateNotNull('Required Field');
		$form->addField('line','city')->validateNotNull('Required Field');
		$form->addField('line','state')->validateNotNull('Required Field');
		$form->addField('line','country')->validateNotNull('Required Field');
		$form->addField('Number','pincode')->validateNotNull('Required Field');
		$form->addField('Number','mobile_Number')->validateNotNull('Required Field');

		$form->addSubmit('Save Changes');

		if($form->isSubmitted()){
			// throw new \Exception($this->api->cu_id);
			
			$member=$this->add('xecommApp/Model_MemberAll')->load($this->api->cu_id);

			if($member->changeAddress($form->getAllFields())){
				$form->js(true,$this->js()->univ()->successMessage('Address Change Success fully'))->reload()->execute();
			}
			else
				$form->displayError('old_password','Password is worng');


		}
	}
}