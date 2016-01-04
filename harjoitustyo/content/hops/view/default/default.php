<?php

someloader('some.application.view');

class SomeViewDefault extends SomeView{

	public function getNameData() {
	    $model = $this->getModel();
	    return $model->getNameData();
	}
	
	public function display($tmpl=null){
		$model = $this->getModel();

		parent::display($tmpl);
	}
}
?>