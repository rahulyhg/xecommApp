<?php
class page_xecommApp_page_owner_configuration extends page_xecommApp_page_owner_main {
	function init(){
		parent::init();

		$config=$this->add('xecommApp/Model_Configuration');
		$config->tryLoadAny();
		$form=$this->add('Form');
		$form->setModel($config);
		$form->addSubmit('Save');

		if($form->isSubmitted()){
			$form->update();
		}
	}
}