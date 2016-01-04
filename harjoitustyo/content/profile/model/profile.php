<?php
someloader('some.application.model');

/*
	PROFIILI -liit�nn�isen oletusmalli.
*/
class SomeModelProfile extends SomeModel{
	public function getProfile($nro, $type){
		//TODO: hae kaikki halutulla tunnuksella
		$user = SomeFactory::getUser();
		$db = SomeFactory::getDBO();
		$stmt = null;
		
		$role = $user->getUserrole();
        $tunnus = $user->getUsername();

		//Katsotaan muitten tietoja
		if ($nro != 0){
		    if ($type === SomeUser::ROLE_STUDENT && ($role === SomeUser::ROLE_STUDENT || $role === SomeUser::ROLE_TEACHER || $role === SomeUser::ROLE_HEADTEACHER)){
		        $stmt = $db->prepare("SELECT * FROM opiskelija WHERE opnro = $nro");
		    }
		    else if ($type === SomeUser::ROLE_TEACHER && ($role === SomeUser::ROLE_TEACHER || $role === SomeUser::ROLE_HEADTEACHER)){
		        $stmt = $db->prepare("SELECT * FROM tuutori WHERE tunnus = $nro");
		    }
		}
		else if($role == SomeUser::ROLE_STUDENT){
		    $stmt = $db->prepare("SELECT * FROM opiskelija WHERE opnro = $tunnus");
		}
		else if($role === SomeUser::ROLE_TEACHER || $role === SomeUser::ROLE_HEADTEACHER){
		    $stmt = $db->prepare("SELECT * FROM tuutori WHERE tunnus = $tunnus");
		}
		
		$ok = $stmt->execute();
		
		if ($ok){
			$this->data = $stmt->fetch(PDO::FETCH_ASSOC);
		}
	}
	
	//Lasketaan kuinka monta opintopistett� opiskelijalla on.
	public function countPoints($tunnus) {
	    $pointdata;
	    $user = SomeFactory::getUser();
		$db = SomeFactory::getDBO();
		$stmt = null;
		
		if ($user->getUserrole() === 'student'){
			//Haetaan opiskelijan tiedot
			$stmt = $db->prepare("SELECT SUM(k.op) as opintopisteet FROM kurssi as k JOIN on_suorittanut as os ON k.tunnus = os.tunnus WHERE os.opnro=?");
			$ok = $stmt->execute(array($user->getUsername()));
			
			if ($ok){
			    $pointdata = $stmt->fetch(PDO::FETCH_ASSOC);
		    }

		}
		else if ( $user->getUserrole() === 'teacher' || $user->getUserrole() === 'headteacher') {
		    $stmt = $db->prepare("SELECT SUM(k.op) as opintopisteet FROM kurssi as k JOIN on_suorittanut as os ON k.tunnus = os.tunnus WHERE os.opnro=?");
			$ok = $stmt->execute(array($tunnus));
			if ($ok){
			    $pointdata = $stmt->fetch(PDO::FETCH_ASSOC);
		    }
		}
		
		return $pointdata;	
	}
	
