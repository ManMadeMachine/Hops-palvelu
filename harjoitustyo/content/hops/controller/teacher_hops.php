<?php
someloader('some.application.controller');

class SomeControllerTeacherHops extends SomeController{
    public function display() {
		$model = $this->getModel('default');
		$view = $this->getView('default');
		$view->setModel($model);
		$view->display();
	}
	
	public function listGroups(){
	    //Listaa hops-ryhmät ja niiden opiskelijat
	    $model = $this->getModel('hopsGroups');
	    $model->listHopsGroups();
	    $view = $this->getView('teacher');
	    $view->setModel($model);
	    $view->display('listGroups');
	}
	
	public function reports(){
	    //listaa tehtävät raportit
	    $model = $this->getModel('hopsGroups');
	    $model->listReports();
        $view = $this->getView('teacher');
        $view->setModel($model);
        $view->display('reports');
	}
	
	public function listEmails() {
	    //Listaa kolmannen vuoden opiskelijoiden sähköpostiosoitteet
	    $model = $this->getModel('hopsGroups');
	    $model->listEmails();
	    $view = $this->getView('teacher');
	    $view->setModel($model);
	    $view->display('emails');
	}
	
	public function endOfYear() {
	    //Muodostetaan loppuraportti
	    $model = $this->getModel('hopsGroups');
	    $model->doEndReport();
	    $view = $this->getView('teacher');
	    $view->setModel($model);
	    $view->display('endreport');
	
	}
	
	public function saveEndForm() {
	    //Tallennetaan loppuraportti ja 'lähetetään'
	    $model = $this->getModel('hopsGroups');
	    $model->saveEndForm();
        $view = $this->getView('teacher');
	    $view->setModel($model);
	    $view->display('reports'); 
	}
	
}
?>