<?php

namespace xecommApp;

class View_Server_Cart extends \View{
	function init(){
		parent::init();
		$this->addClass('xecommApp-cart');
		$this->js('reload')->reload();
	}

	function recursiveRender(){

		
		$total_amount=0;
		$cart=$this->api->recall('xecommApp_cart',array());
		
		foreach ($cart as $junk) {
			$total_amount+=$junk['qty']*$junk['sale_price'];
		}
		
		$this->add('View')->set('Shopping Cart')->addClass('glyphicon glyphicon-shopping-cart');

		$row1=$this->add('Columns');
		$row1_left=$row1->addColumn(6);
		$row1_right=$row1->addColumn(6);
		$row1_left->add('View')->setHtml(count($cart).' item(s)')->addClass('badge alert-success');
		$row1_right->add('View')->setHtml('&#8377 '.$total_amount)->addClass('badge alert-danger');
		
		// $row2=$this->add('Columns');
		// $row2_left=$row2->addColumn(4);
		// $row2_middle=$row2->addColumn(4);
		// $row2_right=$row2->addColumn(4);

		$btn_set = $this->add('View_ButtonSet');

		$btn = $btn_set->addButton('Empty');//->addClass('glyphicon glyphicon-trash');
		//$row2_left->add($btn);
		
		$checkout_btn = $btn_set->addButton('Checkout');
		// $checkout_btn->addClass('glyphicon glyphicon-check');	
		//$row2_middle->add($checkout_btn);
		
		$viewcart_btn = $btn_set->addButton('ViewCart');//->addClass('glyphicon glyphicon-th');
		//$row2_right->add($viewcart_btn);

		if($btn->isClicked()){
			$this->api->memorize('xecommApp_cart',array());
			$this->api->js()->univ()->redirect('/')->execute();
		}

		if($checkout_btn->isClicked()){
			// $this->js()->univ()->alert("khk")->execute();
			$this->api->js()->univ()->redirect(null,array('subpage'=>'xecomm-checkout'))->execute();
		}

		if($viewcart_btn->isClicked()){
			$this->js()->univ()->frameURL("Your Cart",$this->api->url('xecommApp_page_cartdetails'))->execute();
		}

		// $cart = $this->api->recall('xecommApp_cart',array());
		// foreach ($cart as $cart_item) {
		// 	$v=$this->add('xecommApp/View_CartItem');
		// 	$v->setSource($cart_item);
		// }
		parent::recursiveRender();
	}
}