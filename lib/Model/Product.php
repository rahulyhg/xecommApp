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
		$this->addField('sale_price')->type('int')->mandatory(true);
		$this->addField('created_at')->type('date')->defaultValue(date('Y-m-d'));		
		// $this->addField('discount')->defaultValue(0)->PlaceHolder('Discount Amount in % i.e. 10 ');
		// $this->addField('expiry_date');
		$this->addField('is_publish')->type('boolean');
		$this->add('filestore/Field_Image','Product_image_id')->mandatory(true);

		// $this->addField('latest_product')->type('boolean');
		$this->addField('is_featured')->type('boolean');
		$this->addField('is_special')->type('boolean');
		$this->addField('is_mostviewed')->type('boolean');
		$this->addField('show_offer')->type('boolean');

		$this->addField('search_string')->type('text')->system(true);

		$this->hasMany('xecommApp/ProductDetails','product_id');
		$this->hasMany('xecommApp/ProductImages','product_id');
		$this->hasMany('xecommApp/CustomFields','product_id');
		$this->addHook('beforeSave',$this);
		$this->add('dynamic_model/Controller_AutoCreator');
	
	}

	function beforeSave(){
		$product_old=$this->add('xecommApp/Model_Product');
		if($this->loaded())
			$product_old->addCondition('id','<>',$this->id);
		$product_old->addCondition('sku',$this['sku']);
		$product_old->tryLoadAny();
		if($product_old->loaded())
			throw new \Exception("Allready Exist");
			
		$this['search_string']= $this->ref('category_id')->get('name') . " ".
								$this["name"]. " ".
								$this['sku']. " ".
								$this["description"]. " ".
								$this['sale_price']
							;
	}

	// function hasSKU($sku){
	// 	if($this->loaded())
	// 		$this->addCondition('id','<>',$this->id)
	// 	$product_old=$this->add('xecommApp/Model_Product');
	// 	$product_old->addCondition('sku',$sku);
	// 	return $product_old->count()->getOne();
	// } 
	function priceFilter( $minPrice, $maxPrice ){
		// if($this->loaded())
		// 	throw new \Exception("Product Model must be loaded before product priceFilter");
		$this->addCondition('sale_price','>=',$minPrice);
		$this->addCondition('sale_price','<=', $maxPrice);

		return $this;
	}	

			


}

