<?php
namespace XecommApp;

class Model_Category extends \Model_Table{
	var $table="xecomm_categories";
	var $table_alias = 'category';
	function init(){
		parent::init();
		$this->hasOne('xecommApp/ParentCategory','parent_id');

		$this->addField('name')->Caption('Category Name');
		$this->hasMany('xecommApp/Category','parent_id',null,'SubCategories');
		$this->hasMany('xecommApp/Product','category_id');

		$parent_join = $this->leftJoin('xecomm_categories','parent_id');

		$this->addExpression('category_name')->set('concat('.$this->table_alias.'.name,"- (",IF('.$parent_join->table_alias.'.name is null,"",'.$parent_join->table_alias.'.name),")")');

		// $this->add('dynamic_model/Controller_AutoCreator');
		// 
	}
}

