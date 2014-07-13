<?php

class page_xecommApp_page_owner_category extends page_xecommApp_page_owner_main{

	function init(){
		parent::init();

		$category_model = $this->add('xecommApp/Model_Category');
		$category_model->title_field='category_name';

		$crud=$this->add('CRUD');
		$crud->setModel($category_model);
		if($crud->form){
			$parent_model = $crud->form->getElement('parent_id')->getModel();
			$parent_model->title_field='category_name';
			// $parent_model->debug();
		}
	}
}