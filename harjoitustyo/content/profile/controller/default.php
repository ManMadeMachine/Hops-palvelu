<?php
someloader('some.application.controller');

class SomeControllerDefault extends SomeController{
	public function display(){
	
	    $nro = SomeRequest::getInt("nro", 0); 
	    $type = SomeRequest::getString("type", 0);
		//Haetaan kirjautuneen tiedot (Model)
		$model = $this->getModel('profile');
		//Oletuksena haetaan kirjautuneen käyttäjän profiili
		$model->getProfile($nro, $type);
		//TODO: vaihda view:ks 'profile' ??
		$view = $this->getView('default');
		$view->setModel($model);
		$user = SomeFactory::getUser();
		
		//MikŠli tunnus (nro) annettiin, ulkopuolinen katselee profiilia
		if ( $nro != null)
		{
		    $role = $user->getUserrole();
		    
		    //MikŠli katsellaan opiskelijan profiilia, pitŠŠ olla joko opettaja tai ylituutori
		    if ( $type == "student" && ($role === SomeUser::ROLE_TEACHER || $role === SomeUser::ROLE_HEADTEACHER ))
		    {
		        $view->display('student');
		    }
		    //MikŠli katsellaan opettajan profiilia, pitŠŠ olla ylituutori
		    else if ( $type == "teacher" && $role === SomeUser::ROLE_HEADTEACHER)
		    {
		        $view->display('teacher');
		    }
		    else 
		    {
		        //$view->display('student');
		    }
		}
		//MikŠli numeroa ei annettu ja sisŠŠnkirjautuneena on opiskelija, nŠytetŠŠn opiskelijanŠkymŠ
		else if($user->getUserrole() === SomeUser::ROLE_STUDENT){
		    $view->display('student');
		}
		//Jos kirjautuneen oli opettaja, nŠytetŠŠn opettajan nŠkymŠ
		else if ( $user->getUserrole() === 'teacher' || $user->getUserrole() === 'headteacher' ){
		    $view->display('teacher');
		}
	}
	
	public function edit(){
		$nro = SomeRequest::getInt("nro", 0); 
		$type = SomeRequest::getString("type", 0); 
		
		$model = $this->getModel('profile');
		
		//!!!!
		$model->getProfile($nro, $type);
		
		
		$view = $this->getView('default');
		$view->setModel($model);
		
		$user = SomeFactory::getUser();
		$role = $user->getUserrole();

		//Muokataan jonkun muun profiilia
		if ($nro != 0 && $nro != $user->getUsername()){
		    //MikŠli kyseessŠ opiskelijan profiili, oltava opettaja tai ylituutori
		    if ($type === SomeUser::ROLE_STUDENT && ($role === SomeUser::ROLE_TEACHER || $role === SomeUser::ROLE_HEADTEACHER)){
		        $view->display('edit_student');
		    }
		    else if ($type === SomeUser::ROLE_TEACHER && $role === SomeUser::ROLE_HEADTEACHER){
		        $view->display('edit_teacher');
		    }
		}
		//Muokataan omaa, katsotaan onko kyseessŠ opettaja vai opiskelija
		else if ($role === SomeUser::ROLE_STUDENT){
		    $view->display('edit_student');
		}
		else if ($role === SomeUser::ROLE_TEACHER || $role === SomeUser::ROLE_HEADTEACHER){
			$view->display('edit_teacher');
		}
	}
	
	public function save(){
		$model = $this->getModel('profile');
		$url = $model->saveProfile();
		
		$app = SomeFactory::getApplication();
		
		//TODO: tarkista, onko nro 
		if ( $url === 0 ) {
		    echo "Virhe";
	    }
	    else 
	    {
	        $app->redirect($url);
	    }
	}
	
	//Luodaan uusi opettaja
	public function newTeacher(){
	    $model = $this->getModel('profile');
	    $view = $this->getView('new');
	    $view->setModel($model);
	    $view->display('teacher');
	}
	
	public function delete(){
	    //Varmistutaan vielŠ, ettŠ kŠyttŠjŠ on varmasti ylituutori
	    $user = SomeFactory::getUser();
	    
	    if ($user->getUserrole() === SomeUser::ROLE_HEADTEACHER){
	        //Oli, voidaan edetŠ poiston kanssa
	        $model = $this->getModel('profile');
	        $success = $model->delete();
	        
	        if ($success){
	            $app = SomeFactory::getApplication();
	            $app->redirect('index.php?app=hops&action=listPeople');
	        }
	    }
	    else{
	        echo "Sinulla ei ole kŠyttšoikeuksia poistoon!";
	    }
	}
}
?>