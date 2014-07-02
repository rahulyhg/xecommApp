<?php

namespace xecommApp;

class View_Lister_Category extends \View{

	function setModel($model,$indent=1){
		parent::setModel($model);
		foreach ($ci_m=$this->model as $junk) {
			$ci = $this->add('xecommApp/View_Lister_CategoryItem');
			$ci->setElement('a')
				->setAttr('href','index.php?subpage=xecomm-dashboard&category_id='.$junk['id'])
				->set($junk['name']);

			foreach($sub_cats = $ci_m->ref('SubCategories') as $junk){
				$categories = $this->add('xecommApp/Model_Category');
				$categories->addCondition('id',$sub_cats->id);

				$sub_cats_view = $this->add('xecommApp/View_Lister_Category');
				$sub_cats_view->setModel($categories,$indent+1);
				$sub_cats_view->addStyle('padding-left',($indent*10).'px');
				$ci->js('click',$sub_cats_view->js()->toggle());
				$sub_cats_view->js(true)->hide();
			}
		}

		// $this->template->trySet('all',$this->api->url(null));
	}	

	// function formatRow(){
	// 	$this->current_row_html['url']=$this->api->url(null,array('subpage'=>'xecomm-dashboard','category_id'=>$this->model->id));
	// }

	
	function defaultTemplate(){
		$l=$this->api->locate('addons',__NAMESPACE__, 'location');
		$this->api->pathfinder->addLocation(
			$this->api->locate('addons',__NAMESPACE__),
			array(
		  		'template'=>'templates',
		  		'css'=>'templates/css',
		  		'js'=>'templates/js'
				)
			)->setParent($l);

		return array('view/xecommApp-categorylist');
	}

}