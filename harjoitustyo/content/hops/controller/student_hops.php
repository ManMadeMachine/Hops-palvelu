<?php
someloader("some.application.controller");

class SomeControllerStudentHops extends SomeController{
	public function display() {
		$model = $this->getModel('default');
		$view = $this->getView('default');
		$view->setModel($model);
		$view->display();
	}

	public function listHops(){
	    //Listataan hopsit jotka on taytetty ja linkki mahdolliseen uuteen lomakepohjaan.
		$model = $this->getModel('hops');
		$model->listHops();
		$view = $this->getView('hops');
		$view->setModel($model);
		$view->display('list');
	}
	
	public function fillHops(){
	    //Hopsin täyttäminen
		$model = $this->getModel('hops');
		$model->doHopsForm();
		$view = $this->getView('hops');
		$view->setModel($model);
		$view->display('fill');
	}
	
	public function showFilled() {
	    //Täytetyn hopsin tarkastelu
	    $lukuvuosi = SomeRequest::getInt("lv", 0); 
	    $vuositaso = SomeRequest::getInt("vt", 0); 

	    $model = $this->getModel('hops');
	    $model->getFilled($lukuvuosi, $vuositaso);
	    
	    $view = $this->getView('hops');
	    $view->setModel($model);
	    $view->display('showFilled');
		
	}
	
	public function saveHops() {
	    //Hopslomakkeen tallennus
	    $model = $this->getModel('hops');
	    $model->saveHopsData();
	    
	    $app = SomeFactory::getApplication();
	    $app->redirect("index.php?app=hops&action=listHops");	    
	    
	}
	
	public function showCourses() {
	    // Käytyjen kurssien listaus
	    $model = $this->getModel('hops');
	    $model->listCourses();
	    $view = $this->getView('hops');
	    $view->setModel($model);
	    $view->display('listCourses');
	
	}
}
?>