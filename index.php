<?php

session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

//creating constant variables for the directories
define('CONFIG_DIR', __DIR__.'/config');
define('ASSETS_DIR', __DIR__.'/assets');
define('TEMPLATES_DIR', __DIR__.'/templates');
define('LOG_DIR', __DIR__.'/logs');
define('STORAGE_DIR', __DIR__.'/storage');
define('BIN_DIR', __DIR__.'/bin');

//includes.php have all needed pages inside for only one include
require __DIR__.'/includes.php';