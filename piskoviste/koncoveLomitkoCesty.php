<?php
    $repeat = 1000;
    $directoryPath = __DIR__;  
    $directoryPath = __DIR__.'\\';  
    $directoryPath = str_replace('/', '\\', $directoryPath);
    
    
        $start = microtime();
        for($i = 0; $i < $repeat; ++$i) {
        }        
        $t0 = $start-microtime();
        
        $start = microtime();        
        for($i = 0; $i < $repeat; ++$i) {
            $directoryPath2 = str_replace('/', '\\', $directoryPath);  //obrácená lomítka
            if (substr($directoryPath2, -1)!=='\\') {  //pokud path nekončí znakem obrácené lomítko, přidá ho
                $directoryPath2 .='\\';
            }
        }       
            
        $t1 = $start-microtime()-$t0;      
        $start = microtime();
        for($i = 0; $i < $repeat; ++$i) {
            $directoryPath2 = rtrim(str_replace('/', '\\', $directoryPath), '\\').'\\';
        }  
        $t2 = $start-microtime()-$t0;
$a = 1;