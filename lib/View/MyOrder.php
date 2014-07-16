<?php

namespace xecommApp;

class View_MyOrder extends \View{
	
function init(){
	parent::init();

		if($_GET['print']){
			$this->js()->univ()->newWindow($this->api->url("xecommApp/page_printorder",array('order_id'=>$_GET['print'],'cut_page'=>1,'subpage'=>'xecomm-junk')),null,'height=689,width=1246,scrollbar=1')->execute();
		}
		
		// if($_GET['button']){
		// 	$this->js()->univ()->newWindow($this->api->url("xecommApp/page_orderdetail",array('order_id'=>$_GET['detail'],'cut_page'=>1)),null,'height=689,width=1246,scrollbar=1')->execute();
		// }
		$order=$this->add('xecommApp/Model_Order');
		$order->getAllOrder($this->api->xecommauth->model->id);
		$grid=$this->add('Grid');
		$order->_dsql()->order('id','desc');
		$grid->setModel($order);

		$grid->addColumn('button','print');
		$grid->addPaginator(10);
		// $grid->addColumn('button','detail');
		
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
