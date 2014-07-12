
<?php

namespace xecommApp;

class Model_DiscountVoucherUsed extends \Model_Table{
	public $table='xecommApp_discount_vouchers_used';

	function init(){
		parent::init();
		
		$this->hasOne('xecommApp/DiscountVoucher','discountvoucher_id');
		$this->hasOne('xecommApp/MemberAll','member_id');	
		

		$this->add('dynamic_model/Controller_AutoCreator');
	}
}

