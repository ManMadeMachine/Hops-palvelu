<?php
someloader('some.application.model');

class SomeModelHeadteacher extends SomeModel{
    public function __construct(array $options=array()){
		parent::__construct($options);
	}
	
    private $teachers;
    private $groups;
    private $students;
    private $attended;
	
	//Listataan kaikki opiskelijat
	public function listStudents(){
	    $user = SomeFactory::getUser();
	    $db = SomeFactory::getDBO();
		$stmt = null;
	    
	    //Jos käyttäjä on kirjautunut ja on ylituutori
	    if ($user->getId() && $user->getUserrole() === SomeUser::ROLE_HEADTEACHER)
	    {
	        //Kysely
			$stmt = $db->prepare("SELECT o.opnro, o.etunimi, o.sukunimi, o.hopsryhma, o.avuosi FROM opiskelija as o");
		    $ok = $stmt->execute();
		    
		    if ($ok) {
                $i = 0;
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    $this->students[$i++] = $row;
                }
			}
		}
	    else
	    {
	        echo "You do not have permission!!!!";
	    } 
	}
	
	//Palautetaan opiskelijatiedot
	public function getStudents() {
	    return $this->students;
	}
	
	//Listataan kaikki hopsryhmat
	public function listHopsGroups()
	{
	    $user = SomeFactory::getUser();
	    $db = SomeFactory::getDBO();
		$stmt = null;
	    
	    if ($user->getId() && $user->getUserrole() === 'headteacher')
	    {
	        //Kysely
			$stmt = $db->prepare("SELECT hr.tunnus, hr.tuutori FROM hops_ryhma as hr");
		    $ok = $stmt->execute();
		
		    $i = 0;
		    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			    $this->groups[$i++] = $row;
			}
		}
	    else
	    {
	        echo "You do not have permission!!!!";
	    } 
	}
	
	public function getGroups() {
	    return $this->groups;
	}
	
	//Listataan kaikki tuutorit (paitsi ylituutori itse)
	public function listHopsTeachers() {
	
	    $user = SomeFactory::getUser();
	    $db = SomeFactory::getDBO();
		$stmt = null;
	    
	    if ($user->getId() && $user->getUserrole() === 'headteacher')
	    {
	        //Kysely
			$stmt = $db->prepare("SELECT t.tunnus, t.etunimi, t.sukunimi FROM tuutori as t WHERE tyyppi != 'Ylituutori'");
		    $ok = $stmt->execute();
		
		    if ($ok)
		    {
		        $i = 0;
		        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			        $this->teachers[$i++] = $row;
			    }
		    }
		    
		}
	    else
	    {
	        echo "You do not have permission!!!!";
	    } 
	    
	}
	
	public function getHopsTeachers() {
	    return $this->teachers;
	}
	
	//Lasketaan kuinka monta opiskelijaa jokaisessa ryhmassa on.
	public function countStudents() {
	    $user = SomeFactory::getUser();
	    $db = SomeFactory::getDBO();
		$stmt = null;
	    
	    if ($user->getId() && $user->getUserrole() === 'headteacher')
	    {
			$stmt = $db->prepare("SELECT COUNT(o.opnro) as oplkm, hr.tunnus, hr.tuutori FROM hops_ryhma as hr JOIN opiskelija as o ON o.hopsryhma = hr.tunnus GROUP BY hr.tunnus");
		    $ok = $stmt->execute();
		
		    if ($ok)
		    {
		        $i = 0;
		        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			        $this->data[$i++] = $row;
			    }
		    }  
		}
	    else
	    {
	        echo "You do not have permission!!!!";
	    } 
	
	}
	
	//Tallennetaan allokoitujen opiskelijoiden tiedot.
	public function saveAllocated(){
	    $tiedot = $_POST;
	    
	    $user = SomeFactory::getUser();
	    $db = SomeFactory::getDBO();
		$stmt = null;
	    
	    if ($user->getId() && $user->getUserrole() === 'headteacher')
	    {
	        //Luodaan saatujen tietojen perusteella
	        $op_nrot;
	        foreach($tiedot as $k => $v){
	            $nro = explode("_", $k);
	            if ($v != ' '){
	                $op_nrot[$nro[0]] = $v;
	            
	            }
	        }
			if ( $op_nrot != null )
			{
			    foreach($op_nrot as $k => $v){
			    $stmt = $db->prepare("UPDATE opiskelija SET hopsryhma=? WHERE opnro=?");
		        $ok = $stmt->execute(array($v, $k));
                }
		
                if ($ok)
                {
                    $app = SomeFactory::getApplication();
                   $app->redirect('index.php?app=hops&action=listPeople');
               
                }
                else{
                    echo "Virhe päivityksessä.";
                }
			}
			else 
			{
			    $app = SomeFactory::getApplication();
                $app->redirect('index.php?app=hops&action=allocateStudents');   
			}
			
		}
	    else
	    {
	        echo "You do not have permission!!!!";
	    } 
	    
	}
	
	//Lasketaan kuinka monta hopsia palautettiin missäkin ryhmässä ensimmäisenä vuotena.. Ts. lasketaan ryhmän alkuperäiskoko.
	public static function countReturned()
	{
	    $user = SomeFactory::getUser();
	    $db = SomeFactory::getDBO();
		$stmt = null;
		$returned_hops = null;
	    
	    if ($user->getId() && ($user->getUserrole() === 'teacher' || $user->getUserrole() === 'headteacher'))
	    {
	        //Lasketaan kuinka monta hopsia palautettiin missäkin ryhmässä ensimmäisenä vuotena..
			$stmt = $db->prepare("SELECT COUNT(o.opnro) palautetut, hr.tunnus FROM opiskelija as o JOIN hops_ryhma as hr ON o.hopsryhma = hr.tunnus JOIN hops_lomake as hl ON hl.opnro = o.opnro WHERE hl.vuositaso = 1 GROUP BY hr.tunnus;");
		    $ok = $stmt->execute();
		
		    if ($ok)
		    {
		        $i = 0;
		        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			        $returned_hops[$i++] = $row;
			    }
			    
			    return $returned_hops;
		    }  
		}
	    else
	    {
	        echo "You do not have permission!!!!";
	    } 
	
	}
	
	public function returnCount()
	{
	    return $this->returned_hops;
	}
	
	
	//Lasketaan kuinka monta opiskelijaa viimeisenä vuonna tapaamiseen ts. lasketaan loppukoko.
	public function countAttended() 
	{
	    
	    $user = SomeFactory::getUser();
	    $db = SomeFactory::getDBO();
		$stmt = null;
	    
	    if ($user->getId() && $user->getUserrole() === 'headteacher')
	    {
	        //Lasketaan kuinka monta opiskelijaa osallistui 
			$stmt = $db->prepare("SELECT COUNT(o.opnro) as osallistuneet, hr.tunnus FROM opiskelija as o JOIN hops_ryhma as hr ON o.hopsryhma = hr.tunnus JOIN osallistuu as os ON o.opnro = os.opnro WHERE os.tunnus=9 GROUP BY hr.tunnus");
		    $ok = $stmt->execute();
		
		    if ($ok)
		    {
		        $i = 0;
		        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			        $this->attended[$i++] = $row;
			    }
		    }  
		}
	    else
	    {
	        echo "You do not have permission!!!!";
	    } 
	
	}
	
	public function getAttended()
	{
	    return $this->attended;
	}
	
	//Listataan kaikkien tuutoreiden lähettämät loppuraportit yhteen raporttiin.
	public function listEndReports() 
	{
        $user = SomeFactory::getUser();
	    $db = SomeFactory::getDBO();
		$stmt = null;
	    
	    if ($user->getId() && $user->getUserrole() === 'headteacher')
	    {
	        //Lasketaan kuinka monta opiskelijaa osallistui 
			$stmt = $db->prepare("SELECT t.etunimi, t.sukunimi, r.tuutori, r.hopsryhma, r.alkup_koko, r.palautetut, r.osallistuneet_ryhma, r.osallistuneet_yks, r.tavoittamattomat, r.poisjaaneet, r.i, r.ii, r.iii, r.iv, r.v
			                    FROM tuutori as t JOIN loppuraportit as r ON t.tunnus = r.tuutori");
		    $ok = $stmt->execute();
		
		    if ($ok)
		    {
		        $i = 0;
		        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			        $this->data[$i++] = $row;
			    }
		    }  
		}
	    else
	    {
	        echo "You do not have permission!!!!";
	    } 
	}
	
	//Listataan kaikkien kolmannen vuoden opiskelijoiden sähköpostiosoitteet.
	public function listEmails() 
	{
	    $user = SomeFactory::getUser();
	    $db = SomeFactory::getDBO();
		$stmt = null;
		$startyear = $this->getStartingYear(3);
	    
	    if ($user->getId() && $user->getUserrole() === 'headteacher')
	    {
	        //Lasketaan kuinka monta opiskelijaa osallistui 
			$stmt = $db->prepare("SELECT o.etunimi, o.sukunimi, o.sposti, o.hopsryhma FROM opiskelija as o WHERE avuosi = ? ORDER BY o.hopsryhma");
		    $ok = $stmt->execute(array($startyear));
		
		    if ($ok)
		    {
		        $i = 0;
		        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			        $this->data[$i++] = $row;
			    }
		    }  
		}
	    else
	    {
	        echo "You do not have permission!!!!";
	    }
	}
	
	//Lasketaan parametrin avulla minä vuonna opiskelija on aloittanut opintonsa. Esim parametri kolme laskee nykyisen vuoden avulla että kolmannen vuoden opiskelijat aloittivat opintonsa 2012.
	public function getStartingYear($i) {
	    $startYear = 0;
	    $curr = date("Y-m-d");
	    $august = date("Y-08-01");
	    $january = date("Y-01-01");
	    
	    if ( $curr < $august && $curr > $january){
	        $startYear = date("Y") - $i;
	    }
	    else
	    {
	        $startYear = date("Y") - $i + 1;
	    }
	    
	    return $startYear;	
	}
	
	public function create(){
	    //Tarkistetaan, ollaanko ylituutori
	    $user = SomeFactory::getUser();
	    
	    if ($user->getUserrole() === SomeUser::ROLE_HEADTEACHER){
	        //Ollaan. Halutaan luoda uusi ryhmä.
	        //Haetaan oleelliset muuttujat post-variablesta
	        
	        //uuden ryhmän tunnus
	        $ryhma_tunnus = SomeRequest::getVar('tunnus', '');
	        
	        //Ryhmän tuutorin tunnus
	        $tuutori_tunnus = SomeRequest::getVar('tuutori_tunnus', '');
	        
	        if(!empty($ryhma_tunnus) && !empty($tuutori_tunnus)){
	            //Saatiin jotain, luodaan uusi ryhmä
	            $db = SomeFactory::getDBO();
	            $stmt = $db->prepare("INSERT INTO hops_ryhma VALUES(?,?)");
	            
	            $ok = $stmt->execute(array($ryhma_tunnus, $tuutori_tunnus));
	            
	            if($ok){
	                return true;
	            }
	            else{
	                return false;
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