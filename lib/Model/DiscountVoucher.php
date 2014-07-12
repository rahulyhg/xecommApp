<?php

namespace xecommApp;

class Model_DiscountVoucher extends \Model_Table{
	public $table='xecommApp_discount_vouchers';

	function init(){
		parent::init();
		
		$this->hasOne('xecommApp/MemberAll','member_id');
		$this->addField('name')->caption('Voucher Number');
		$this->addField('pin')->caption('Voucher PIN');
		$this->addField('discount');

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}

