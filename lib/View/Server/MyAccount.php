<?php

namespace xecommApp;

class View_Server_MyAccount extends \View{
	function init(){
		parent::init();

		$tabs=$this->add('Tabs');
		$personal_info=$tabs->addTab('Personal Information');
		$change_password=$tabs->addTab('Change Password');
		$add_new_address=$tabs->addTab('Add New Address');
		$e_gift_voucher=$tabs->addTab('e-Gift Voucher');
		$order=$tabs->addTab('My Order');
		
		$personal_info->add('xecommApp/View_PersonalInfo');
		$change_password->add('xecommApp/View_ChangePassword');
		$add_new_address->add('xecommApp/View_AddNewAddress');
		$e_gift_voucher->add('xecommApp/View_EGiftVoucher');
		$order->add('xecommApp/View_MyOrder');
		// $grid=$this->add('Grid')->setModel('xecommApp/Order');


	}
}