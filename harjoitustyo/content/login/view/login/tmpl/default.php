<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<style type="text/css">

p {
    font-family: 'Open Sans', sans-serif;
}

input
{
    border-radius: 15px;
    border:solid 1px black;
    padding:5px;
    text-align: center;
    margin: 5px;
}

label
{
    font-family: 'Open Sans', sans-serif;
    color: #19578A;
}

</style>
</head>

<?php 
if (SomeFactory::getApplication()->getSysMessage()) {
	echo "<div class='errormsg'>".SomeFactory::getApplication()->getSysMessage()."</div>";
}

?>

<p> Palvelu Tampereen yliopiston opettajien ja opiskelijoiden välistä HOPS-yhteistyötä varten. <br>
HOPS-palvelun avulla helpotetaan opintojen suunnittelua ja HOPS-ryhmien valvontaa. <br>
Palveluun kirjaudutaan opiskelija-/opettajanumerolla. </p>
<br>

<?php
$app = SomeFactory::getApplication();

?>

<?php 
if (SomeFactory::getUser()->getId() > 0) {
	
	?>
	<a href="index.php?app=login&view=logout">Log Out <?php echo SomeFactory::getUser()->getUsername() ?></a>
	<?php 
	
} else {

?>

<form action='index.php?app=login&view=login' method='post'>
<label for='username'>Käyttäjätunnus:</label>
<br> <input type='text' name='username' value='' />
<br />
<label for='password'>Salasana:</label>
<br><input type='password' name='password' value='' />
<br />
<input type='submit' name='smit' value='Kirjaudu' />
</form>

<?php 
}
?>