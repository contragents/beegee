<?php
ini_set("display_errors", 1); error_reporting(E_ALL);
$config = require(__DIR__ . '/config.php');
require_once('autoload.php'); 
(new App\Application($config))->Run();
?>