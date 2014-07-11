<?php

namespace xecommApp;

class View_MyOrder extends \View{
function init(){
	parent::init();

		if($_GET['print']){
			$this->js()->univ()->newWindow($this->api->url("printorder",array('bill_id'=>$_GET['print'],'cut_page'=>1)),null,'height=689,width=1246,scrollbar=1')->execute();
		}
		
		$order=$this->add('xecommApp/Model_Order');
		$order->getAllOrder($this->api->cu_id);
		$grid=$this->add('Grid');
		$grid->setModel($order);
		// $grid->addRef('xecommApp/OrderDetails',array('label'=>'Order Details'));
		$grid->addColumn('button','print');
		$grid->addColumn('expander','detail');
		// $grid->addRef('xecommApp/Model_OrderDetails');
		// $member->
	}
	
	// function page_detail(){
	// 	$this->api->stickyGET('order_id');
	// 	$order=$this->add('Model_Order');
	// 	$order->load($_GET['order_id']);
	// 	$grid=$this->add('CRUD');
	// 	$detail=$order->ref('xecommApp/Model_OrderDetails')
	// 	->addCondition('id',$order['id']);
	// 	// ->addCondition('transaction_type','PaymentPaid');
	// 	$grid->setModel($detail);
	// }
}
