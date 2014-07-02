<?php

namespace xecommApp;

class View_Server_MemberOrder extends \View{
	function init(){
		parent::init();

		$grid=$this->add('CRUD');
		$memberOrders=$this->add('xecommApp/Model_Order');
		$memberOrders->addCondition('member_id',$this->api->xecommauth->model->id);
		$grid->setModel($memberOrders);

}
}