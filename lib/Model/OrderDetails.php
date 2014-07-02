<?php

namespace xecommApp;

class Model_OrderDetails extends \Model_Table{
	public $table='xecommApp_orderDetails';

	function init(){
		parent::init();

		$this->hasOne('xecommApp/Order','order_id');
		$this->hasOne('xecommApp/Product','product_id');
		$this->addField('qty')->type('money');
		$this->addField('unit')->type('money');
		$this->addField('rate')->type('money');
		$this->addField('amount')->type('money');


		$this->add('dynamic_model/Controller_AutoCreator');
	}
}

