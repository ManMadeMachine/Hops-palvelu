<link rel="stylesheet" href="media/hops/list.css">

    
<h1>Täytetyt HOPS-lomakkeet</h1>
<?php    
    $tiedot = $this->getFormdata();
    
     $lukuvuosi = $this->getYear();
    
    if ( $this->data != null )
    {
        $totta = 0;

        foreach ($this->data as $rivit){
            echo "<p><a href='index.php?app=hops&action=showFilled&lv=".$rivit['lukuvuosi']."&vt=".$rivit['vuositaso']."'>" . $rivit['vuositaso'] .".vuosi (". $rivit['lukuvuosi']. ")"."</a></p><br/>";
        
            if ( $rivit['lukuvuosi'] == $lukuvuosi )
            { 
                $totta = 1;
            }
        }
    
        if ( $totta == 0 )
        {
            echo "<p>Et ole vielä palauttanut tämän vuoden HOPS-lomaketta. ";
            echo "Sen voit tehdä <a href='index.php?app=hops&action=fillHops'>" . täällä ."</a><br/>";
            echo "Huom! Deadline on " .$tiedot['palautus_pvm']. ".</p>";   
        }    
    }
    else
    {
        $pvm = $this->data;
        echo "<p>Sinulla ei ole palautettuja hops-lomakkeita. ";
        echo "Lukuvuoden " .$lukuvuosi. "-" .($lukuvuosi+1) . " lomakkeen voit täyttää <a href='index.php?app=hops&action=fillHops'>" . täällä ."</a><br/>";
        echo "Huom! Deadline on " .$tiedot['palautus_pvm']. ".</p>";
    }

?>

