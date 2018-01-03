<?php

/* 
 * Copyright (C) 2017 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

use Pes\Logger\FileLogger;

$time = date('Y-m-d H:i:s');
// takto je $phpSettingsWarning vidět při debugování (samozřejmě - hlavní je číst PhpSettingsWarning.log na produkčním stroji!)
if (ini_get('session.use_strict_mode') == 0) {
    $phpSettingsWarning[] = "[$time] Je vypnutý 'session.use_strict_mode'!";
}
if (ini_get('session.use_cookies') == 0) {
    $phpSettingsWarning[] = "[$time] Je vypnutý 'session.use_cookies'!";
}
if (ini_get('session.use_only_cookies') == 0) {
    $phpSettingsWarning[] = "[$time] Je vypnutý 'session.use_only_cookies'!";
}
if ((ini_get('session.gc_divisor')/ini_get('session.gc_probability')) > 100) {
    $phpSettingsWarning[] = "[$time] Garbage collection se spouští jen jednou za ".(ini_get('session.gc_divisor')/ini_get('session.gc_probability')) ." spuštění skriptu! Např. session tak může být uklizena za dlouhou dobu.";    
}
        
//        session.gc_maxlifetime
if (isset($phpSettingsWarning)) {
    foreach ($phpSettingsWarning as $value) {
        FileLogger::getInstance('Logs', 'PhpSettingsWarning.log', FileLogger::REWRITE_LOG)->warning($value);    
    }
}
