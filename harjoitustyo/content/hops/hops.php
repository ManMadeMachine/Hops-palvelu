<?php

defined('SOME_PATH') or die("Unauthorized access!");

$user = SomeFactory::getUser();
$app = SomeFactory::getApplication();

if ($user->getUserrole() === 'registered' || $user->getUserrole() === 'student'){
	
}
else if ($user->getUserrole() === 'teacher') {
					
}

if (!$user->getId()){
    $app->redirect("index.php?app=login");
}
else {
    if ($user->getUserrole() === 'registered' || $user->getUserrole() === 'student') {
        include(PATH_CONTENT.DS.'controller'.DS.'student_hops.php');
        $controller = new SomeControllerStudentHops();
        $controller->execute();
    }
    else if ($user->getUserrole() === 'teacher') {
        include(PATH_CONTENT.DS.'controller'.DS.'teacher_hops.php');
        $controller = new SomeControllerTeacherHops();
        $controller->execute();       
    }
    else if ( $user->getUserrole() === 'headteacher') {
        include(PATH_CONTENT.DS.'controller'.DS.'headteacher_hops.php');
        $controller = new SomeControllerHeadteacherHops();
        $controller->execute(); 
    }
}


//$app = SomeFactory::getApplication();
//$app->setTemplate('hops');
?>