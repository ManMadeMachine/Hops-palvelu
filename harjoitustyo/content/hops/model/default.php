<?php

someloader('some.application.model');

class SomeModelDefault extends SomeModel{
	
	//Haetaan kirjautuneen ihmisen nimitiedot käyttäjätunnuksen perusteella
	public function getNameData() {
	    
	    $namedata;
		$user = SomeFactory::getUser();
		$db = SomeFactory::getDBO();
        $stmt = null;
	    
	    //Jos kirjautunut ja opiskelija
	    if ($user->getId() && $user->getUserrole() === 'student')
	    {
	        $statement = $db->prepare("SELECT etunimi, sukunimi FROM opiskelija WHERE opnro=?");
            $ok = $statement->execute(array($user->getUsername()));

		    if ($ok){
		        $namedata =  $statement->fetch(PDO::FETCH_ASSOC);  
		    }
	    }
	    //Jos kirjautunut ja tuutori tai ylituutori
	    else if ($user->getId() && $user->getUserrole() === 'teacher' || $user->getId() && $user->getUserrole() === 'headteacher')
	    {
	        $statement = $db->prepare("SELECT etunimi, sukunimi FROM tuutori WHERE tunnus=?");
            $ok = $statement->execute(array($user->getUsername()));

		    if ($ok){
		        $namedata =  $statement->fetch(PDO::FETCH_ASSOC);  
		    }
	    }
	    else
	    {
	        echo "You do not have permission!!!!";
	    } 
	    
	    return $namedata;
	
	}
}
?>