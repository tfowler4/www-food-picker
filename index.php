<?php

// which version of the site
define('SERVER', 'local');

error_reporting(E_STRICT);

if ( defined('SERVER') && SERVER != 'live' ) {
    $GLOBALS['time'] = microtime(true);
}

include 'application/initialize.php';

$app = new App();