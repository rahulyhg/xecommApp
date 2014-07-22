<?php

namespace xecommApp;

class View_Server_Category extends \View{
	function init(){
		parent::init();
		
		$categories = $this->add('xecommApp/Model_Category');
		$categories->addCondition('parent_id',0);

		$view=$this->add('xecommApp/View_Lister_Category');
		$view->setModel($categories);
	}
}