<?php

class page_xecommApp_page_cartdetails extends Page{

	function init(){
		parent::init();

		$cart = $this->api->recall('xecommApp_cart',array());
		$v= $this->add('View');
		$v->addClass('xecommApp-cart');
		$v->js('reload')->reload();

		if($cart == null)
			$v->add('View_Info')->set('Your Cart is Empty');
		foreach ($cart as $cart_item) {
			$v1=$v->add('xecommApp/View_CartItem');
			$v1->setSource($cart_item);
		}
	}
}