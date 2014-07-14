<?php
namespace xecommApp;
class Model_ProductImages extends \Model_Table {
	var $table= "xecommApp_product_images";
	function init(){
		parent::init();

		$this->hasOne('xecommApp/Product','product_id');
		
		$this->add('filestore/Field_Image','image_id');

		$this->add('dynamic_model/Controller_AutoCreator');
		
	}
}

