<?php
require '../../vendor/autoload.php';

//$reflxPdo = new ReflectionClass('\PDO');
$reflxPdo = new ReflectionClass('\Pes\Database\Handler\Handler');
$constants = $reflxPdo->getConstants();
$categories = array(
    'PARAM'=>array('EVT' => array()),
    'FETCH'=>array('ORI' => array()),
    'ATTR'=>array(),
    'ERRMODE'=>array(),
    'CASE'=>array(),
    'NULL'=>array(),
    'ERR'=>array(),
    'CURSOR'=>array(),
    'SQLSRV'=>array('ATTR' => array(),
                    'PARAM' => array(),
                    'ENCODING' => array(),
                    'CURSOR' => array(),
                    'TXN' => array(),
        ),
    'MYSQL'=>array('ATTR' => array()),
        
    );

foreach ($constants as $name => $value) {
    $explodedName = explode('_', $name, 3);
    // 1. úroveň kategorie
    if (key_exists($explodedName[0], $categories)) {
        // 2. úroveň kategorie
        if (key_exists($explodedName[1], $categories[$explodedName[0]])) {
            $categories[$explodedName[0]][$explodedName[1]][$name] = $value;
        } else {
            $categories[$explodedName[0]][$name] = $value;            
        }
    } else {
        $categories['NOT_MATCHED_ATTRIBUTES'][$name] = $value; 
    }
}

$a = 1;

