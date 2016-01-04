<?php
someloader('some.application.view');

class SomeViewHops extends SomeView{
        
    public function getFormdata() {
        $model = $this->getModel();
        return $model->getFormData();
    }
    
    public function getHopsData($lukuvuosi, $vuositaso) {
        $model = $this->getModel();
        return $model->getHopsData($lukuvuosi, $vuositaso);
    }
    
    public function getYear() {
        $model = $this->getModel();
        return $model->getYear();
    }
    
    public function getCourseData($year) {
        $model = $this->getModel();
        return $model->getCourseData($year);
    }

	public function display($tmpl = 'default'){
		$model = $this->getModel();
		//Päätellään, mitä tietoa halutaan mallilta hakea
		$this->data = $model->getData();
		//$this->formdata = $model->getFormData();
		parent::display($tmpl);

	}
}
?>