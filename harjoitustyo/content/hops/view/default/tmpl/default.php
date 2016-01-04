<?php $user = SomeFactory::getUser();

$nimi = $this->getNameData();

echo "<h1>Tervetuloa " .$nimi['etunimi']. " " .$nimi['sukunimi']. " (" .$user->getUsername(). ")</h1><br/><br/>";


echo "Tämä palvelu on tarkoitettu Tampereen yliopiston opiskelijoiden ja opettajien väliseen hops-käyttöön. <br><br>
Palvelussa opiskelijat voivat täyttää vuosittaiset hops-lomakkeensa ja suunnitella tulevan lukuvuoden kursseja. <br> He voivat myös seurata opintojensa etenemistä 'Suoritukset' välilehden alta.
<br><br>Tuutorit sen sijaan voivat palvelun avulla pitää paremmin kirjaa tuutoroitavistaan ja muodostaa helpommin lukukausittaiset vuosiraportit, <br>jotka sitten lähetetään niistä vastuussa olevalle ylituutorille.
<br><br>
Omat tietosi löydät 'Omat tiedot' välilehden alta. Muistathan pitää yhteystietosi ajantasalla.";

?>