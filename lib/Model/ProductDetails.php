<?php

namespace xecommApp;

class Model_ProductDetails extends \Model_Table {
	var $table= "xecommApp_ProductDetails";
	function init(){
		parent::init();

		$this->hasOne('xecommApp/Product','product_id');

		$this->addField('name')->caption('Parameter');
		$this->addField('value');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}