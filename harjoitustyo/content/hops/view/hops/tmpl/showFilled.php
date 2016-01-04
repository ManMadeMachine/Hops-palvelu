<?php
        
    $lukuvuosi = $this->data['lukuvuosi'];
        
    $lv = $this->data['lukuvuosi'];
    $vt = $this->data['vuositaso'];
    $kurssitiedot = $this->getHopsData($lv, $vt);
        
    echo "<h1> " .$this->data['vuositaso']. ":n vuoden hops-lomake (lukuvuosi " .$lukuvuosi. "-"; 
    echo $lukuvuosi+1;
    echo ") </h1>";
    echo "<h2>Palautetettu " .$this->data['palautus_pvm'].  "</h2><br>";
    
    echo "<h3>Hyvät asiat: </h3>";
    echo $this->data['hyvat_asiat'];
    
    echo "<h3>Huonot asiat: </h3>";
    echo $this->data['huonot_asiat'];
    
    echo "<h3>Kiinnostukset kohteet: </h3>";
    echo $this->data['kiinnostukset'];
    
    echo "<h3>Viime lukukauden tuutori: </h3>";
    echo $this->data['edel_tuutori'];

    
    echo "<br><br>";
    
    if ( $this->data['toissa'] == '1' )
    {
        echo "<h3>Töissä?</h3>";
        echo "Kyllä";
        echo "<h3>Työnkuva: </h3>";
        echo $this->data['tyonkuva'];
        echo "<h3>Työnmäärä: </h3>";
        echo $this->data['tyonmaara']. "h/vko";
    }
    else if ($this->data['toissa'] == '0' )
    {
        echo "<h3>Töissä?</h3>";
        echo "Ei";
    }
    
    echo "<br><br>";
    
    echo "<h3>Suunnitelemasi kurssit </h3>";
        
    if ( $kurssitiedot != null )
    {
        foreach($kurssitiedot as $kurssi) {
   
            echo $kurssi['tunnus']. " " .$kurssi['nimi']. " " .$kurssi['oppiaine']. " " .$kurssi['op']. " op";
            echo "<br>";
        }
    }
    else 
    {
        echo "Ei suunniteltuja kursseja";
    }
        
    echo "<br><br><a href='index.php?app=hops&action=listHops'>Takaisin</a>";
    
?>

