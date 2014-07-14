<?php
namespace xecommApp;
class Model_MostViewedProducts extends Model_Product{
	function init(){
		parent::init();

		$this->addCondition('is_publish',true);
		$this->addCondition('is_mostviewed',true);

	}
}