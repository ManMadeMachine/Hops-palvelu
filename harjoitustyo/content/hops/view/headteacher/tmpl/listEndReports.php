<?php
    
    echo "<h1>Loppuraportit</h1>";
    
    foreach($this->data as $raportti)
    {
        echo "<h2>Tuutorin " .$raportti['etunimi']. " " .$raportti['sukunimi']. " (" .$raportti['tuutori']. ") ryhma " .$raportti['hopsryhma']. "</h2>";
        
        echo "Alkuperäinen koko (ts. 1. vuoden palautettujen hopsien lkm): " .$raportti['alkup_koko']. "<br>";
        echo "HOPS-lomakkeiden lukumäärä: " .$raportti['palautetut']. "<br>";
        echo "Ryhmätapaamisiin osallistuneita: " .$raportti['osallistuneet_ryhma']. "<br>";
        echo "Henkilökohtaisiin palavereihin osallistuneita: " .$raportti['osallistuneet_yks']. "<br>";
        echo "Kokonaan tavoittamatta jääneet: " .$raportti['tavoittamattomat']. "<br>";
        echo "Ryhmästä poistuneita: " .$raportti['poisjaaneet']. "<br>";
        echo "Ei aloita opiskelua vielä koska töissä: " .$raportti['i']. "<br>";
        echo "Ei aloita vielä koska joku muu tutkinto kesken: " .$raportti['ii']. "<br>";
        echo "Ei aio opiskella tätä pääaineena: " .$raportti['iii']. "<br>";
        echo "Ei aio opiskella lainkaan: " .$raportti['iv']. "<br>";
        echo "Ei tiedossa: " .$raportti['v']. "<br><br>";

    }

?>

<br><br>
 <input type="button" name="cancel" value="Takaisin" onclick="window.location='index.php?app=hops&action=reports'"/>
