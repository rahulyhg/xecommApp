<?php

namespace xecommApp;
class Model_Product extends \Model_Table{
	public $table='xecommApp_products';

	function init(){
		parent::init();
		$this->hasOne('xecommApp/Category','category_id');

		$this->addField('sku');
		$this->addField('name')->Caption('Product Name');
		$this->addField('description')->type('text');
		$this->addField('original_price');
		$this->addField('sale_price');
		$this->addField('created_at')->type('date')->defaultValue(date('Y-m-d'));		
		$this->addField('expiry_date');
		$this->addField('is_publish')->type('boolean');
		$this->add('filestore/Field_Image','Product_image_id');

		// $this->addField('latest_product')->type('boolean');
		$this->addField('is_featured')->type('boolean');
		$this->addField('is_special')->type('boolean');
		$this->addField('is_mostviewed')->type('boolean');

		$this->addField('search_string')->type('text');

		$this->hasMany('xecommApp/ProductDetails','product_id');
		$this->hasMany('xecommApp/ProductImages','product_id');
		$this->hasMany('xecommApp/CustomFields','product_id');
		$this->addHook('beforeSave',$this);
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function beforeSave(){
		$this['search_string']= $this->ref('category_id')->get('name') . " ".
								$this["name"]. " ".
								$this['sku']. " ".
								$this["description"]. " ".
								$this['sale_price']
							;
	}

}

