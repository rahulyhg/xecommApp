<?php
  
namespace xecommApp;

class View_CartItem extends \View{
	public $cart_item=array();

	function setSource($cart_item=array()){
		$this->cart_item=$cart_item;

		// $this->js('reload');

		foreach ($cart_item as $parameter => $value) {
			if(is_array($value)){ //choices
				$choise_str="";
				foreach ($value as $user_choise) {
					$choise_str .= $user_choise['choice_label'] . " - " . $user_choise['value']. '; ';
				}
				$this->template->trySet('choices',$choise_str);
			}else{
				$this->template->trySet($parameter,$value);
			}
		}

	}

	function recursiveRender(){
		

		$form=$this->add('Form',null,'qty',array('form_horizontal'));
		$form->addField('line','qty')->set($this->cart_item['qty']);
		$s_f=$form->addField('line','rate')->set($this->cart_item['sale_price']);
		$s_f->setAttr( 'disabled', 'true' )->addClass('disabled_input');
		
		$s_f->js( 'change' )->univ()
			->calculateRate();



		if($form->isSubmitted()){
			$all_items = $this->api->recall('xecommApp_cart',array());

			foreach ($this->cart_item as $junk) {
				$this->cart_item['qty']=$form['qty'];
				// $this->cart_item['sale_price']=$form['rate'];
			}

			$i=0;
			foreach ($all_items as $item) {
				if($item['id']==$this->cart_item['id']){
					$all_items[$i]=$this->cart_item;
					break;	
				}
				$i++;
			}
			
			$this->api->memorize('xecommApp_cart',$all_items);
		}

		parent::recursiveRender();
	}

	function defaultTemplate(){
		$l=$this->api->locate('addons',__NAMESPACE__, 'location');
		$this->api->pathfinder->addLocation(
			$this->api->locate('addons',__NAMESPACE__),
			array(
		  		'template'=>'templates',
		  		'css'=>'templates/css',
		  		'js'=>'templates/js'
				)
			)->setParent($l);

		return array('view/xecommApp-cartitem');
		
}
}	