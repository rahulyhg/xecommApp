<?php
class page_xecommApp_page_owner_main extends page_componentBase_page_owner_main{
	function init(){
		parent::init();

		$menu=$this->add('Menu');
		$menu->addMenuItem('xecommApp_page_owner_shopinfo','Shop Info');
		$menu->addMenuItem('xecommApp_page_owner_category','Category');
		$menu->addMenuItem('xecommApp_page_owner_products','Products');
		$menu->addMenuItem('xecommApp_page_owner_customFields','Custom Fields');
		$menu->addMenuItem('xecommApp_page_owner_order','Orders');
		$menu->addMenuItem('xecommApp_page_owner_user','Users Management');
		$menu->addMenuItem('xecommApp_page_owner_payment','Payment');
		$menu->addMenuItem('xecommApp_page_owner_shipping','Shipping');


	}

}