	//Tallennetaan profiilin tiedot.
	public function saveProfile(){
	
		$data = $_POST;
		
		//Tunnus, kenen tietoja tallennetaan
		$nro = $data['nro'];
		
		//Onko kyseess� opettajan vai opiskelijan tiedot
		$type = $data['type'];
		
		$user = SomeFactory::getUser();
		$role = $user->getUserrole();
		
		$db = SomeFactory::getDBO();
		$stmt = null;
		
		$ret;
		//Mik�li kyseess� on oma (kirjautuneen k�ytt�j�n) profiili...
		if ($nro === $user->getUsername()){
		
		    if ($type === SomeUser::ROLE_STUDENT){
		        //Opiskelija p�ivitt�� omia tietojaan
		        $stmt = $db->prepare("UPDATE opiskelija SET osoite=?, sposti=?, puh=? WHERE opnro=?");
			    $ok = $stmt->execute(array($data['osoite'], $data['sposti'], $data['puh'], $user->getUsername()));
		    }
		    else if ($type === SomeUser::ROLE_TEACHER){
		        $stmt = $db->prepare("UPDATE tuutori SET sposti=?, puh=? WHERE tunnus=?");
			    $ok = $stmt->execute(array($data['sposti'], $data['puh'], $user->getUsername()));
		    }
		    else{
		        //Tapahtui virhe
		        return 0;
		    }
		    
		    $ret = "index.php?app=profile";
		}
		else{
		    //Kyseess� jonkun muun profiili, tarkistetaan oikeudet.
		    //Mik�li kyseess� opiskelijan profiili
		    if ($type === SomeUser::ROLE_STUDENT && ($role === SomeUser::ROLE_TEACHER || $role === SomeUser::ROLE_HEADTEACHER)){
		        $stmt = $db->prepare("UPDATE opiskelija SET osoite=?, sposti=?, puh=? WHERE opnro=?");
			    $ok = $stmt->execute(array($data['osoite'], $data['sposti'], $data['puh'], $nro));
		    }
		    else if ($type === SomeUser::ROLE_TEACHER && $role === SomeUser::ROLE_HEADTEACHER){
		        $stmt = $db->prepare("UPDATE tuutori SET sposti=?, puh=? WHERE tunnus=?");
			    $ok = $stmt->execute(array($data['sposti'], $data['puh'], $nro));
		    }
		    else{
		        return 0;
		    }
		    
		    $ret = "index.php?app=profile&action=getProfile&nro=" . $nro . "&type=" . $type;
		}
		
		if ($ok){
			$this->data = $stmt->fetch(PDO::FETCH_ASSOC);
		}
		
		return $ret;
	}
	
	public function delete(){
	    //Viel� kerran varmistus k�ytt�j�n oikeuksista
	    $user = SomeFactory::getUser();
	    
	    if ($user->getUserrole() === SomeUser::ROLE_HEADTEACHER){
	        //On oikeudet. Poistetaan ensin k�ytt�j� someuser-taulusta
	        $someuser = new SomeUser();
	        
	        $tunnus = SomeRequest::getVar('tunnus', '');
	        
	        $db = SomeFactory::getDBO();
	        
	        $stmt = $db->prepare("SELECT id FROM someuser WHERE username=?");
	        $ok = $stmt->execute(array($tunnus));
	        
	        $id = $stmt->fetch(PDO::FETCH_ASSOC);
	        
	        if ($id){
	            //Saatiin id, voidaan poistaa k�ytt�j�
	            $someuser->setId($id['id']);
	            $ryhmat;
	            
	            $stmt = $db->prepare("SELECT tunnus FROM hops_ryhma WHERE tuutori = ?");
	            $ok = $stmt->execute(array($tunnus));
	            
	            if ( $ok )
	            {
	                $i = 0;
		            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			            $ryhmat[$i++] = $row;
			        }
	            }
	            
	            var_dump($ryhmat);
	            
	            $i = 0;
	            
	            if ($ryhmat != null)
	            {
	                foreach ($ryhmat as $ryhma)
	                {
	                    $stmt = $db->prepare("UPDATE opiskelija SET hopsryhma = null WHERE hopsryhma = ?");
	                    $ok = $stmt->execute(array($ryhma['tunnus']));
	                    
                        $stmt = $db->prepare("DELETE FROM hops_ryhma WHERE tunnus = ?");
	                    $ok = $stmt->execute(array($ryhma['tunnus']));
	                        
	                    if ($ok)
	                    {
	                        echo "Ryhm�n poisto onnistui";
	                    }
	                }
	            }
	            
	            //Poistetaan my�s itse tuutori omasta taulustaan
	            $stmt = $db->prepare("DELETE FROM tuutori WHERE tunnus=?");
	            $ok = $stmt->execute(array($tunnus));
	            

	            if ($ok){
	            	$someuser->delete();
	                return true;
	            }
	        }
	        else{
	            return false;
	        }
	    }
	    else{
	        return false;
	    }
	}

}
?>