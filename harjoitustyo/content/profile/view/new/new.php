<?php
someloader('some.application.view');

class SomeViewNew extends SomeView{
	public function display($tmpl=null){
		$model = $this->getModel();
		$this->data = $model->data;
		parent::display($tmpl);
	}
}
?>