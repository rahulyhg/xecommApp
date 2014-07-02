<?php

namespace xecommApp;

class Model_CustomFieldValue extends \Model_Table{
	public $table='xecommApp_custom_fields_value';

	function init(){
		parent::init();
		$this->hasOne('xecommApp/CustomFields','customefield_id');

		$this->addField('name');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}