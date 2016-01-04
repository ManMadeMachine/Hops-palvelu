<link rel="stylesheet" href="media/profile/profile.css">

<div id="avatar_header">
    <img src="media/profile/avatar.jpg" id="avatar" alt="avatar" height="112" width="150">
    <h1 id="username" >Käyttäjän <?php echo $this->data['etunimi'] . " " . $this->data['sukunimi']; ?> profiili</h1>
</div>
<br>
<div id="profileView">
    <form action="index.php?app=profile&action=edit&nro=<?php echo $this->data['tunnus']; ?>&type=teacher" method="post">
        <table class="headersTeacher">
            <tr><td>Opettajanumero</td></tr>
            <tr><td>Etunimi</td></tr>
            <tr><td>Sukunimi</td></tr>
            <tr><td>Yksikkö</td></tr>
            <tr><td>Sähköposti</td></tr>
            <tr><td>Puhelinnumero</td></tr>
        </table>
        <table class="data">
            <tr><td><?php echo $this->data['tunnus']; ?></td></tr>
            <tr><td><?php echo $this->data['etunimi']; ?></td></tr>
            <tr><td><?php echo $this->data['sukunimi']; ?></td></tr>
            <tr><td><?php echo $this->data['yksikko']; ?></td></tr> 
            <tr><td><?php echo $this->data['sposti']; ?></td></tr>
            <tr><td><?php echo $this->data['puh']; ?></td></tr> 
        </table>
        <br>
        <input type="submit" id="edit_profile" value="Muokkaa"/>
    </form>
</div>