    <h1>Ryhmien loppuraportit (esikatselu)</h1>

    <form id="endForm" name="endForm" action="index.php?app=hops&action=saveEndForm" method="post">
    <?php 
    
        if ( $this->data != null )
        {
        
            foreach ($this->data as $ryhma)
            {
                echo "<h2>Ryhmä " .$ryhma['tunnus']. ":</h2>";
                echo "Alkuperäinen koko: " .$ryhma['alkup_koko']. "<br>";
                echo "HOPS-lomakkeiden lukumäärä: " .$ryhma['palautetut_hopsit']. "<br>";
                echo "Ryhmätapaamisiin osallistuneita: " .$ryhma['osallistuneet']. "<br>";
                echo "Henkilökohtaisiin palavereihin osallistuneita: " .$ryhma['yksilo_tapaamiset']. "<br>";
                echo "Kokonaan tavoittamatta jääneet: " .$ryhma['tavoittamattomat']. "<br>";
                echo "Ryhmästä poistuneita: " .$ryhma['poisjääneet']. "<br>";
                echo "Ei aloita opiskelua vielä koska töissä: " .$ryhma['i']. "<br>";
                echo "Ei aloita vielä koska joku muu tutkinto kesken: " .$ryhma['ii']. "<br>";
                echo "Ei aio opiskella tätä pääaineena: " .$ryhma['iii']. "<br>";
                echo "Ei aio opiskella lainkaan: " .$ryhma['iv']. "<br>";
                echo "Ei tiedossa: " .$ryhma['v']. "<br><br>";
            
                ?>

                <input type="hidden" name="ryhmat[<?php echo $ryhma['tunnus']; ?>][tunnus]" value="<?php echo $ryhma['tunnus']; ?>"/>
                <input type="hidden" name="ryhmat[<?php echo $ryhma['tunnus']; ?>][alkup_koko]" value="<?php echo $ryhma['alkup_koko']; ?>"/>
                <input type="hidden" name="ryhmat[<?php echo $ryhma['tunnus']; ?>][pal_hopsit]" value="<?php echo $ryhma['palautetut_hopsit']; ?>"/>
                <input type="hidden" name="ryhmat[<?php echo $ryhma['tunnus']; ?>][osallistuneet]" value="<?php echo $ryhma['osallistuneet']; ?>"/>
                <input type="hidden" name="ryhmat[<?php echo $ryhma['tunnus']; ?>][yks_tapaamiset]" value="<?php echo $ryhma['yksilo_tapaamiset']; ?>"/>
            
                <input type="hidden" name="ryhmat[<?php echo $ryhma['tunnus']; ?>][tavoittamattomat]" value="<?php echo $ryhma['tavoittamattomat']; ?>"/>
                <input type="hidden" name="ryhmat[<?php echo $ryhma['tunnus']; ?>][poissa]" value="<?php echo $ryhma['poisjääneet']; ?>"/>
                <input type="hidden" name="ryhmat[<?php echo $ryhma['tunnus']; ?>][i]" value="<?php echo $ryhma['i']; ?>"/>
                <input type="hidden" name="ryhmat[<?php echo $ryhma['tunnus']; ?>][ii]" value="<?php echo $ryhma['ii']; ?>"/>
                <input type="hidden" name="ryhmat[<?php echo $ryhma['tunnus']; ?>][iii]" value="<?php echo $ryhma['iii']; ?>"/>
                <input type="hidden" name="ryhmat[<?php echo $ryhma['tunnus']; ?>][iv]" value="<?php echo $ryhma['iv']; ?>"/>
                <input type="hidden" name="ryhmat[<?php echo $ryhma['tunnus']; ?>][v]" value="<?php echo $ryhma['v']; ?>"/>

                <?php
            }
        
            echo "<br><input type='submit' value='Lähetä loppuraportti' />";
            echo "<br><input type='button' name='cancel' value='Peruuta' onclick='window.location=\"index.php?app=hops&action=reports\"'/>";
        }
        
        else 
        {
            echo "Sinulla ei ole tuutoroitavia";
        }

    ?>
    </form>
