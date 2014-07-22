<?php

namespace xecommApp;

class View_Lister_Product extends \CompleteLister{

	function formatRow(){
  			// throw new \Exception(print_r($this->model), 1);
  			  
		$details = $this->add('xecommApp/View_Lister_ProductDetails',null,'product_details');
		$details->setModel($this->add('xecommApp/Model_ProductDetails')->addCondition('product_id',$this->model->id));
		$this->current_row_html['product_details'] = $details->getHTML();
		$details->destroy();
				
		$cart = $this->add('xecommApp/View_AddToCart',null,'add_to_cart_form');
		$cart->setModel($this->model);
		$this->current_row_html['add_to_cart_form']=$cart->getHTML();
		$cart->destroy();
		
		if(!$this->model['show_offer'])
				$this->current_row_html['offer']='';
			
		$product=$this->add('xecommApp/Model_Product')->addCondition('is_publish',true);				
	}

	function recursiveRender(){

		$this->api->stickyGET('search');
		$product=$this->add('xecommApp/Model_Product')->addCondition('is_publish',true);
				
		if($_GET['category_id'])
			$product->addCondition('category_id',$_GET['category_id']);
		elseif($search=$_GET['search']){
			// throw $this->exception($_GET['search']);
			// $result->addExpression('Relevance')->set('MATCH(search_string) AGAINST ("'.$search.'" IN NATURAL LANGUAGE MODE WITH QUERY EXPANSION)');
			$product->addExpression('Relevance')->set('MATCH(search_string) AGAINST ("'.$search.'" IN NATURAL LANGUAGE MODE)');
			$product->addCondition('Relevance','>',0);
			$product->setOrder('Relevance','Desc');
		}
		

		if(!$product->count()->getOne())
			$this->template->trySetHtml('no_product_found','<h3>No Product Found</h3>');

		// todo price wise filter
		
		if( $_GET['min'] OR $_GET['max'] ){
			$product->addCondition('sale_price','>=', $_GET['min']);
			$product->addCondition('sale_price','<=', $_GET['max']);
			// $product->priceFilter($_GET['min'],$_GET['max']);	
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

