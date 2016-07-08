<?php 

// example script for using the CashnetFactory class

$data = [
  'store' => 'WCOBTEST',
  'itemcode' => 'WCOB-CAREER',
  'amount' => 42.21,
  'signouturl' => 'https://'.$_SERVER['SERVER_NAME'].$_SERVER['SCRIPT_NAME'],
  'CARDNAME_G' => 'Sam Walton'
];

$database_server   = 'localhost';
$database_username = 'tsc_UA_oO0cz';
$database_password = 'R7h6sTJ3aBoXLqev';
$database_name     = 'tsc_D_oO0cz';

// trump or modify with environment credentials
$credentials_file = __DIR__.'/../credentials.local.inc.php';
if (file_exists($credentials_file))
  require_once($credentials_file);

// autoload classes with composer
// https://getcomposer.org/
require_once __DIR__.'/../vendor/autoload.php';

use Puckett\Cashnet\CashnetFactory;

// set up your pdo database connection
// http://php.net/manual/en/book.pdo.php
$pdoDB = new PDO(
  "mysql:host=$database_server;dbname=$database_name;charset=utf8",
  $database_username,
  $database_password
);

// create object
$cf = new CashnetFactory($data, $pdoDB);

// get the rest of the fields
$cf->getEmptyCashnetGlobals();

// render form, allow override, and handle post
echo $cf->getForm(true);
