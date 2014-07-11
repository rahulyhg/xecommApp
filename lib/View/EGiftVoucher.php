<?php

namespace xecommApp;

class View_EGiftVoucher extends \View{
function init(){
	parent::init();

	$this->add('View_Info')->set('Gift Voucher');
	
	}
}