<?php

namespace xecommApp;

class View_EGiftVoucher extends \View{
function init(){
	parent::init();

	$form=$this->add('Form');	
	$form->addField('line','name','e-Gift Voucher Number')->validateNotNull('Required Field');
	$form->addField('line','pin','e-Gift Voucher PIN')->validateNotNull('Required Field');
	
	$form->addSubmit('Get Details');

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

	function defaultTemplate(){
		$l=$this->api->locate('addons',__NAMESPACE__, 'location');
		$this->api->pathfinder->addLocation(
			$this->api->locate('addons',__NAMESPACE__),
			array(
		  		'template'=>'templates',
		  		'css'=>'templates/css'
				)
			)->setParent($l);
		return array('view/xecommApp-voucher');
	}
}