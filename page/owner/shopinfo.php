<?php

class page_xecommApp_page_owner_shopinfo extends page_xecommApp_page_owner_main{

	function init(){
		parent::init();

		$shop=$this->add('xecommApp/Model_Shop');
		$shop->tryLoadAny();
		$form=$this->add('Form');
		$form->setModel($shop);

		$form->addSubmit('Update');

		if($form->isSubmitted()){
			$form->update();

			$form->js()->univ()->successMessage("Updated SuccessFully")->execute();
		}

		
	}
}