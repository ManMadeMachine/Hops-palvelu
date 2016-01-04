<?php
/**
* @package content
* @subpackage account
*/
someloader('some.application.model');

/**
* @package content
* @subpackage account
*/

class SomeModelRegister extends SomeModel {

    protected $userdata = array();
    protected $errors   = array();
    

	public function __construct(array $options=array()) {
		parent::__construct($options);
	}
	
	public function isSubmit() {
	    $issubmit = SomeRequest::getVar('username',0);
	    return $issubmit;
	}
	
	public function dotask() {
	    //so far it is only register task
	    $valid = $this->validate();
	    if (!$valid) {
	        return false;
	    }
	    //else it is valid, and we can create it
	    return $this->create();
	}
	
	public function validate() {
	    $username  = SomeRequest::getVar('tunnus' , '');
	    $fname = SomeRequest::getVar('etunimi' , '');
	    $lname = SomeRequest::getVar('sukunimi' , '');
	    $unit = SomeRequest::getVar('yksikko' , '');
	    $phone = SomeRequest::getVar('puh' , '');
  	    $password  = SomeRequest::getVar('salasana', '');
  	   	$email     = SomeRequest::getVar('sposti', '');
  	   	
  	   	// set errors to this->errors
  	   	// user form input fields name as $this->errors key:
  	   	//  $this->errors['username'] = "Username is not valid because...";
	    if (! preg_match('#^[a-z0-9_-]{3,24}$#i',$username) || empty($username) ) {
  	   	    $this->errors['username'] = 'Not a valid Username';
  	   	} else {
  	   	    $this->userdata['username'] = $username;
  	   	}
		
  	   	if (! preg_match('#^.+$#i',$email) || empty($email)) {
  	   	    $this->errors['email'] = 'Not a valid Email address';
  	   	} else {
  	   	   $this->userdata['email'] = $email;
  	   	}
  	   	
  	   	if (! preg_match('#^.{3,}$#i',$password) || empty($password)) {
  	   	    $this->errors['password'] = 'Not a valid Password';
  	   	} else {
  	   	   $this->userdata['password'] = $password;
  	   	}
  	   	
  	   	if (empty($fname) || empty($lname) || empty($unit) || empty($phone)){
  	   	    $this->errors['other'] = 'Jotain meni pieleen!!';
  	   	}
  	   	
  	   	// if one or more error were added, then we must return boolean false
  	   	return count($this->errors) == 0;
	}
	
	/**
	 * @return true if user is created, false if not.
	 */
	public function create() {
	    $user = SomeFactory::getUser();
        if ($user->getUserrole() === SomeUser::ROLE_HEADTEACHER){
            someloader('some.user.user');
            $someuser = new SomeUser();
            $this->userdata = array(
                'username'  => SomeRequest::getVar('tunnus' , ''),
                'fname' => SomeRequest::getVar('etunimi', ''),
                'lname' => SomeRequest::getVar('sukunimi', ''),
                'unit' => SomeRequest::getVar('yksikko', ''),
                'email' => SomeRequest::getVar('sposti', ''),
                'phone' => SomeRequest::getVar('puh', ''),
                'password'  => SomeRequest::getVar('salasana' , ''),
            );
        
            $someuser->setUsername($this->userdata['username']);
        
            // DO THE PASSWORD HASHING HERE
            $someuser->setPassword($this->userdata['password']);
            $someuser->setUserrole('teacher');
            $this->userdata['userrole'] = $someuser->getUserrole();
        
            $someuser->create();
        
            //Yritetään lisäksi tehdä uusi tuutori

            $db = SomeFactory::getDBO();
            
            $stmt = $db->prepare("INSERT INTO tuutori VALUES(?, ?, ?, ?, ?, ?, 'Tuutori')");
            $ok = $stmt->execute(array($this->userdata['username'], $this->userdata['fname'], $this->userdata['lname'], $this->userdata['email'], $this->userdata['phone'], $this->userdata['unit']));
        
            if ($someuser->getId() > 0 && $ok > 0) {
                $this->userdata['id'] = $someuser->getId();
                return true;
            } else {
                return false;
            }
        
        }
	}
	
	
	public function getUserdata() {
	    return $this->userdata;
	}

	public function getErrors() {
	    return $this->errors;
	}
}

?>