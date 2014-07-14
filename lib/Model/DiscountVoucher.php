<?php

namespace xecommApp;

class Model_DiscountVoucher extends \Model_Table{
	public $table='xecommApp_discount_vouchers';

	function init(){
		parent::init();
		
		$this->addField('name')->caption('Voucher Number');
		$this->addField('from')->caption('Strating Date')->type('date')->defaultValue(date('Y-m-d'));
		$this->addField('to')->caption('Expire Date')->type('date');
		$this->addField('no_person')->caption('No of Person');
		$this->addField('discount_amount')->caption('Discount Amount');

		$this->hasMany('xecommApp/DiscountVoucherUsed','discountvoucher_id');
		// $this->hasMany('xecommApp/Order','discountvoucher_id');
		$this->add('dynamic_model/Controller_AutoCreator');
	}

	function isExpire(){

		$current_date=date('Y-m-d');
		if( strtotime($current_date) > strtotime($this['to']))
			return true;
		else
			return false;
	}

	function isUsable($voucher_no){

		$voucher=$this->add('xecommApp/Model_DiscountVoucher');
		$voucher->addCondition('name',$voucher_no);
		$voucher->tryLoadAny();
		if(!$voucher->loaded()){
			return false;
		}
			
		// if voucher expire he to error message
		if($voucher->isExpire()){
			throw new \Exception("voucher is expire");
		}
		// if voucher is not expire to get karo kitne person or use kar sakte he
		else{
			$person_used=$voucher->ref('xecommApp/DiscountVoucherUsed')->count()->getOne();
			
			if($voucher['no_person'] > $person_used){
				return $voucher['discount_amount'];
				// calulate discount amount 
			}
			// if no of person already consumed to error message 
			else{
				throw new \Exception("this Voucher exceed it's limit");
				
			}
							
		}


	}

}

