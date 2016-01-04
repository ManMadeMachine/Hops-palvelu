<link rel="stylesheet" href="media/hops/styles.css">

<h1>Uuden ryhmän luonti</h1>
<?php $tuutorit = $this->getTeachers(); ?>

<div id="newGroup">
    <form action="index.php?app=hops&action=saveNewGroup" method="post">
        <table class="headersGroup">
            <tr><td>Ryhmän tunnus</td></tr>
            <tr><td>Tuutorin tunnus</td></tr>
        </table>
        <table class="data">
            <tr><td><input type="text" name="tunnus" /></td></tr>
            <tr><td><select name="tuutori_tunnus">
            <option value=''>---</option>
            <?php 
                foreach($tuutorit as $tuutori)
                {
                    echo "<option value='" . $tuutori['tunnus'] . "'>" . $tuutori['tunnus'] . " " . $tuutori['etunimi']. " " .$tuutori['sukunimi'] . "</option>\n";
                }          
            ?>
            </select></td></tr>
        </table>
        <br><br><br>
        <input type="submit" id="save_group" value="Luo uusi"/>
        <input type="button" id="cancel" name="cancel" value="Peruuta" onclick="window.location='index.php?app=hops&action=listPeople'"/>
    
    </form>
</div>