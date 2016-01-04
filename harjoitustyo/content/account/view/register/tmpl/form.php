<link rel="stylesheet" href="media/tinypicker/tinycolorpicker.css" type="text/css" media="screen"/>

<script type="text/javascript" src="media/tinypicker/jquery.tinycolorpicker.js"></script>

<script type="text/javascript">

jQuery(document).ready(function() {
   
jQuery("#registerForm").validate()
   
   var $box = $('#colorPicker');
            $box.tinycolorpicker();
            
   var plugin = $('#colorPicker').data("plugin_tinycolorpicker");
   console.log(plugin);
        plugin.setColor("#ff45cc");

    
    //box.bind("change", function()
    //{
    //    console.log("do something whhen a new color is set");
    //});
});

</script>
<?php
//register form comes here

$userdata = $this->userdata;
$errors = $this->errors;

$username = isset($userdata['username']) ? $userdata['username'] : '';
$email    = isset($userdata['email'])    ? $userdata['email']    : '';
$homepage = isset($userdata['homepage']) ? $userdata['homepage'] : '';




if (!empty($errors)) {
    ?>
    <strong><i><?php echo SomeText::_('CHECK FORM') ?></i></strong><br />
    <?php
    foreach ($errors as $error) {
        echo "<span style='color:red'>$error</span><br />\n";
    }
    echo "<br /><br />\n";

}

?>
<h1><?php echo SomeText::_('FILL FORM H1') ?></h1>

<form id="registerForm" action='index.php?app=account&view=register&tmpl=form' method='post'>
    <div>
    <?php echo SomeText::_('USERNAME') ?>: <input type='text' name='username' value='<?php echo $username  ?>' required />
<br />
Password: <input type='password' name='password' value='' required />
<br />
Password again: <input type='password' name='password2' value='' required />
<br />
Email: <input type='text' name='email' value='<?php echo $email  ?>' required />
<br />
Homepage: <input type='text' name='homepage' value='<?php echo $homepage  ?>' required />
<br />
<br />
</div>
    <div>
        <h3>Color:</h3>
<div id="colorPicker" style="width: 250px;">
  <a class="color"><div class="colorInner"></div></a>
        <div class="track"></div>
        <ul class="dropdown"><li></li></ul>
        <input type="hidden" class="colorInput"/>
</div>

    </div>
    <div>
    <input type="hidden" name="csrf" value="<?php echo SomeCSRF::newToken() ?>" />
<input type='submit' name='smit' value='Register' />
    </div>
</form>



<br />
Note:<br />
Username is mandatory and can have only alphabets, numbers and letters _ and -.
<br />
Email  is mandatory.
<br />
Homepage is mandatory.
<hr />
<a href='index.php?app=account&view=register&tmpl=form&language=en_GB'>english</a><br />
<a href='index.php?app=account&view=register&tmpl=form&language=fi_FI'>finnish</a><br />
