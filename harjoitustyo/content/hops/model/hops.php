<?php
someloader('some.application.model');

//TODO: olisko käyttöö? 
//TODO: olisko käyttöö vastaaville, esim. Opiskelija tms?? Profiili?

class SomeModelHops extends SomeModel{
	

	public function __construct(array $options=array()){
		parent::__construct($options);
	}

    //Listataan hopslomakkeet, täytetyt ja täyttämättömät.
	public function listHops(){
        
        $tunnus = null;
		$user = SomeFactory::getUser();
        if ($user){
			$tunnus = $user->getUsername();
		}
		else{
			$this->data = array("Kukaan ei ole kirjautunut!!");
			return false;
		}
        $db = SomeFactory::getDBO();
        $statement = $db->prepare("SELECT * FROM hops_lomake WHERE hops_lomake.opnro = ? ORDER BY lukuvuosi");
        $ok = $statement->execute(array($tunnus));

		if ($ok){
		    $i = 1;
		    while($row = $statement->fetch(PDO::FETCH_ASSOC)){
			    $this->data[$i++] = $row;
			}
		}
	}
	
	//Haetaan lomakepohjan tiedot. (ts. deadline)
	public function getFormData() {
	    
	    $formdata;
	    $lukuvuosi = $this->getYear();
	    $tunnus = null;
		$user = SomeFactory::getUser();
        if ($user){
			$tunnus = $user->getUsername();
		}
		else{
			$this->data = array("Kukaan ei ole kirjautunut!!");
			return false;
		}
        $db = SomeFactory::getDBO();
        $statement = $db->prepare("SELECT palautus_pvm FROM hops_pohja WHERE lukuvuosi = ?");
        $ok = $statement->execute(array($lukuvuosi));
	    
	    if ( $ok )
	    {
	        $formdata = $statement->fetch(PDO::FETCH_ASSOC);
	    }
	    	    
	    return $formdata;
	
	}
	
	//Muodostetaan hopslomake jonka opiskelija voi täyttää
	public function doHopsForm(){
		//TODO: hae HOPS-lomakkeen täyttöön vaaditut tiedot
		//Haetaan nyt esim. kaikki kurssit
		$database = SomeFactory::getDBO();
		$statement = $database->prepare("SELECT * FROM kurssi");
		$ok = $statement->execute();

		if ($ok){
			$i = 0;
			while($row = $statement->fetch(PDO::FETCH_ASSOC)){
				//tallennetaan kurssit taulukkoon
				$this->data[$i++] = $row;
			}
		}
	}
	
	public function getFilled($lukuvuosi, $vuositaso){
	    $tunnus = null;
		$user = SomeFactory::getUser();
        if ($user){
			$tunnus = $user->getUsername();
		}
		else{
			$this->data = array("Kukaan ei ole kirjautunut!!");
			return false;
		}
	
	    $database = SomeFactory::getDBO();
	    $statement = $database->prepare(" SELECT * FROM hops_lomake as h WHERE h.opnro=? AND h.vuositaso=? AND h.lukuvuosi=?");
	    $ok = $statement->execute(array($tunnus, $vuositaso, $lukuvuosi));
	    
	    if ( $ok )
	    {   
	        $this->data = $statement->fetch(PDO::FETCH_ASSOC);
	    }
	}
	
	public function getData(){
		return $this->data;
	}
	
	public function getHopsData($lukuvuosi, $vuositaso) {
	    $hopsdata;
	    $tunnus = null;
		$user = SomeFactory::getUser();
        if ($user){
			$tunnus = $user->getUsername();
		}
		else{
			$this->data = array("Kukaan ei ole kirjautunut!!");
			return false;
		}
		$database = SomeFactory::getDBO();
		$statement = $database->prepare("SELECT * FROM aikoo_suorittaa as a JOIN kurssi as k ON a.tunnus = k.tunnus WHERE a.opnro=? AND a.vuositaso=? AND a.lukuvuosi=?");
	    $ok = $statement->execute(array($tunnus, $vuositaso, $lukuvuosi));
	    
	    if ( $ok )
	    {   
	        $i = 0;
			while($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
				$hopsdata[$i++] = $row;
			}
	    }
	    return $hopsdata;
	}
	
	//Haetaan nykyinen lukuvuosi
	public function getYear(){
	    
	    $year = 0;
	    $curr = date("Y-m-d");
	    $august = date("Y-08-01");
	    $january = date("Y-01-01");
	    
	    if ( $curr < $august && $curr > $january){
	        $year = date("Y") - 1;
	    }
	    else
	    {
	        $year = date("Y");
	    }
	    
	    return $year;
    
	}
	
	//Haetaan opiskelijan nykyinen vuositaso. (Ei keksitty hyvää sanaa englanniksi vuositasolle :D )
	public function getVuositaso() {
	    
	    $year = 0; 
	    $user = SomeFactory::getUser();
        $tunnus = $user->getUsername();
        $database = SomeFactory::getDBO();
        //Haetaan kirjautuneen opiskelijan aloitusvuosi tietokannasta
        $statement = $database->prepare("SELECT avuosi FROM opiskelija WHERE opnro = $tunnus");
        $ok = $statement->execute();

        if ($ok)
        {
            $startYear = $statement->fetch();
        } 
	    
	    $curr = date("y-m-d");
        $august = date("y-08-01");                
        $january = date("y-01-01");
                    
        if ( $curr < $august && $curr > $january )
        {
            $year = date("Y") - $startYear['avuosi'];
        }
        else 
        {
            $year = date("Y") - $startYear['avuosi'] + 1;
        }
                    
	    return $year;
	}
	
