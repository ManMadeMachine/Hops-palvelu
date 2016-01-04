<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>HOPS-järjestelmä - Etusivu</title>
<link rel="stylesheet" type="text/css" href="template/default/main.css" />
<link rel="stylesheet" type="text/css" href="template/default/template.css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/jquery-ui.min.js"></script>

<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.js"></script>



</head>
<body>

         <!-- Begin Header -->
         <div id="header">
		 
		       <h1>HOPS-järjestelmä</h1>
		       <?php
		        $user = SomeFactory::getUser();
                if ($user->getUserrole() === 'student')
                {
                    echo "<h2>Opiskelijan puoli</h2>";
                }
                else if ( $user->getUserrole() === 'teacher')
                {
                    echo "<h2>Tuutorin puoli</h2>";
                }
                else if (  $user->getUserrole() === 'headteacher')
                {
                    echo "<h2>Ylituutorin puoli</h2>";
                }
                       
                echo "<div id='login'>";
                if ($user->userrole != 'guest') {
                    echo "<div>$user->username (<a href='?app=login&view=logout'>Kirjaudu ulos</a>)</div>";
                } 
                else {
                    echo "<a href='?app=login'>Kirjaudu sisään</a>";
                }
                echo " </div>";
            ?>
		 </div>
		 <!-- End Header -->
		 
		 <!-- Begin Navigation -->
         <div id="navigation">
		 	
		 	<div class="menu">
		 	    <?php
		 	    $user = SomeFactory::getUser();
		 	    if ($user->getUserrole() === 'student')
		 	    {
		 	        include('template/default/menuStudent.php');
		 	    }
		 	    else if ($user->getUserrole() === 'teacher')
		 	    {
		 	        include('template/default/menuTeacher.php');
		 	    }
		 	    else if ($user->getUserrole() === 'headteacher')
		 	    {
		 	        include('template/default/menuHeadteacher.php');
		 	    }
		 	    ?>
		 	    
                
            </div>	
			   
		 </div>
		 <!-- End Navigation -->
		 
		 <!-- Begin Content Column -->
		<div id="content" class="cf">
		       
	        <some:content />
		       
			<div class="clear"></div>
			   
		</div>
		    <!-- End Content Column -->
			   
         <!-- Begin Footer -->
         <div id="footer">
		       
               Emmi Siitonen & Eetu Suonpää 
               Tietokantaohjelmoinnin ja WWW-ohjelmoinnin 2015 harjoitustyö	

         </div>
		 <!-- End Footer -->
		 
</body>
</html>