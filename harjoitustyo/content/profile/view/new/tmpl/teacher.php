<link rel="stylesheet" href="media/profile/profile.css">

<div id="avatar_header">
    <img src="media/profile/avatar.jpg" id="avatar" alt="avatar" height="112" width="150">
    <h1 id="username" >Lisää tuutori</h1>
</div>
<br>
<div id="profileView">
    <form action="index.php?app=account&action=register" method="post">
        <table class="headersTeacher">
            <tr><td>Opettajanumero</td></tr>
            <tr><td>Etunimi</td></tr>
            <tr><td>Sukunimi</td></tr>
            <tr><td>Yksikkö</td></tr>
            <tr><td>Sähköposti</td></tr>
            <tr><td>Puhelinnumero</td></tr>
            <tr><td>Salasana</td></tr>
        </table>
        <table class="data">
            <tr><td><input type="text" name="tunnus" /></td></tr>
            <tr><td><input type="text" name="etunimi" /></td></tr>
            <tr><td><input type="text" name="sukunimi" /></td></tr>
            <tr><td><input type="text" name="yksikko" /></td></tr> 
            <tr><td><input type="email" name="sposti" /></td></tr>
            <tr><td><input type="text" name="puh" /></td></tr> 
            <tr><td><input type="password" name="salasana" /></td></tr>
        </table>
        <br>
        <input type="submit" id="edit_profile" value="Luo uusi"/>
        <br>
        <input type="button" id="cancel" name="cancel" value="Peruuta" onclick="window.location='index.php?app=hops&action=listPeople'"/>

    </form>
</div>