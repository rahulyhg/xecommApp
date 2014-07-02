<?php
namespace XecommApp;

class Model_Category extends \Model_Table{
	var $table="xecomm_categories";

	function init(){
		parent::init();
		$this->hasOne('xecommApp/ParentCategory','parent_id');

		$this->addField('name')->Caption('Category Name');
		$this->hasMany('xecommApp/Category','parent_id',null,'SubCategories');
		$this->hasMany('xecommApp/Product','category_id');
		// $this->add('dynamic_model/Controller_AutoCreator');
	}
}

