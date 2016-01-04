<link rel="stylesheet" href="media/hops/styles.css">

<table class='eka cf'>
<?php

echo "<tr><td><h1>Tuutorit</h1></td></tr>";

$tuutorit = $this->getTeachers();
$ryhmat = $this->getGroups();
$opiskelijat = $this->getStudents();

$ryhma_lkm = 0;
$opiskelija_lkm = 0;
?>

<tr><td><a href="index.php?app=profile&action=newTeacher">Lisää uusi tuutori</a></td></tr>
<tr><td><a href="index.php?app=hops&action=addGroup">Lisää uusi ryhmä</a></td></tr>

<?php
if ( $tuutorit != null )
{
    foreach($tuutorit as $tuutori) {
        echo "<tr><td><br><h3>Tuutori " .$tuutori['tunnus']. " " .$tuutori['etunimi']. " " .$tuutori['sukunimi']. " <a href='index.php?app=profile&action=getProfile&nro=".$tuutori['tunnus']."&type=teacher'>Profiili</a></h3></td></tr>";
        $ryhma_lkm = 0;
        if ( $ryhmat != null )
        {
            foreach($ryhmat as $ryhma)
            {
                $opiskelija_lkm = 0;
                if ( $ryhma['tuutori'] == $tuutori['tunnus'] )
                {
                    $ryhma_lkm++;
                    echo "<tr><td><br>Ryhmän nro. " .$ryhma['tunnus']. ".<br></td></tr>";
                    foreach($opiskelijat as $opiskelija)
                    {
                        if ($opiskelija['hopsryhma'] == $ryhma['tunnus'])
                        {
                            $opiskelija_lkm++;
                            echo "<tr><td>" .$opiskelija['opnro']. " " .$opiskelija['etunimi']. " " .$opiskelija['sukunimi']. " <a href='index.php?app=profile&action=getProfile&nro=".$opiskelija['opnro']."&type=student'>Profiili</a></td></tr>";
                        }
                    }
                    if ( $opiskelija_lkm == 0 )
                    {
                        echo "<tr><td>Ryhmässä ei ole tuutoroitavia.<br></td></tr>";
                    }
                }
                
                
            }
            if ( $ryhma_lkm == 0 )
            {
                echo "<tr><td>Ei hops-ryhmiä määrättynä.<br></td></tr>";
            }
        }   
    }
}
?>

</table>
<table class="toka">

<?php
//Opiskelijat joilla ei ole hops-ryhmää määriteltynä
echo "<tr><td><h1>Opiskelijat ilman hops-ryhmää</h1><br></td></tr>";
if ( $opiskelijat != null )
{
    foreach($opiskelijat as $opiskelija) {
        if ( $opiskelija['hopsryhma'] == null )
        {
            echo "<tr><td>".$opiskelija['opnro']. " " .$opiskelija['etunimi']. " " .$opiskelija['sukunimi']. " <a href='index.php?app=profile&action=getProfile&nro=".$opiskelija['opnro']."&type=student'>Profiili</a><br></td></tr>";
        }
    }
    
    echo "<tr><td><br><a href='index.php?app=hops&action=allocateStudents'>Jaa ryhmiin</a></td></tr>";
}
else
{
    echo "<tr><td>Kaikilla opiskelijoilla on ryhmät.</td></tr>";
}


?>

</table