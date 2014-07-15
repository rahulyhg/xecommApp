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
			
			$str="$('".$_GET['total_field']."').val() * 0 / 100";
			$dis="$('".$_GET['discount_amount_field']."').val(0)";
			$dis.=";";
			$net="$('".$_GET['total_field']."').val() - $('".$_GET['discount_amount_field']."').val()";
			$dis.="$('".$_GET['net_field']."').val($net)";
			$dis.=";";
			$dis.="$('".$_GET['form']."').atk4_form('fieldError','".$_GET['voucher_field']."','Not Valid')";			
			echo $dis; 
			exit;
		}else{			
			$str=$voucher->isUsable($_GET['v_no']);
			$str="$('".$_GET['total_field']."').val() * '".$str."' / 100";
			$dis="$('".$_GET['discount_amount_field']."').val($str)";
			$dis.=";";
			$net="$('".$_GET['total_field']."').val() - $('".$_GET['discount_amount_field']."').val()";
			$dis.="$('".$_GET['net_field']."').val($net)";	
			
			echo $dis;
			exit;
		}

	}

}
