<?php
namespace xecommApp;
class Model_FeatureProducts extends Model_Product{
	function init(){
		parent::init();


		$this->addCondition('is_publish',true);
		$this->addCondition('is_featured',true);

	}
}