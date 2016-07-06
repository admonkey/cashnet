<?php 

// example script for using the CashnetFactory class

$data = [
  'store' => 'WCOBTEST',
  'itemcode' => 'WCOB-CAREER',
  'amount' => 42.219,
  'signouturl' => 'https://localhost/callback.php',
  'CARDNAME_G' => ''
];

$database_server   = 'localhost';
$database_username = 'tsc_UA_oO0cz';
$database_password = 'R7h6sTJ3aBoXLqev';
$database_name     = 'tsc_D_oO0cz';

// some ODBC driver examples
$mssql             = 'ODBC Driver 13 for SQL Server';
$easysoft          = 'Easysoft ODBC-SQL Server';

// PDO database connection string examples
$mysql             = "mysql:host=$database_server;dbname=$database_name;charset=utf8";
$odbc              = "odbc:Driver=$mssql;Server=$database_server;Database=$database_name";

$pdo_database_connection_string = $odbc;

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
$pdoDB = new PDO($pdo_database_connection_string, $database_username, $database_password);

// create object
$cf = new CashnetFactory($data, $pdoDB);
// $cf = new CashnetFactory($data);

// render form and handle post
echo $cf->getForm(false);
