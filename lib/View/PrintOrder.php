<?php

namespace xecommApp;

class View_PrintOrder extends \View{
	function init(){
		parent::init();


		$member=$this->add('xecommApp/Model_MemberAll')->load($this->api->cu_id);
		$this->template->trySet('member_name',$member['name']);
		$this->template->trySet('member_emailID',$member['emailID']);
		$this->template->trySet('member_address',$member['address']);
		$this->template->trySet('member_landmark',$member['landmark']);
		$this->template->trySet('member_city',$member['city']);
		$this->template->trySet('member_state',$member['state']);
		$this->template->trySet('member_country',$member['country']);
		$this->template->trySet('member_pincode',$member['pincode']);

		$config=$this->add('xecommApp/Model_Configuration')->tryLoadAny();
		$this->template->trySet('company_name',$config['company_name']);
		$this->template->trySet('company_address',$config['company_address']);
		$this->template->trySet('email_username',$config['email_username']);
		$this->template->trySet('company_terms',$config['company_terms']);

	}  

	function setModel($model){

		$order_detail = $this->add('xecommApp/Model_OrderDetails')->addCondition('order_id',$model->id);

		$view=$this->add('xecommApp/View_OrderDetail',null,'order_detail');
		$view->setModel($order_detail);
		parent::setModel($model);
		// $view->template->set('date',)
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
		return array('view/xecommApp-order');
	}
	
}
