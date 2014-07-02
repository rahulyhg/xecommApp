<?php

class page_xecommApp_page_ajaxhandler extends Page {

	function page_removecartitem(){
		$cart = $this->api->recall('xecommApp_cart',array());
		unset($cart[$_GET['item_id']-1]);
		$this->api->memorize('xecommApp_cart',$cart);
		$this->js(null,$this->js()->_selector('.xecommApp-cart')->trigger('reload'))->univ()->successMessage("Item Removed From Cart")->execute();
	}
}