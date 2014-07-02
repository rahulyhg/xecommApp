<?php

namespace xecommApp;

class View_Server_Search extends \View{
	function init(){
		parent::init();
		$this->add("xecommApp/View_ProductSearch");
	}
}