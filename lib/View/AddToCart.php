<?php

namespace xecommApp;

class View_AddToCart extends \View{
	function init(){
		parent::init();
	}

	function setModel($product){
		$form = $this->add('Form',array('name'=>'adc_'.$product->id),null)->addClass('stacked');
		$form->addClass('addtocart');
		//$form->addField('Number','qty')->validateNotNull();
		$form->addField('hidden','product_id')->set($product['id']);//->afterField()->add('View')->set('Make Hidden');
		$form->addField('hidden','rate')->set($product['sale_price']);//->afterField()->add('View')->set('Make Hidden');
		$form->addField('hidden','product')->set($product['name']);
		//Todo CUSTOM FIELD 
		// foreach ($custom_field=$this->add('xecommApp/Model_CustomFields')->addCondition('product_id',$product->id) as $choice) {
		// 		// $value_list[$value]=$value;
		// 		$value_list =array();
		// 		foreach(explode(",",$custom_field['value']) as $val){
		// 			$value_list[$this->api->normalizeName($val)] = $val;
		// 		}	
		// 		$form->addField('DropDown',$this->api->normalizeName($custom_field['name']))->setValueList($value_list);//->setEmptyText('Mandatory');	
		// }
		$form->addSubmit('Add To Cart');
		

		if($form->isSubmitted()){
			$this->api->stickyGET($form->owner->owner->name."_paginator_skip");

			$old_cart=$this->api->recall('xecommApp_cart',array());
			$id=1;
			foreach ($old_cart as $products) {
				// throw new \Exception($products['id'], 1);
				
				// echo " haha ".$products['id'] . " <br>";
				if($products['id'] > $id){
						$id= $products['id'];
					}
				$id++;
			}

			$new_product=array('id'=>$id);
			$new_product['product_id'] = $form['product_id'];
			$new_product['product_name'] = $form['product'];
			$new_product['qty'] = 1;
			$new_product['sale_price'] = $form['rate'];
			
			// foreach ($custom_field=$this->add('xecommApp/Model_CustomFields')->addCondition('product_id',$form['product_id']) as $choice) {
			// 	$new_product['choice'][]=array(
			// 			'choice_label'=>$custom_field['name'],
			// 			'value'=>$form[$this->api->normalizeName($custom_field['name'])]
			// 		);
			// }

			$old_cart[]=$new_product;
			// throw new \Exception($form['qty']);
			$this->api->memorize('xecommApp_cart',$old_cart);
			$form->js(null,$this->js()->univ()->redirect($this->api->url(null)))->_selector('.xecommApp-cart')->trigger('reload')->execute();
		}

		parent::setModel($product);
	}
}