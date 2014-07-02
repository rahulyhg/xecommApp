<?php
namespace xecommApp;
class Model_SpecialProducts extends Model_Product{
	function init(){
		parent::init();

		$this->addCondition('is_special',true);

	}
}