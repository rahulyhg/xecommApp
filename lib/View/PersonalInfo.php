<?php

namespace xecommApp;

class View_PersonalInfo extends \View{
function init(){
	parent::init();

	$this->add('View_Info')->set('Personal Info');

	}
}