<?php

class page_xecommApp_page_ajaxhandler extends Page {

	function init(){
		parent::init();

		$this->add('xecommApp/Plugins_AuthenticationCheck')->AuthenticatePage($this,$this);
		
		$task=$_GET['task'];

		if(!$task)
			throw new Exception("Must define task in query string", 1);

		call_user_method($task, $this);
			
	}


	function page_removecartitem(){
		$cart = $this->api->recall('xecommApp_cart',array());
		unset($cart[$_GET['item_id']-1]);
		$this->api->memorize('xecommApp_cart',$cart);
		$this->js(null,$this->js()->_selector('.xecommApp-cart')->trigger('reload'))->univ()->successMessage("Item Removed From Cart")->execute();
	}

	function validateVoucher(){
		$voucher=$this->add('xecommApp/Model_DiscountVoucher');
		if(!$_GET['v_no']) return "";
		if(!$voucher->isUsable($_GET['v_no'])){
			echo "$('".$_GET['form']."').atk4_form('fieldError','".$_GET['voucher_field']."','Not Valid')";
			exit;
		}else{
			$str="";
			echo $str;
			exit;
		}

	}

}
