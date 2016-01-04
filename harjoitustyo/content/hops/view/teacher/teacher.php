<?php
someloader('some.application.view');

class SomeViewTeacher extends SomeView{

    public function getStartingYear($i) {
        $model = $this->getModel();
        return $model->getStartingYear($i);
    }

    public function display($tmpl = 'default'){
		$model = $this->getModel();
		//Päätellään, mitä tietoa halutaan mallilta hakea
		$this->data = $model->data;
		parent::display($tmpl);
	}
}
?>