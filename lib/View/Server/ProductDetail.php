<?php

namespace xecommApp;

class View_Server_ProductDetail extends \View{
	function init(){
		parent::init();

		$this->api->stickyGET('product_id');
		$product=$this->add('xecommApp/Model_Product');
		// throw new \Exception($_GET['product_id'], 1);
		if($_GET['product_id'])
		$product->load($_GET['product_id']);

		$details = $this->add('xecommApp/View_Lister_ProductDetails',null,'product_details');
		$details->setModel($this->add('xecommApp/Model_ProductDetails')->addCondition('product_id',$_GET['product_id']));
		
		// do adding multiple images of a single product
		$images = $this->add('xecommApp/View_Lister_ProductImages',null,'product_images');
		$images->setModel($this->add('xecommApp/Model_ProductImages')->addCondition('product_id',$_GET['product_id']));		
		
		$cart = $this->add('xecommApp/View_AddToCart',null,'add_to_cart_form');
		$cart->setModel($product);
		
		$this->setModel($product); // use for placing value in its spot in default templates 
		// $this->setModel($details);

	}
	function defaultTemplate(){
		$l=$this->api->locate('addons',__NAMESPACE__, 'location');
		$this->api->pathfinder->addLocation(
			$this->api->locate('addons',__NAMESPACE__),
			array(
		  		'template'=>'templates',
		  		'css'=>'templates/css',
		  		'js'=>'templates/js'
				)
			)->setParent($l);

		return array('view/xecommApp-productdetailview');
	}


}