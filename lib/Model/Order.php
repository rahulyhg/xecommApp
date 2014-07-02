<?php

namespace xecommApp;

class Model_Order extends \Model_Table{
	public $table='xecommApp_orders';

	function init(){
		parent::init();

		$this->hasOne('xecommApp/MemberAll','member_id');
		$this->addField('name')->caption('Order ID');
		$this->addField('order_status')->enum(array('OrderPlaced','OrderShiiped','OrderDenied'));
		$this->addField('payment_status')->enum(array('Pending','Cleared','Denied'));
		$this->addField('amount');
		$this->addField('order_summary');
		$this->addField('billing_address');
		$this->addField('shipping_address');
		$this->addField('order_date');
		
		$this->hasMany('xecommApp/OrderDetails','order_id');

		$this->add('dynamic_model/Controller_AutoCreator');
	}


	function placeOrder($order_info){
		
		$cart_items=$this->api->recall('xecommApp_cart',array());
		$this['member_id'] = $this->api->xecommauth->model->id;
		$this['billing_address'] = $order_info['address'];
		$this['shipping_address'] = $order_info['shipping_address'];
		$this['payment_status'] = "Pending";
		$this['order_status'] = "OrderPlaced";

		$this->save();
		$order_details=$this->add('xecommApp/Model_OrderDetails');
			$i=1;
			$total_amount=0;
			foreach ($cart_items as $order_detail) {

				$order_details['order_id']=$this->id;
				$order_details['product_id']=$order_info['productid_'.$i];
				$order_details['qty']=$order_info['qty_'.$i];
				$order_details['rate']=$order_info['productrate_'.$i];
				$order_details['amount']=$order_info['qty_'.$i]*$order_info['productrate_'.$i];
				$total_amount+=$order_details['amount'];
				$order_details->saveAndUnload();
				$i++;

			}

			$this['amount']=$total_amount;
			//TODO NET AMOUNT, TAXES etc..
			$this->save();


			return true;


	}

	function processPayment(){

		$this->api->forget('xecommApp_cart');

		return true;
	}
	function checkStatus(){
		
	}
}