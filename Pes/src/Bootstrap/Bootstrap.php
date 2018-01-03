<?php
/**
 * Bootstrap 
 * Počáteční nastavení auloloderu, prostředí, error a exception handlerů
 */
// globální proměnné první
include "GlobalsSet.php";
// autoloader jako druhý - v dalších částech jsou používány objekty
// AutoloaderSet.php je umístěn v kořenovém adresáři aplikace (např. vedle kořenového souboru aplikace index.php)
include getcwd()."/AutoloaderSet.php";
// doporučení k nastavené PHP (php.ini)
include "CheckPhpSettings.php";
// časké timezone a locale
include "CzechZoneSet.php";
// error reporting, error handlery, exception handlery
include "ErrorHandlingSet.php";
// Asserce (zend.assertions´) a expektace (assert.exception) nastavované podle stroje, na kterém kód běží - dáno globálními proměnnými
include "AssertionsExpectationsSet.php";
