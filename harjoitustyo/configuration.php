<?php
// CONFIGURATION FOR PREDABASE

    defined('SOME_PATH') or die('Unauthorized access');
    $configuration = array (
  'common' => 
  array (
    'livesite' => '',
    'language' => 'fi_FI',
    'secret' => 'safsf543fyg43hydrth',
    'template' => 'default',
  ),
  'session' => 
  array (
    'lifetime' => '45',
    'session_handler' => 'file',
    'session_table' => 'somesession',
  ),
  'database' => 
  array (
      'isused' => '1',
    'databasedriver' => 'pdopostgres',
    'databasehost' => 'dbstud.sis.uta.fi',
    'database' => 'es98580',
    'dbuser' => 'es98580',
    'dbpass' => 'kellopeli',
  ),
  'debug' => 
  array (
    'debug' => '0',
    'debugfile' => 'debug.log',
  ),
);
