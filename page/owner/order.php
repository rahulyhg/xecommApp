<?php

class page_xecommApp_page_owner_order extends page_xecommApp_page_owner_main{

	function init(){
		parent::init();

		$crud=$this->add('CRUD');
		$crud->setModel('xecommApp/Order');
		$crud->addRef('xecommApp/OrderDetails',array('label'=>'Order Details'));
	}
}