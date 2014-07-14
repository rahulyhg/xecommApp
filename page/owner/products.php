<?php

class page_xecommApp_page_owner_products extends page_xecommApp_page_owner_main{

	function init(){
		parent::init();

		$model = $this->add('xecommApp/Model_Product');

		$crud=$this->add('CRUD');
		$crud->setModel($model);
		if($crud->isEditing()){
			$model_cat=$crud->form->getElement('category_id')->getModel();
			$model_cat->title_field="category_name";
		}

		$crud->addRef('xecommApp/ProductImages',array('label'=>'Images'));
		$crud->addRef('xecommApp/ProductDetails',array('label'=>'Details'));
		$crud->addRef('xecommApp/CustomFields',array('label'=>'Custome Fields'));
	}


	
}