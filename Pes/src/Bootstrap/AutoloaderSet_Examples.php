<?php

/* 
 * Příklady nastavení autoloaderu
 */

throw new Exception("V souboru Bootsrap je třeba zadat skutečné nastaví autoladeru.");

// composer autoloader
######### AUTOLOADER #######################################
require "vendor/autoload.php";    // composer autoloader - při změně struktury nebo namespace je třeba volat: composer upgrade (případně upravit composer.json)

// Pes autoloader
########## AUTOLOAD ###################################
require "../../Pes/Pes/src/Autoloader/Autoloader.php";

use Pes\Autoloader\Autoloader;

$pesAutoloader = new Autoloader();
$pesAutoloader->register();
$pesAutoloader->addNamespace('Pes', '../../Pes/Pes/src/'); //autoload pro namespace Pes
$pesAutoloader->addNamespace('Helper', '../Helper/'); //autoload pro namespace Pes
$pesAutoloader->addNamespace('Psr\Log', '../vendor/psr/log/Psr/Log'); //autoload pro namespace Psr