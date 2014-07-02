<?php

namespace xecommApp;

class Model_Shop extends \Model_Table{
	public $table='xecommApp_shop';

	function init(){
		parent::init();

		$this->addField('name');
		$this->addField('address')->type('text');
		$this->addField('mobile_no')->type('int');
		$this->addField('email_id');
		$this->add('filestore/Field_Image','Company_logo_id');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}