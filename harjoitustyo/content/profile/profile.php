<?php
defined('SOME_PATH') or die("Unauthorized access!");

$user = SomeFactory::getUser();
$app = SomeFactory::getApplication();

if(!$user->getId()){
	$app->redirect("index.php?app=login", "You need to be logged in!");
}
else{

	include(PATH_CONTENT.DS.'controller'.DS.'default.php');
	$controller = new SomeControllerDefault();
	$controller->execute();
}
?>