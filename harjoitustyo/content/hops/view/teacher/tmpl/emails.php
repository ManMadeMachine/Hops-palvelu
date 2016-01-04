
<?php    
    
    echo "<h1>Kolmannen vuoden opiskelijoiden sähköpostiosoitteet</h1><br>";

    if ( $this->data != null )
    {
        foreach ($this->data as $rivit){
            echo $rivit['opnro']. ", " . $rivit['etunimi'] . " " . $rivit['sukunimi'] . ", sähköposti: " . $rivit['sposti'] . "<br><br>"; 
        }   
    }
    else
    {
        echo "Sinulla ei ole 3. vuoden tuutoroitavia.";
    }
?>
