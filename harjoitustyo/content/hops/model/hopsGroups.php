<?php
someloader('some.application.model');

class SomeModelHopsGroups extends SomeModel{
    public function __construct(array $options=array()){
		parent::__construct($options);
	}
	
    private $teachers;
	
	//Listataan hopsryhmät.
	public function listHopsGroups(){
	    
	    $user = SomeFactory::getUser();
	    $db = SomeFactory::getDBO();
		$stmt = null;
	    
	    if ($user->getId() && ($user->getUserrole() === 'teacher' || $user->getUserrole() === 'headteacher'))
	    {
	        //Kysely
			$stmt = $db->prepare("SELECT o.opnro, o.etunimi, o.sukunimi, o.hopsryhma, o.avuosi FROM opiskelija as o JOIN hops_ryhma as hr ON o.hopsryhma = hr.tunnus JOIN tuutori as t ON hr.tuutori = t.tunnus WHERE t.tunnus=?");
		    $ok = $stmt->execute(array($user->getUsername()));
		
		    $i = 0;
		    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			    $this->data[$i++] = $row;
			}
		}
	    else
	    {
	        echo "You do not have permission!!!!";
	    } 
	}
	
	//Listataan hopsopettajat.
	public function listHopsTeachers() {
	
	    $user = SomeFactory::getUser();
	    $db = SomeFactory::getDBO();
		$stmt = null;
	    
	    if ($user->getId() && $user->getUserrole() === 'headteacher')
	    {
	        //Kysely
			$stmt = $db->prepare("SELECT t.tunnus, t.etunimi, t.sukunimi FROM tuutori as t WHERE tyyppi IS NOT 'ylituutori'");
		    $ok = $stmt->execute();
		
		    $i = 0;
		    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			    $this->teachers[$i++] = $row;
			}
		}
	    else
	    {
	        echo "You do not have permission!!!!";
	    } 
	    
	}
	
	public function getHopsTeachers() {
	    return $teachers;
	}
	
	//Listataan raportit
	public function listReports() {
	    
	    //Haetaan tässä nyt vaikka kirjautuneen opettajan hopsryhmien tunnukset
	    $user = SomeFactory::getUser();
	    $db = SomeFactory::getDBO();
		$stmt = null;
	    
	    if ($user->getId() && $user->getUserrole() == 'teacher')
	    {
	        //Kysely
			$stmt = $db->prepare("SELECT hr.tunnus, hr.alkup_koko FROM hops_ryhma as hr JOIN tuutori as t ON hr.tuutori = t.tunnus WHERE t.tunnus=?");
		    $ok = $stmt->execute(array($user->getUsername()));
		
		    $i = 0;
		    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			    $this->data[$i++] = $row;
			}
		}
	    else
	    {
	        echo "You do not have permission!!!!";
	    } 
	}
	
	//Listataan kolmannen vuoden opiskelijat.
	public function listEmails() {
	    
	    $startYear = $this->getStartingYear(3);
	    $user = SomeFactory::getUser();
	    $db = SomeFactory::getDBO();
		$stmt = null;
	    
	    if ($user->getId() && $user->getUserrole() == 'teacher')
	    {
	        //Kysely
			$stmt = $db->prepare("SELECT o.opnro, o.etunimi, o.sukunimi, o.sposti FROM opiskelija as o JOIN hops_ryhma as hr ON o.hopsryhma = hr.tunnus JOIN tuutori as t ON t.tunnus = hr.tuutori WHERE t.tunnus=? AND o.avuosi=?");
		    $ok = $stmt->execute(array($user->getUsername(), $startYear));
		
		    $i = 0;
		    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			    $this->data[$i++] = $row;
			}
		}
	    else
	    {
	        echo "You do not have permission!!!!";
	    } 
	
	}
	
	//Haetaan nykyisen vuoden lukuvuosi nykyisen päivän perusteella.
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
	
	//Haetaan parametrin avulla minä vuonna opiskelija on aloittanut opintonsa.
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
	
	//Muodostetaan loppuraportti.
	public function doEndReport() {
	    
        $user = SomeFactory::getUser();
	    $db = SomeFactory::getDBO();
		$stmt = null;
		
		$lukuvuosi = $this->getYear();
		$lukuvuosi2 = $lukuvuosi + 1;
		
		if ($user->getId() && ($user->getUserrole() == 'teacher'))
		{
		    $tunnus = $user->getUsername();
		}

	    
	    if ($user->getId() && $user->getUserrole() == 'teacher')
	    {
	        //Haetaan kaikki opettajan tuutor ryhmät ja muodostetaan niille jokaiselle sen jälkeen loppuraportti.
	        $stmt = $db->prepare("SELECT hr.tunnus FROM hops_ryhma as hr WHERE hr.tuutori = $tunnus");
		    $ok = $stmt->execute();

		    if ($ok){
		        $i = 0;
		        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			    $this->data[$i++] = $row;
			    }
		    }
		    $i = 0;


            if ($this->data != null )
            {
                foreach ($this->data as $ryhma)
	            {
	                //Näkymän muodostus. Sisältää kaikki kyselyt mitä loppuraporttiin tarvittiin.
                    $stmt = $db->prepare("WITH loppuraportti AS ( 
                                    SELECT hr.tuutori, hr.tunnus,
                                        (SELECT COUNT(o.opnro) 
                                        FROM opiskelija as o JOIN hops_lomake as hl ON hl.opnro = o.opnro 
                                        WHERE hl.vuositaso = 1 AND o.hopsryhma = '".$ryhma['tunnus']."') as alkup_koko,

                                        (SELECT COUNT(o.opnro) 
                                        FROM opiskelija as o JOIN hops_lomake as hl ON hl.opnro = o.opnro 
                                        WHERE hl.lukuvuosi='".$lukuvuosi."' AND o.hopsryhma = '".$ryhma['tunnus']."') as palautetut_hopsit,
 
                                        (SELECT COUNT(DISTINCT o.opnro) 
                                        FROM opiskelija as o JOIN osallistuu as os ON o.opnro = os.opnro 
                                        WHERE (os.tunnus=2 OR os.tunnus=3) AND o.hopsryhma = '".$ryhma['tunnus']."' AND ((os.vuosi= '".$lukuvuosi2."' AND os.kausi='Kevät') OR (os.vuosi=	'".$lukuvuosi."' AND os.kausi='Syksy'))) as osallistuneet,

                                        (SELECT COUNT(DISTINCT o.opnro) 
                                        FROM opiskelija as o JOIN osallistuu as os ON o.opnro = os.opnro 
                                        WHERE o.hopsryhma = '".$ryhma['tunnus']."' AND (os.tunnus!=1 OR os.tunnus!=2 OR os.tunnus!=3) AND ((os.vuosi='".$lukuvuosi2."' AND os.kausi='Kevät') OR (os.vuosi='".$lukuvuosi."' AND os.kausi='Syksy'))) as yksilo_tapaamiset,

                                        (SELECT COUNT(DISTINCT o.opnro) 
                                        FROM opiskelija as o 
                                        WHERE NOT EXISTS(SELECT * 
                                                        FROM osallistuu as os 
                                                        WHERE o.opnro = os.opnro AND ((os.vuosi='".$lukuvuosi."' AND os.kausi='Syksy') OR (os.vuosi= '".$lukuvuosi2."' AND os.kausi='Kevät')) ) 
                                        AND NOT EXISTS(SELECT * FROM hops_lomake as hl 
                                                        WHERE hl.opnro = o.opnro AND lukuvuosi='".$lukuvuosi."') AND o.hopsryhma = '".$ryhma['tunnus']."') as tavoittamattomat,

                                        (SELECT COUNT(o.opnro) 
                                        FROM opiskelija as o JOIN poissa as p ON p.opnro = o.opnro 
                                        WHERE o.hopsryhma = '".$ryhma['tunnus']."') as poisjääneet,
                                    
                                        (SELECT COUNT(o.opnro) 
                                        FROM opiskelija as o JOIN poissa as p ON p.opnro = o.opnro
                                        WHERE p.syy = 'i' AND o.hopsryhma = '".$ryhma['tunnus']."') as i,
                                    
                                        (SELECT COUNT(o.opnro) 
                                        FROM opiskelija as o JOIN poissa as p ON p.opnro = o.opnro
                                        WHERE p.syy = 'ii' AND o.hopsryhma = '".$ryhma['tunnus']."') as ii,
                                    
                                        (SELECT COUNT(o.opnro) 
                                        FROM opiskelija as o JOIN poissa as p ON p.opnro = o.opnro
                                        WHERE p.syy = 'iii' AND o.hopsryhma = '".$ryhma['tunnus']."') as iii,
                                    
                                        (SELECT COUNT(o.opnro) 
                                        FROM opiskelija as o JOIN poissa as p ON p.opnro = o.opnro
                                        WHERE p.syy = 'iv' AND o.hopsryhma = '".$ryhma['tunnus']."') as iv,
                                    
                                        (SELECT COUNT(o.opnro) 
                                        FROM opiskelija as o JOIN poissa as p ON p.opnro = o.opnro
                                        WHERE p.syy = 'v' AND o.hopsryhma = '".$ryhma['tunnus']."') as v
                                    
                                        FROM hops_ryhma as hr
                                        WHERE hr.tuutori = '$tunnus' AND hr.tunnus= '".$ryhma['tunnus']."')

                                        SELECT * FROM loppuraportti");
                                
                    $ok = $stmt->execute();
                                
                    if ($ok){
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                           $this->data[$i++] = $row;
                        }
                    }
                }
	        }   
		}
	}
	
	
	//Tallennetaan loppuraportti tietokantaan opettajan painaessa 'Lähetä'.
	public function saveEndForm()
	{
	    $data = $_POST;
	    $user = SomeFactory::getUser();
	    $db = SomeFactory::getDBO();
		$stmt = null;
	    	    
	    if ($user->getId() && $user->getUserrole() === 'teacher') {
	        foreach($data['ryhmat'] as $tiedot){
	        
	            $stmt = $db->prepare("UPDATE loppuraportit 
	                                SET alkup_koko = ?, palautetut = ?, osallistuneet_ryhma = ?, osallistuneet_yks = ?, tavoittamattomat = ?, poisjaaneet = ?, i = ?, ii = ?, iii = ?, iv = ?, v = ?
	                                WHERE tuutori = '".$user->getUsername()."' AND hopsryhma = '".$tiedot['tunnus']."'");
	            $ok = $stmt->execute(array($tiedot['alkup_koko'], $tiedot['pal_hopsit'], $tiedot['osallistuneet'], $tiedot['yks_tapaamiset'], $tiedot['tavoittamattomat'], $tiedot['poissa'], $tiedot['i'], $tiedot['ii'], $tiedot['iii'], $tiedot['iv'], $tiedot['v']) );
	            $stmt = $db->prepare("INSERT INTO loppuraportit VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $ok = $stmt->execute(array($user->getUsername(), $tiedot['tunnus'], $tiedot['alkup_koko'], $tiedot['pal_hopsit'], $tiedot['osallistuneet'], $tiedot['yks_tapaamiset'], $tiedot['tavoittamattomat'], $tiedot['poissa'], $tiedot['i'], $tiedot['ii'], $tiedot['iii'], $tiedot['iv'], $tiedot['v']) );
	        }  
		}
	}
}
?>