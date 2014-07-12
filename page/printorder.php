<?php

class page_xecommApp_page_printorder extends Page{

	function init(){
		parent::init();

		$print=$this->add('xecommApp/View_PrintOrder');
		$order=$this->add('xecommApp/Model_Order')->load($_GET['order_id']);		
		$print->setModel($order);

	}
}
	