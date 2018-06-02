<?php

// which version of the site
define('SERVER', 'local');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ( defined('SERVER') && SERVER != 'live' ) {
    $GLOBALS['time'] = microtime(true);
}

include 'application/initialize.php';

$app = new App();