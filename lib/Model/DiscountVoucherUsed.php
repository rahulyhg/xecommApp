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

	// function createNew($discountvoucher_id){
	// 	if(!$this->loaded())
	// 		throw new \Exception("DiscountVoucherUsed not loaded");
			
	// 	$this['discountvoucher_id']=$discountvoucher_id;
	// 	$this['member_id']=$this->api->xecommauth->model->id;
	// 	$this->save();
		
	// }
}

