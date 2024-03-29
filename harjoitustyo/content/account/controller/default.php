<?php
/**
* This is controller file.
* @package content
* @subpackage account
*/
someloader('some.application.controller');
/**
* This is controller file.
* @package content
* @subpackage account
*/


class SomeControllerDefault extends SomeController {
	
	/**
	 * default flow function.
	 * if no view is set, register form is shown. If the user is not logged in.
	 *
	 */
	
	function display() {
		
		// if the user is logged in, then it is sort of wrong to show register form...
		$user = SomeFactory::getUser();
		if (!$user->getId()) {
			$view = SomeRequest::getVar('view','register');
			$model = $this->getModel($view);
			$view = $this->getView($view);
			$tmpl = SomeRequest::getVar('tmpl','default');
			$view->setModel($model);
			$view->display($tmpl);
		} else {
			// change to login view. Do http redirect.
			$app = SomeFactory::getApplication();
			$app->redirect('index.php?app=login');
		}
	}
	

	#
	#
	# name of the methods must be values from url parameter view, like ?app=user&view=register
	#
	#
	
	#
	# this is an example of method, that is called if url is http://....?view=register.
	# the value of the view parameter maps to method name
	#
	public function register() {
       //nimeämiskäytäntö! model/register.php and SomeModelRegister must exist.
       $model = $this->getModel('register');
       $username = SomeRequest::getVar('tunnus',null);
       //jos username on olemassa, käyttäjältä tulee lomake, yritä käsitellä se
       if ($username) {
         $success = $model->dotask(); // paluu arvo voi kertoa onnistumisesta tai epäonnistumisesta.
         if ($success) {
            /*$view = $this->getView('register'); // eli view/register/register.php pitää löytyä
           $view->setModel($model);
           $view->display('succesful'); // eli view/register/tmpl/successful.php tiedosto pitää löytyä*/
           $app = SomeFactory::getApplication();
           $app->redirect('index.php?app=hops&action=listPeople');
         }
         else
         {
            echo "Virhe: " . print_r($model->getErrors());
         }
         /*else {
           //failed, no valid data?
           $view = $this->getView('register'); // eli view/register/register.php pitää löytyä
           $view->setModel($model);
           $view->display('form'); // eli view/register/tmpl/form.php tiedosto pitää löytyä
        } */
      }
      else{
        echo "Tarkista tiedot ja yritä uudestaan!";
      }
      /*else {
        //ei ole lomakkeen lähetys, näytä lomake
        $view = $this->getView('register'); // eli view/register/register.php pitää löytyä
        $view->setModel($model);
        $view->display('form'); // eli view/register/tmpl/form.php tiedosto pitää löytyä
      }*/
    }
}

?>
