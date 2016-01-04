<?php
someloader('some.application.controller');

class SomeControllerHeadteacherHops extends SomeController{
    public function display() {
		$model = $this->getModel('default');
		$view = $this->getView('default');
		$view->setModel($model);
		$view->display();
	}
	
	
	public function reports(){
	    //Listataan raportit (omat ja muiden tuutoreiden tekemät)
	    $model = $this->getModel('headteacher');
        $view = $this->getView('headteacher');
        $view->setModel($model);
        $view->display('reports');
	}
	
	public function studentCount() {
	    //Lasketaan kuinka monta tuutoroitavaa kullakin opettajalla on
	    $model = $this->getModel('headteacher');
	    $model->listHopsTeachers();
	    $model->countStudents();
        $view = $this->getView('headteacher');
        $view->setModel($model);
        $view->display('studentcount');	
	}
	
	public function groupSuccess() {
	    //Ryhmän koossa pysymisen tarkistus
	    $model = $this->getModel('headteacher');
	    $model->listHopsGroups();
	    $model->countReturned();
	    $model->countAttended();
        $view = $this->getView('headteacher');
        $view->setModel($model);
        $view->display('groupsuccess');
	}
	
	public function listPeople(){
	    //Listataan tuutorit ja heidän ryhmänsä opiskelijoineen. Listataan myös opiskelijat joilla ei ole ryhmää
	    $model = $this->getModel('headteacher');
	    $model->listHopsTeachers();
	    $model->listStudents();
	    $model->listHopsGroups();
        $view = $this->getView('headteacher');
        $view->setModel($model);
        $view->display('list');
	}
	
	public function allocateStudents() {
	    //Allokoidaan opiskelijoita ryhmiin.
	    $model = $this->getModel('headteacher');
	    $model->listHopsGroups();
	    $model->listStudents();
        $view = $this->getView('headteacher');
        $view->setModel($model);
        $view->display('allocation');
	
	}
	public function saveAllocated(){
	    //Tallennetaan allokoinnin aiheuttamat muutokset.
	    $model = $this->getModel('headteacher');
	    $model->saveAllocated();
	    $app = SomeFactory::getApplication();
	}
	
	public function endReports() {
	    //Kaikkien loppuraporttien kooste
        $model = $this->getModel('headteacher');
	    $model->listEndReports();
        $view = $this->getView('headteacher');
        $view->setModel($model);
        $view->display('listEndReports');
	}
	
	public function emailList() {
	    //Kaikkien kolmannen vuoden opiskelijoiden sähköpostiosoitteet.
        $model = $this->getModel('headteacher');
	    $model->listEmails();
        $view = $this->getView('headteacher');
        $view->setModel($model);
        $view->display('listEmails');
	}
	
	public function addGroup() {
	    //Uuden ryhmän luonti
	    $model = $this->getModel('headteacher');
	    $model->listHopsTeachers();
        $view = $this->getView('headteacher');
        $view->setModel($model);
        $view->display('newGroup');
	}
	
	public function saveNewGroup(){
	    $model = $this->getModel('headteacher');
	    $ok = $model->create();
	    if ($ok)
	    {
	        $app = SomeFactory::getApplication();
	        $app->redirect("index.php?app=hops&action=listPeople");
	    }
	    else
	    {
	        echo "Virhe ryhmän luonnissa!";
	    }
	}
}
?>