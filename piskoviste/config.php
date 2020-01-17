<?php

/*
 * Copyright (C) 2019 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
include '../Pes/src/Bootstrap/Bootstrap.php';

use Pes\Config\Config;
use Pes\Debug\Timer;

$timer = new Timer();
echo $timer->start();

echo '<pre>';
$xmlFullFileName = 'ConfigProjektor.xml';
$config = new Config($xmlFullFileName);
echo 'Instantiation : '. $timer->interval();

$export = $config->getSection('export');
print_r($export);
echo 'getSection : '. $timer->interval();

$database = $config->getSection('database');
print_r($database);
echo 'getSection : '. $timer->interval();

$data = $config->getElement('connectioninfo', 'name', 'Projektor');
print_r($data);
echo 'getElement : '. $timer->interval();

$data = $config->queryElement('database/connectioninfo');
print_r($data);
echo 'queryElement : '. $timer->interval();

$data = $config->queryElement("database/connectioninfo[@name='Projektor']");
print_r($data);
echo 'queryElement : '. $timer->interval();

echo '</pre>';
