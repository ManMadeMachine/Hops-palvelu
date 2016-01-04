<link rel="stylesheet" href="media/profile/profile.css">

<?php

$op = $this->countPoints($this->data['opnro']);

?>
<link rel="stylesheet" href="media/profile/profile.css">

<div id="avatar_header">
    <img src="media/profile/avatar.jpg" id="avatar" alt="avatar" height="112" width="150">
    <h1 id="username" >Käyttäjän <?php echo $this->data['etunimi'] . " " . $this->data['sukunimi']; ?> profiili</h1>
</div>
<br>
<div id="profileView_edit">
    <form action="index.php?app=profile&action=save" method="post">
        <table class="headers_edit">
            <tr><td>Opiskelijanumero</td></tr>
            <tr><td>Etunimi</td></tr>
            <tr><td>Sukunimi</td></tr>
            <tr><td>Syntymäaika</td></tr>
            <tr><td>Opintojen aloitusvuosi</td></tr>
            <tr><td>Hopsryhmä</td></tr>
            <tr><td>Opintopisteitä yhteensä</td></tr>
            <tr><td>Osoite</td></tr>
            <tr><td>Sähköposti</td></tr>
            <tr><td>Puhelinnumero</td></tr>
        </table>
        <table class="data_edit">
            <tr><td><?php echo $this->data['opnro']; ?></td></tr>
            <tr><td><?php echo $this->data['etunimi']; ?></td></tr>
            <tr><td><?php echo $this->data['sukunimi']; ?></td></tr>
            <tr><td><?php echo $this->data['saika']; ?></td></tr>
            <tr><td><?php echo $this->data['avuosi']; ?></td></tr>
            <tr><td><?php if($this->data['hopsryhma'] != null) echo $this->data['hopsryhma']; else echo "-"; ?></td></tr>
            <tr><td><?php if($op['opintopisteet'] != null) { echo $op['opintopisteet']; } else { echo "0"; }?></tr></td>
            <tr><td><input type="text" name="osoite" value="<?php echo $this->data['osoite']; ?>"/></td></tr>
            <tr><td><input type="text" name="sposti" value="<?php echo $this->data['sposti']; ?>"/></td></tr>
            <tr><td><input type="text" name="puh" value="<?php echo $this->data['puh']; ?>"/></td></tr>
        </table>
        <br>
        <input type="hidden" name="nro" value="<?php echo $this->data['opnro']; ?>" />
        <input type="hidden" name="type" value="<?php echo SomeUser::ROLE_STUDENT; ?>" />
        <input type="submit" id="save_profile" value="Tallenna"/>

	</form>
</div>

	


