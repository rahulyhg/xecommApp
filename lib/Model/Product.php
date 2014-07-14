<?php

namespace xecommApp;
class Model_Product extends \Model_Table{
	public $table='xecommApp_products';

	function init(){
		parent::init();
		$this->hasOne('xecommApp/Category','category_id');

		$this->addField('sku')->PlaceHolder('Insert Unique SKU Number');
		$this->addField('name')->Caption('Product Name')->mandatory(true);
		$this->addField('description')->type('text')->mandatory(true);
		$this->addField('original_price')->mandatory(true);
		$this->addField('sale_price')->mandatory(true);
		$this->addField('created_at')->type('date')->defaultValue(date('Y-m-d'));		
		// $this->addField('discount')->defaultValue(0)->PlaceHolder('Discount Amount in % i.e. 10 ');
		// $this->addField('expiry_date');
		$this->addField('is_publish')->type('boolean');
		$this->add('filestore/Field_Image','Product_image_id')->mandatory(true);

		// $this->addField('latest_product')->type('boolean');
		$this->addField('is_featured')->type('boolean');
		$this->addField('is_special')->type('boolean');
		$this->addField('is_mostviewed')->type('boolean');

		$this->addField('search_string')->type('text')->system(true);

		$this->hasMany('xecommApp/ProductDetails','product_id');
		$this->hasMany('xecommApp/ProductImages','product_id');
		$this->hasMany('xecommApp/CustomFields','product_id');
		$this->addHook('beforeSave',$this);
		$this->add('dynamic_model/Controller_AutoCreator');
	
	}

	function beforeSave(){
		
		$product=$this->add('xecommApp/Model_Product');		
		$product->addCondition('id',$this['id']);
		$count=$product->count()->getOne();
		// throw new \Exception($count);
		
		//  if this[id] purani id me nahi he to new and check sku
		if($count){
			if(!$product->hasSKU($this['sku']))
				throw new \Exception("SKU number must be Unique");
		}
		else{
			if( $product->hasSKU($this['sku']) )
			throw new \Exception("SKU number must be Unique");
		}
		// if this[id] purani id me he to replace sku and check  

		if($product['id'] != $this['id'])
			throw new \Exception("Error Processing Request", 1);
			
		// if($product->hasSKU($this['sku']))
		// 	throw new \Exception("SKU Number".$this['sku'] ."is already taken");
		$this['search_string']= $this->ref('category_id')->get('name') . " ".
								$this["name"]. " ".
								$this['sku']. " ".
								$this["description"]. " ".
								$this['sale_price']
							;
	}

	function hasSKU($sku){
		$product_old=$this->add('xecommApp/Model_Product');
		$product_old->addCondition('sku',$sku);
		return $product_old->count()->getOne();
	} 

}

