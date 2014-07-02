<?php

class page_xecommApp_page_owner_products extends page_xecommApp_page_owner_main{

	function init(){
		parent::init();

		$crud=$this->add('CRUD');
		$crud->setModel('xecommApp/Product');
		$crud->addRef('xecommApp/ProductImages',array('label'=>'Images'));
		$crud->addRef('xecommApp/ProductDetails',array('label'=>'Details'));
		$crud->addRef('xecommApp/CustomFields',array('label'=>'Custome Fields'));
	}
}