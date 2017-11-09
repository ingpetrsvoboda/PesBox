<?php

/* 
 * Příklady nastavení autoloaderu
 */

// composer autoloader
######### AUTOLOADER #######################################
require "vendor/autoload.php";    // composer autoloader - při změně struktury nebo nemespace je třeba uptavit composer.json a volat: composer upgrade

// Pes autoloader
########## AUTOLOAD ###################################
require "../../Pes/Pes/src/Autoloader/Autoloader.php";

use Pes\Autoloader\Autoloader;

$pesAutoloader = new Autoloader();
$pesAutoloader->register();
$pesAutoloader->addNamespace('Pes', '../../Pes/Pes/src/'); //autoload pro namespace Pes
$pesAutoloader->addNamespace('Helper', '../Helper/'); //autoload pro namespace Pes
$pesAutoloader->addNamespace('Psr\Log', '../vendor/psr/log/Psr/Log'); //autoload pro namespace Psr