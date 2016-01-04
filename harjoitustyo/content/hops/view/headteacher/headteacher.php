<?php
someloader('some.application.view');

class SomeViewHeadteacher extends SomeView{

    //TARVIIKO???
    public function getStartingYear($i) {
        $model = $this->getModel();
        return $model->getStartingYear($i);
    }
    
    public function getTeachers() {
        $model = $this->getModel();
        return $model->getHopsTeachers();
    }
    
    public function getGroups() {
        $model = $this->getModel();
        return $model->getGroups();
    }
    
    public function getStudents() {
        $model = $this->getModel();
        return $model->getStudents();
    }
    
    public function countAttended() {
        $model = $this->getModel();
        return $model->getAttended();
    }

    public function display($tmpl = 'default'){
		$model = $this->getModel();
		//Päätellään, mitä tietoa halutaan mallilta hakea
		$this->data = $model->data;
		parent::display($tmpl);
	}
}
?>