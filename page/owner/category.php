<?php

class page_xecommApp_page_owner_category extends page_xecommApp_page_owner_main{

	function init(){
		parent::init();

		$crud=$this->add('CRUD');
		$crud->setModel('xecommApp/Category');
	}
}