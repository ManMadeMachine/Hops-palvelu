<link rel="stylesheet" href="media/profile/profile.css">

<div id="avatar_header">
    <img src="media/profile/avatar.jpg" id="avatar" alt="avatar" height="112" width="150">
    <h1 id="username" >Käyttäjän <?php echo $this->data['etunimi'] . " " . $this->data['sukunimi']; ?> profiili</h1>
</div>
<br>
<div id="profileView_edit">
    <form action="index.php?app=profile&action=save" method="post">
        <table class="headers_edit_teacher">
            <tr><td>Opettajanumero</td></tr>
            <tr><td>Etunimi</td></tr>
            <tr><td>Sukunimi</td></tr>
            <tr><td>Yksikkö</td></tr>
            <tr><td>Sähköposti</td></tr>
            <tr><td>Puhelinnumero</td></tr>
        </table>
        <table class="data_edit">
            <tr><td><?php echo $this->data['tunnus']; ?></td></tr>
            <tr><td><?php echo $this->data['etunimi']; ?></td></tr>
            <tr><td><?php echo $this->data['sukunimi']; ?></td></tr>
            <tr><td><?php echo $this->data['yksikko']; ?></td></tr>
            <tr><td><input type="text" name="sposti" value="<?php echo $this->data['sposti']; ?>"/></td></tr>
            <tr><td><input type="text" name="puh" value="<?php echo $this->data['puh']; ?>"/></td></tr>
        </table>
        <br>
        <input type="hidden" name="nro" value="<?php echo $this->data['tunnus']; ?>" />
        <input type="hidden" name="type" value="<?php echo SomeUser::ROLE_TEACHER; ?>" />
        <input type="submit" id="save_profile" value="Tallenna"/>
        
	</form>
	
    <?php
    $user = SomeFactory::getUser();
    //Mikäli katsellaan edit-näkymää ylituutorina, on myös opettajan poisto mahdollinen
    if ($user->getUserrole() === SomeUser::ROLE_HEADTEACHER){
    ?>
        <form action="index.php?app=profile&action=delete" method="post">
            <input type="hidden" name="tunnus" value="<?php echo $this->data['tunnus']; ?>" />
            <input type="submit" id="delete_teacher" value="Poista" />
        </form>
    <?php
    }
    ?>
</div>

	


