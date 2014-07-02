<?php

namespace xecommApp;

class View_ProductSearch extends \View{

function init(){
	parent::init();

	$search_product = $this->add('xecommApp/Model_Product');

	$form=$this->add('Form');
   	$form_field=$form->addField('autocomplete2/Basic','search','');
   	$form_field->setModel($search_product);
	$form->template->tryDel('button_row');

   	if($form->isSubmitted()){
   		$form->api->redirect($this->api->url(null,array('subpage'=>'xecomm-dashboard','product_id'=>$form['search'])));
   		$this->js()->reload(array(''))->execute();
   	}
	
	}
}
