<?php

namespace xecommApp;

class Model_CustomFields extends \Model_Table{
	public $table='xecommApp_custom_fields';

	function init(){
		parent::init();
		$this->hasOne('xecommApp/Product','product_id');
		$this->addField('name');
		$this->addField('value');
		$this->hasMany('xecommApp/CustomFieldValue','customefield_id');


		$this->add('dynamic_model/Controller_AutoCreator');
	}
}

