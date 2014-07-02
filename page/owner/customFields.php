<?php

class page_xecommApp_page_owner_customFields extends page_xecommApp_page_owner_main{

	function init(){
		parent::init();

		$crud=$this->add('CRUD');
		$crud->setModel('xecommApp/CustomFields');
		$crud->addRef('xecommApp/CustomFieldValue',array('label'=>'Value'));
		
	}
}