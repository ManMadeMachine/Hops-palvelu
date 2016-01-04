<?php
defined('SOME_PATH') or die('Unauthorized access');
/**
* @package content
* @subpackage user
*/

#
# this is user content bootstrap
# 
$user = SomeFactory::getUser();
$app = SomeFactory::getApplication();




#
# create controller here and call its execute. See 
#  content/example, content/hello or content/numberguessmvc  for examples.
#

include(PATH_CONTENT.DS.'controller'.DS.'default.php');
$c = new SomeControllerDefault();
$c->execute();

/*
Kun tänne tullaan (etusivulle), vaihdetaan kirjautumisen ajaksi template=login
*/

$app->setTemplate('login');