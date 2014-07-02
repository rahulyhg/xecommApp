<?php

namespace xecommApp;

class View_Lister_Product extends \CompleteLister{

	function formatRow(){
  
		$details = $this->add('xecommApp/View_Lister_ProductDetails',null,'product_details');
		$details->setModel($this->add('xecommApp/Model_ProductDetails')->addCondition('product_id',$this->model->id));
		$this->current_row_html['product_details'] = $details->getHTML();
		$details->destroy();

		$cart = $this->add('xecommApp/View_AddToCart',null,'add_to_cart_form');
		$cart->setModel($this->model);
		$this->current_row_html['add_to_cart_form']=$cart->getHTML();
		$cart->destroy();
	}

	function recursiveRender(){
		$product=$this->add('xecommApp/Model_Product');

		if($_GET['category_id'])
			$product->addCondition('category_id',$_GET['category_id']);
		elseif($_GET['product_id']){
			$product->addCondition('id',$_GET['product_id']);
		}

		$this->setModel($product);

		parent::recursiveRender();
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

		return array('view/xecommApp-productlist');


	}

}

