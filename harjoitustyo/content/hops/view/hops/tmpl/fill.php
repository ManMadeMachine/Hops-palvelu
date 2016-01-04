
<link rel="stylesheet" href="media/hops/fill.css">
<script src="media/hops/courses.js" type="text/javascript"></script>


<?php $tiedot = $this->getFormdata();
    $lukuvuosi = $this->getYear();
?>

<h1 class="hops-otsikko">HOPS-KYSELY OPISKELUVUODELLE, <br> SUUNNITELMAT LUKUVUODELLE <?php echo $lukuvuosi; echo " - "; echo $lukuvuosi+1 ?> </h1>

<br>
<p>Tässä suunnitelmassa olevia tietoja käsitellään luottamuksellisina. Lomakkeisiin tulevat pääsemään käsiksi vain opettajatutorisi ja
opettajatutoreiden yhdyshenkilö. Lomakkeiden tietoja tullaan käyttämään opettajatutorointia edistäviin yhteenvetoihin, jolloin tietoja
ei enää voi yhdistää henkilöön. </p><br>

<p>Tämä lomake on palautettava täytettynä viimeistään <?php echo $tiedot['palautus_pvm']; ?>. </p><br>

<p><b>Muistathan myös käydä lisäämässä/muuttamassa 'Omat tiedot'-osioon ajantasalla olevat yhteystietosi!</b></p><br>

<p>Ole hyvä ja täytä kaikki kohdat!</p><br/>
<form action="index.php?app=hops&action=saveHops" method="post">

    <h3>Kurssisuunnitelma lukuvuodelle <?php echo $lukuvuosi; echo " - "; echo $lukuvuosi+1 ?></h3>
    <table>
        <h3>Syyslukukausi</h3>
        <select name="syksy" id="syksy">
            <?php
                foreach($this->data as $kurssi) {
                    $tiedot = $kurssi['tunnus'] . "," . $kurssi['nimi'] . "," . $kurssi['oppiaine'] . "," . $kurssi['op'];
                    echo '<option value="' . $tiedot . '">' . $kurssi['tunnus'] . ' ' . $kurssi['nimi'] . ' ' . $kurssi['oppiaine'] . ' ' . $kurssi['op'] . 'op' . '</option>';
                }
            ?>
        </select>
        <input type="button" id="lisaaButton_syksy" value="Lisää kurssi" />
        <table name="kurssit_syksy" id="kurssit_syksy" align="center" style="width: 80%">
            <tr>
                <th>Opintojakson tunnus</th>
                <th>Opintojakson nimi</th>
                <th>Opintopisteitä</th>
                <th>Oppiaine</th>
                <th>&nbsp;</th>
            </tr>

            <tr name="kurssirivi" class="kurssirivi"></tr>
        </table>

        <br><br>

        <h3>Kevätlukukausi</h3>
        <select name="kevat" id="kevat">
            <?php
                foreach($this->data as $kurssi){
                    $tiedot = $kurssi['tunnus'] . "," . $kurssi['nimi'] . "," . $kurssi['oppiaine'] . "," . $kurssi['op'];
                    echo '<option value="' . $tiedot . '">' . $kurssi['tunnus'] . ' ' . $kurssi['nimi'] . ' ' . $kurssi['oppiaine'] . ' ' . $kurssi['op'] . 'op' . '</option>';
                }
            ?>
        </select>
        <input type="button" id="lisaaButton_kevat" value="Lisää kurssi" />
        <table name="kurssit_kevat" id="kurssit_kevat" align="center" style="width: 80%">
            <tr>
                <th>Opintojakson tunnus</th>
                <th>Opintojakson nimi</th>
                <th>Opintopisteitä</th>
                <th>Oppiaine</th>
                <th>&nbsp;</th>
            </tr>
            <tr name="kurssirivi" class="kurssirivi"></tr>
        </table>

        <br>

        <h3>Olen töissä lukuvuoden aikana.</h3>
        Kyllä <input type="radio" name="at_work" value="1" id="work_yes">

        <br>

        <label for="work_type">Työn kuva: </label>
        <input type="text" name="work_type" value="" id="work_type">
        <br>
        <label for="work_amount">Työn määrä (h/vko): </label>
        <input type="text" name="work_amount" value="" id="work_amount">

        <br><br>
        Ei <input type="radio" name="at_work" value="0" id="work_no">
        <br><br>

        <h3>Erityisiä kiinnostuksen kohteita: </h3>
        <p>Mitkä aihealueet kiinnostavat sinua omalla alallasi eniten ? </p>
        <textarea name="kiinnostukset" id="kiinnostukset" rows="4" cols="50"></textarea>

        <br><br>
        
        <p><h3>HUOM!</h3>Seuraavat kysymykset on tarkoitettu vain toisen ja kolmannen vuoden opiskelijoille! Jos olet ensimmäisen vuoden opiskelija, voit jättää kohdat tyhjiksi.</p>
        
        <br>

        <h3>Vuoden hyviä asioita olivat: </h3>
        <p>Kirjoita tähän asioita jotka menivät viime lukuvuonna mielestäsi hyvin.</p>
        <textarea name="hyvat" id="hyvat" rows="4" cols="50"></textarea>

        <br><br>

        <h3>Vuoden huonoja asioita olivat: </h3>
        <p>Kirjoita tähän asioita jotka olisivat voineet mielestäni mennä viime lukuvuonna paremmin.</p>
        <textarea name="huonot" id="huonot" rows="4" cols="50"></textarea>

        <br><br>
        
        <label for="ed_tuutori">Viime lukuvuonna HOPS-opettajani oli : </label>
        <input type="text" name="ed_tuutori" value="" id="ed_tuutori">
        <br><br>
        
        <p><b>Muistathan myös käydä lisäämässä/muuttamassa 'Omat tiedot'-osioon ajantasalla olevat yhteystietosi!</b></p><br>
        
        <br>
        <input type="hidden" name="save" value="null" />
        <input type="submit" id="send_form" value="Lähetä" />
        <input type="button" name="cancel" value="Keskeytä" onclick="window.location='index.php?app=hops&action=listHops'"/>
    
    </table>

</form>
