<?php
someloader('some.application.view');

class SomeViewDefault extends SomeView{
	public function countPoints($tunnus) {
	    $model = $this->getModel();
	    return $model->countPoints($tunnus);
	}
	
	public function display($tmpl=null){
		$model = $this->getModel();
		$this->data = $model->data;
		parent::display($tmpl);
	}
}
?>