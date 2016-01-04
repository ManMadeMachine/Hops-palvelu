<?php    
    echo "<h1>Kolmannen vuoden opiskelijoiden sähköpostiosoitteet</h1>";
    
    foreach($this->data as $opiskelija)
    {
        echo $opiskelija['etunimi']. " " .$opiskelija['sukunimi']. " " .$opiskelija['sposti']. " (Ryhmä " .$opiskelija['hopsryhma']. ")<br>";
    
    }

?>

<br><br>
 <input type="button" name="cancel" value="Takaisin" onclick="window.location='index.php?app=hops&action=reports'"/>
