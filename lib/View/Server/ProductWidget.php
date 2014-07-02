<?php

namespace xecommApp;

class View_Server_ProductWidget extends \View{
	function init(){
		parent::init();

		
		$tab=$this->add('Tabs');
		$latest=$tab->addTab('Latest');
		$special=$tab->addTab('Special');
		$mostviewed=$tab->addTab('Most View');

		$latest_view=$latest->add('xecommApp/View_Lister_ProductWidget');	
		$special_view=$special->add('xecommApp/View_Lister_ProductWidget');
		$mostviewed_view=$mostviewed->add('xecommApp/View_Lister_ProductWidget');

		$product=$this->add('xecommApp/Model_Product');
		$publish_product=$product->addCondition('is_publish',true);
				
		$latest_view->setModel($publish_product->setOrder('created_at','desc'));

		$special_view->setModel('xecommApp/Model_SpecialProducts');
		$mostviewed_view->setModel('xecommApp/Model_MostViewedProducts');
		
		$paginator_latest = $latest_view->add('Paginator');
		$paginator_special = $special_view->add('Paginator');
		$paginator_mostviewed = $mostviewed_view->add('Paginator');
		$paginator_latest->ipp(4);
		$paginator_special->ipp(4);
		$paginator_mostviewed->ipp(4);
		//$this->add('View')->set('hello featured products');


	}
}