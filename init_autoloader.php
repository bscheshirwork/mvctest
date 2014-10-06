<?php

require_once $vendorPath."Symfony/Component/ClassLoader/UniversalClassLoader.php";  

use Symfony\Component\ClassLoader\UniversalClassLoader;  

$loader = new UniversalClassLoader(); 
$loader->registerNamespaces(array('Bscheshir' => __DIR__ . '/classes'));
$loader->register();
