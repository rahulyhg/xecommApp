<?php

namespace xecommApp;

class Model_Order extends \Model_Table{
	public $table='xecommApp_orders';

	function init(){
		parent::init();

		$this->hasOne('xecommApp/MemberAll','member_id');
		// $this->hasOne('xecommApp/DiscountVoucher','discountvoucher_id');
		
		$this->addField('name')->caption('Order ID');
		$this->addField('order_status')->enum(array('OrderPlaced','OrderShiiped','OrderDenied'));
		$this->addField('payment_status')->enum(array('Pending','Cleared','Denied'));
		$this->addField('amount');
		$this->addField('points_redeemed');
		$this->addField('net_amount');
		$this->addField('order_summary');
		$this->addField('billing_address');
		$this->addField('shipping_address');
		$this->addField('order_date')->defaultValue(date('Y-m-d'));
		
		$this->hasMany('xecommApp/OrderDetails','order_id');
		// $this->hasMany('xecommApp/DiscountVoucherUsed','order_id');
		$this->add('dynamic_model/Controller_AutoCreator');
	}


	function placeOrder($order_info){
		
		$billing_address=$order_info['address']." ".$order_info['landmark']." ".$order_info['city']." ".$order_info['state']." ".$order_info['country']." ".$order_info['pincode'];
		$shipping_address=$order_info['shipping_address']." ".$order_info['s_landmark']." ".$order_info['s_city']." ".$order_info['s_state']." ".$order_info['s_country']." ".$order_info['s_pincode'];
		
		$cart_items=$this->api->recall('xecommApp_cart',array());
		$this['member_id'] = $this->api->xecommauth->model->id;
		$this['billing_address'] = $billing_address;
		$this['shipping_address'] = $shipping_address;		
		$this['payment_status'] = "Pending";
		$this['order_status'] = "OrderPlaced";
		$this['points_redeemed'] = $order_info['points_redeemed'];
			

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
			$this['net_amount'] = $total_amount - ( $order_info['points_redeemed'] / 10 );
			
			$this->save();


			return true;


	}

	function processPayment(){
		$this->api->forget('xecommApp_cart');
		return true;
	}
	function checkStatus(){
		
	}

	function getAllOrder($member_id){
		if($this->loaded())
			throw new \Exception("member model loaded nahi hona chahiye");	
			// $this->api->js(true)->univ()->errorMessage('Member Model Loded nahi hona chahiye');
		 
		 return $this->addCondition('member_id',$member_id);
				
		
		// throw new \Exception($member['']);
	}

	function sendOrderDetail(){
		if(!$this->loaded()) throw $this->exception('Model Must Be Loaded Before Email Send');
		
		$l=$this->api->locate('addons','xecommApp', 'location');
			$this->api->pathfinder->addLocation(
			$this->api->locate('addons','xecommApp'),
			array(
		  		'template'=>'templates',
		  		'css'=>'templates/css'
				)
			)->setParent($l);
			$tm=$this->add( 'TMail_Transport_PHPMailer' );
			$msg=$this->add( 'SMLite' );
			$msg->loadTemplate( 'mail/orderMail' );

			// The order html view
			$print=$this->add('xecommApp/View_PrintOrder');
			$print->setModel($this);

			//$msg->trySet('epan',$this->api->current_website['name']);		
			$msg->trySetHTML('order_place',$print->getHTML());

			$email_body=$msg->render();	

			$subject ="Your Order at Buddy Trade!!!";

			try{
				$tm->send($order->ref('member_id')->get('emailID'), $epan['email_username'], $subject, $email_body ,false,null);
			}catch( phpmailerException $e ) {
				// throw $e;
				$this->api->js(null,'$("#form-'.$_REQUEST['form_id'].'")[0].reset()')->univ()->errorMessage( $e->errorMessage() . " " . ""  )->execute();
			}catch( Exception $e ) {
				throw $e;
			}
	}
}