<?php

namespace xecommApp;

class View_AddNewAddress extends \View{
function init(){
	parent::init();

	$this->add('View_Info')->set('Add new address');
	
	}
}