	//Tallennetaan hopslomakkeen tiedot tietokantaan.
	public function saveHopsData() {
	
	    $data = $_POST;
	    $lukuvuosi = $this->getYear();
	    $vuositaso = $this->getVuositaso();
	    
	    $tunnus = null;
		$user = SomeFactory::getUser();
		$app = SomeFactory::getApplication();
        if ($user){
			$tunnus = $user->getUsername();
		}
		else{
			$this->data = array("Kukaan ei ole kirjautunut!!");
			return false;
		}
	    
	    $database = SomeFactory::getDBO();
	    
	    $statement = $database->prepare("INSERT INTO hops_lomake(lukuvuosi, vuositaso, opnro, palautus_pvm, hyvat_asiat, huonot_asiat, kiinnostukset, edel_tuutori) VALUES(?,?,?,?,?,?,?,?)");
        $ok = $statement->execute(array($lukuvuosi, $vuositaso, $tunnus, date("Y-m-d"), $data['hyvat'], $data['huonot'], $data['kiinnostukset'], $data['ed_tuutori']));
        
        $data = $_POST;
        
        if ($data['at_work'] == '1')
	    {
	        $statement = $database->prepare("UPDATE hops_lomake SET toissa=?, tyonkuva=?, tyonmaara=? WHERE lukuvuosi=? AND vuositaso=? AND opnro=?");
            $ok = $statement->execute(array(1, $data['work_type'], $data['work_amount'], $lukuvuosi, $vuositaso, $tunnus));
           
	    }
	    else if ($data['at_work'] == 0)
	    {
	       $statement = $database->prepare("UPDATE hops_lomake SET toissa=? WHERE lukuvuosi=? AND vuositaso=? AND opnro=?");
            $ok = $statement->execute(array(0, $lukuvuosi, $vuositaso, $tunnus));
           
	    }
        
	    $suoritusvuosi;
	    
	    foreach($data['ktunnus_syksy'] as $kurssi) {
	    
	        $suoritusvuosi = "Syksy " . $lukuvuosi ;
	        
	        $statement = $database->prepare("INSERT INTO aikoo_suorittaa(opnro, lukuvuosi, vuositaso, tunnus, suoritusvuosi) VALUES(?,?,?,?,?)");
            $ok = $statement->execute(array($tunnus, $lukuvuosi, $vuositaso, $kurssi, $suoritusvuosi));
            
	    }
	    
	    foreach($data['ktunnus_kevat'] as $kurssi) {
	        
	        $lukuvuosi2 = $lukuvuosi + 1;
	    
	        $suoritusvuosi = "Kevät " . $lukuvuosi2 ;
	    
	        $statement = $database->prepare("INSERT INTO aikoo_suorittaa(opnro, lukuvuosi, vuositaso, tunnus, suoritusvuosi) VALUES(?,?,?,?,?)");
            $ok = $statement->execute(array($tunnus, $lukuvuosi, $vuositaso, $kurssi, $suoritusvuosi));
        
            
	    }  
	}
	
	//Listataan suoritetut kurssit
	public function listCourses() {
        $tunnus = null;
		$user = SomeFactory::getUser();
        if ($user) {
			$tunnus = $user->getUsername();
		}
		else {
			$this->data = array("Kukaan ei ole kirjautunut!!");
			return false;
		}
        $db = SomeFactory::getDBO();
        $statement = $db->prepare("SELECT * FROM on_suorittanut WHERE opnro = ?");
        $ok = $statement->execute(array($tunnus));

		if ($ok) {
		    $i = 1;
		    while($row = $statement->fetch(PDO::FETCH_ASSOC)){
			    $this->data[$i++] = $row;
			}
        }
    }
    
    //Haetaan suoritettujen kurssien tiedot.
    public function getCourseData($year) {
        
        $coursedata;
        $tunnus = null;
		$user = SomeFactory::getUser();
        if ($user) {
			$tunnus = $user->getUsername();
		}
		else {
			$this->data = array("Kukaan ei ole kirjautunut!!");
			return false;
		}
        $db = SomeFactory::getDBO();
        
        
        //Tässä kohtaa lasketaan minkä vuosien kurssisuorituksia haetaan.
        $syksylisa = 0;
        $kevatlisa = 0;
        
        if ( $year == 1 )
        {
            $kevatlisa = 1;
        }
        else if ( $year == 2 )
        {
            $syksylisa = 1;
            $kevatlisa = 2;
        }
        else if ( $year == 3 )
        {
            $syksylisa = 2;
            $kevatlisa = 3;
        }
        
		$statement = $db->prepare("SELECT k.tunnus, k.nimi, k.op, os.kausi FROM kurssi as k JOIN on_suorittanut as os ON k.tunnus = os.tunnus JOIN opiskelija as o ON o.opnro = os.opnro WHERE os.opnro=? AND ((os.vuosi = o.avuosi+? AND os.kausi ='Syksy') OR (os.vuosi=o.avuosi+? AND os.kausi='Kevät'))");
        $ok = $statement->execute(array($tunnus, $syksylisa, $kevatlisa));
		if ($ok) {
		    $i = 1;
		    while($row = $statement->fetch(PDO::FETCH_ASSOC)){
			    $coursedata[$i++] = $row;
			}
        }
        return $coursedata;
    }
}
?>