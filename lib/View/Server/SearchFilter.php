<?php

namespace xecommApp;

class View_Server_SearchFilter extends \View{
	function init(){
		parent::init();
		
		$form = $this->add('Form');
		$element = $form->add('HtmlElement');
		$slider = $form->addField('Slider','sl','Price Range');
		$slider->getInput(array('min'=>100,'max'=>1000,'step'=>1000));
		$s='#'.$slider->name.'_slider';

		$this->js(true)->_selector($s)->bind('slide',$element->js()->_enclose()->html(
		$this->js()->_selector($s)->slider('value')	
			));

	}
}