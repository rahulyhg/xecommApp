<?php
	
class page_xecommApp_page_owner_memberorder extends page_xecommApp_page_owner_main{

	function init(){
		parent::init();

		$this->add('View')->set('Member Order Grid');
	}
}