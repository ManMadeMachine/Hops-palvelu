<?php
    
    echo "<h1>Opettajien tuutoroitavien lukumäärät:</h1><br>";
    
    $tuutorit = $this->getTeachers();
    
    if ( $tuutorit != null )
    {
        foreach ($tuutorit as $tuutori)
        {
            $oplkm = 0;
            echo "Tuutori " .$tuutori['tunnus']. " " .$tuutori['etunimi']. " " .$tuutori['sukunimi']. ": ";
            $ryhmat = $this->data;
            if ( $ryhmat != null )
            {
                foreach($ryhmat as $ryhma)
                {
                    if ( $ryhma['tuutori'] == $tuutori['tunnus'] )
                    {
                        $oplkm = $oplkm + $ryhma['oplkm'];
                    }
                }
                echo $oplkm. " kpl tuutoroitavia<br>";
            }   
        }
    }
    
?>

<br><br>
 <input type="button" name="cancel" value="Takaisin" onclick="window.location='index.php?app=hops&action=reports'"/>
