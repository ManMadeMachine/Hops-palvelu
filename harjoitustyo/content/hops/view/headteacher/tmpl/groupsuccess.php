<?php
    
    echo "<h1>Ryhmien koossa pysyminen</h1><br>";
    
    $ryhmat = $this->getGroups();
    $filledhops = SomeModelHeadteacher::countReturned();
    $attended = $this->countAttended();
    
    $alkupkoko = 0;
    $nykykoko = 0;
    
    if ( $ryhmat != null )
    {
        foreach ($ryhmat as $ryhma)
        {
                        
            foreach ($filledhops as $hops)
            {
                if ( $hops['tunnus'] == $ryhma['tunnus'] && $hops['palautetut'] != 0 )
                {

                    $alkupkoko = $hops['palautetut'];
                    
                    foreach ($attended as $a)
                    {
                        if ( $a['tunnus'] == $ryhma['tunnus'] && $a['osallistuneet'] != 0 )
                        {
                            $nykykoko = $a['osallistuneet'];
                            
                            $success = $nykykoko / $alkupkoko;
                            $success = sprintf('%0.2f', $success);
            
                            echo "<h3>Ryhmä " .$ryhma['tunnus']. "</h3>";
                            echo "Ekana vuonna palautettujen hopsien lukumäärä " .$alkupkoko. "<br>";
                            echo "Viimeisen vuoden viimeiseen tapaamiseen osallistuneiden lukumäärä " . $a['osallistuneet']. "<br>";
                            echo "Ryhmän koossapysyminen : " .$success;

                        }
                    }
                }
            }
        }
        
        
    }
   
    
?>
<br><br>
 <input type="button" name="cancel" value="Takaisin" onclick="window.location='index.php?app=hops&action=reports'"/>
