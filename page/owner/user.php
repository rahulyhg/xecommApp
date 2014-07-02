<?php

class page_xecommApp_page_owner_user extends page_xecommApp_page_owner_main{

	function init(){
		parent::init();

		$crud=$this->add('CRUD');
		$crud->setModel('xecommApp/MemberAll');
	}
}