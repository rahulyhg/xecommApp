<?php

namespace xecommApp;

class Model_DiscountVoucher extends \Model_Table{
	public $table='xecommApp_discount_vouchers';

	function init(){
		parent::init();
		
		$this->addField('name')->caption('Voucher Number');
		$this->addField('from')->caption('Strating Date');
		$this->addField('to')->caption('Expire Date');
		$this->addField('no_person')->caption('No of Person');
		$this->addField('discount')->caption('Discount Amount');

		$this->hasMany('xecommApp/DiscountVoucherUsed','discountvoucher_id');
		// $this->hasMany('xecommApp/Order','discountvoucher_id');
		$this->add('dynamic_model/Controller_AutoCreator');
	}
}

