<?php

namespace xecommApp;

class View_PersonalInfo extends \View{
function init(){
	parent::init();

	$this->add('View_Info')->set("Name : ".$this->api->cu_name)->setStyle('text-transform','capitalize');
	$this->add('View_Info')->set("E-mail Id : ".$this->api->cu_emailid);

	}
}