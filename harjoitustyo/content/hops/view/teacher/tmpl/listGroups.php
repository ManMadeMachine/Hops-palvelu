<link rel="stylesheet" href="media/hops/styles.css">


<?php

echo "<h1>Tuutor-ryhmäsi</h1><br>";

$i = 1;
/*Laskuri jolla katsotaan onko ryhmässä yhtään opiskelijaa*/
$lkm = 0;
        
while ( $i <= 3 )
{
    if ($this->data != null) {
        $vuosi = $this->getStartingYear($i); ?>
        <table class='ryhmat'>

                <?php
                                
                echo "<tr><td><h2>" .$i. ". vuoden hopsryhmä:  </h2></td></tr>";
                
                foreach($this->data as $opiskelija) {
                    if ( $opiskelija['avuosi'] == $vuosi )
                    {
                        echo "<tr><td>" .$opiskelija['opnro']. " " .$opiskelija['etunimi']. " " .$opiskelija['sukunimi']. " <a href='index.php?app=profile&action=getProfile&nro=".$opiskelija['opnro']."&type=student'>Profiili</a></td></tr>";
                        $lkm++;
                    }
                } 
                if ($lkm == 0)
                {
                    echo "<tr><td><p>Ryhmässä ei ole opiskelijoita.</p></td></tr>";
                }
                ?>
        </table>
        <?php
    }
    else 
    {
        echo "Sinulla ei ole tuutoroitavia!";
        break;
    }
            
    $i++;
}

?>


