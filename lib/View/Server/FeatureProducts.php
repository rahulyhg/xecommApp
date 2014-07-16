<?php

namespace xecommApp;

class View_Server_FeatureProducts extends \View{
	function init(){
		parent::init();

		$tab=$this->add('Tabs');
		$latest=$tab->addTab('Features');

		$feature_view=$latest->add('xecommApp/View_Lister_ProductWidget');
		$feature_view->setModel('xecommApp/Model_FeatureProducts');

		$paginator = $feature_view->add('Paginator');
		// $paginator = $special_view->add('Paginator');
		// $paginator = $mostviewed_view->add('Paginator');
		$paginator->ipp(4);
		//$this->add('View')->set('hello featured products');


	}
}