<?php
    echo "<h1>Opiskelijat ilman hops-ryhmää</h1>";
    
    ?>
    <form id="allocationForm" name="allocation" action="index.php?app=hops&action=saveAllocated" method="post">
    <?php
    $opiskelijat = $this->getStudents();
    $ryhmat = $this->getGroups();
    if ( $opiskelijat != null )
    {
        foreach($opiskelijat as $opiskelija) {
            if ( $opiskelija['hopsryhma'] == null )
            {
                echo "<p>".$opiskelija['opnro']. " " .$opiskelija['etunimi']. " " .$opiskelija['sukunimi']. "</p>";
                echo "<select name='".$opiskelija['opnro']."_hopsGroup'>\n";
                echo "<option value=' '>---</option>";
                foreach($ryhmat as $ryhma)
                {
                    echo "<option value='" . $ryhma['tunnus'] . "'>Ryhmä nro " . $ryhma['tunnus'] . "</option>\n";
                }
                echo "</select>";
            }
        }
    
        echo "<br><br><input type='submit' value='Tallenna' />";
        echo "<br><input type='button' name='cancel' value='Peruuta' onclick='window.location=\"index.php?app=hops&action=listPeople\"'/>";

    }
    else
    {
        echo "Ei toimiiiii";
    }
?>
    </form>
