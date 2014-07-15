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
		$this->addField('discount_voucher');
		$this->addField('discount_voucher_amount');
		$this->addField('net_amount');
		$this->addField('order_summary');
		$this->addField('billing_address');
		$this->addField('shipping_address');
		$this->addField('order_date')->defaultValue(date('Y-m-d'));
		
		$this->hasMany('xecommApp/OrderDetails','order_id');
		// $this->hasMany('xecommApp/DiscountVoucherUsed','order_id');
		// $this->add('dynamic_model/Controller_AutoCreator');
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
			//TODO NET AMOUNT, TAXES, DISCOUNT VOUCHER AMOUNT etc.. CALCULATING AGAIN FOR SECURITY REGION 
			$discountvoucher=$this->add('xecommApp/Model_DiscountVoucher');

			$discount_per=$discountvoucher->isUsable($order_info['discount_voucher']);
			$discount_voucher_amount=$total_amount * $discount_per /100;	

			
			$this['discount_voucher']=$order_info['discount_voucher'];
			$this['discount_voucher_amount']=$discount_voucher_amount;
			$this['net_amount'] = $total_amount - (( $order_info['points_redeemed'] / 10 ) + $discount_voucher_amount );
			// throw new \Exception($discount_voucher_amount."net amount ".$this['net_amount']);				
										
			$this->save();

			$discountvoucher->processDiscountVoucherUsed($this['discount_voucher']);

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
		
		$epan=$this->add('Model_Epan');//load epan model
		$epan->tryLoadAny();
	
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

		//$msg->trySet('epan',$this->api->current_website['name']);		
		$print=$this->add('xecommApp/View_PrintOrder');
		
		$print->setModel($this);
		

		$msg->trySet('epan',$this->api->current_website['name']);		
		$msg->trySetHTML('order_place',$print->getHTML(false));

		$email_body=$msg->render();	

		$subject ="Thanku for Order";

		try{
			$tm->send($this->api->xecommauth->model['emailID'], $epan['email_username'], $subject, $email_body ,false,null);
		}catch( phpmailerException $e ) {
			// throw $e;
			$this->api->js(null,'$("#form-'.$_REQUEST['form_id'].'")[0].reset()')->univ()->errorMessage( $e->errorMessage() . " " . $epan['email_username'] )->execute();
		}catch( Exception $e ) {
			throw $e;
		}
	}

}