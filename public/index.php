<?php
ini_set('display_errors', E_ALL);

chdir(dirname(__DIR__));

$vendorPath = __DIR__."/../vendor/";
define('VIEW_PATH', __DIR__."/../classes/Bscheshir/View");

// Setup autoloading
require 'init_autoloader.php';

// Run the application!
Bscheshir\Application::init(require 'config/application.config.php')->run();
