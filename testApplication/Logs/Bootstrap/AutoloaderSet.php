<?php
require "../Pes/src/Autoloader/Autoloader.php";

use Pes\Autoloader\Autoloader;

$pesAutoloader = new Autoloader();
$pesAutoloader->register();
$pesAutoloader->addNamespace('Pes', '../Pes/src/');
$pesAutoloader->addNamespace('TestApplication', '');

require "../Pes/vendor/autoload.php";    // composer autoloader - při změně struktury nebo namespace je třeba volat: composer upgrade (případně upravit composer.json)
