<?php
namespace xecommApp;
class Model_AllActiveMembers extends Model_MemberAll{
	function init(){
		parent::init();

		$this->addCondition('is_active',true);
	}

	function tryLogin($emailID,$password){

		$member=$this->add('xecommApp/Model_AllActiveMembers');

		$member->addCondition('emailID',$emailID); 
		$member->addCondition('password',$password);
		$member->tryLoadAny();

		if($member->loaded()){
			$this->api->memorize('logged_in_user',$emailID);
			return true;			
			}
			else{
				$this->api->forget('logged_in_user',$emailID);
				return false;				
			}
	}
}

