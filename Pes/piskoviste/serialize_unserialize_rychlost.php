<?php
ini_set('memory_limit','512M');

$a = ['a'=>1, 'b'=>'yxcvbnm.-asdfghjklů§§§qwertzuiopú)+ěščřžýáíé=', 'yxcvbnm.-asdfghjklů§§§qwertzuiopú)+ěščřžýáíé='=>0, 'yxcvbnm.-asdfghjklů§§§qwertzuiopú)+ěščřžýáíé='=>'yxcvbnm.-asdfghjklů§§§qwertzuiopú)+ěščřžýáíé=',
    'childrens'=>[]];

$repeat = 8;  // maximum je 6 pro 64MB paměti (7 už chce 66MB), maximum při vyšší přidělené paměti zkolabuje asi serialize při 266MB požadované RAM

$start = microtime();
for($i = 1; $i < $repeat; ++$i) {
    $b = $a;
    for($j = 1; $j < $repeat; ++$j) {
        $b['childrens'][] = $a;
    }
    $a['childrens'][] = $b;    
}        
$t0 = microtime()-$start;
$ser = \serialize($a);
$t1 = microtime()-$t0;
$serLength = strlen($ser);
$t2 = microtime()-$t1;

$q=1;

// časy jsou s xdebugem, občas se místo např. 0.32 objeví 0.02 apod.!

// repeat serLength serialize [s]
//    3        4044  0.81
//    4       31621  0.92
//    5      327884  0.32
//    6     4252167  0.32
//    7    66322438  0.44

// je zjevné, že to jede paralelizovaně
