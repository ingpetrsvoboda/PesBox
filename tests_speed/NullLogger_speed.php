<?php
require '../vendor/autoload.php';

require 'TestHelper.php';

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;


function volejMeLevnyLog(LoggerInterface $logger) {
    $logger->alert('');
}

function volejMeDrahyLog(LoggerInterface $logger) {
    
        $message = 'Doplňovačka: {raz} qwertzuiop {dva} qwertzuiop {tri} qwertzuiop {ctyri} qwertzuiop {pet} qwertzuiop {sest} qwertzuiop {sedm} qwertzuiop!'; 
        $context = array('raz'=>'asdfghjkl',
                'dva'=>'asdfghjkl',
                'tri'=>'asdfghjkl',
                'ctyri'=>'asdfghjkl',
                'pet'=>'asdfghjkl',
                'sest'=>'asdfghjkl',
                'sedm'=>'asdfghjkl'
                );
            // build a replacement array with braces around the context keys
        $replace = array();
        foreach ($context as $key => $val) {
            // check that the value can be casted to string
            if (!is_array($val) && (!is_object($val) || method_exists($val, '__toString'))) {
                $replace['{' . $key . '}'] = $val;
            }
        }

        // interpolate replacement values into the message and return
        $logger->alert(strtr($message, $replace));
}

function volejMeBezLoggeru(LoggerInterface $logger=NULL) {
    if (isset($logger)) {
        $logger->alert('');
    }
}

$helper = new TestHelper();

$helper->interval(TRUE);
$logger = new NullLogger();
$html = '';

$repeat = 1000;

for ($i = 1; $i <= $repeat; $i++) {
    volejMeLevnyLog($logger);
}

        $html .= '<h1>volejMeLevnyLog</h1>';
        $html .= '<p>'.$helper->interval().'</p>'; 
        
for ($i = 1; $i <= $repeat; $i++) {
    $logger = new NullLogger;
    volejMeLevnyLog($logger);
}

        $html .= '<h1>volejMeLevnyLog s opakovaným instancováním NullLoggeru</h1>';
        $html .= '<p>'.$helper->interval().'</p>';         
        
for ($i = 1; $i <= $repeat; $i++) {
    volejMeDrahyLog($logger);
}

        $html .= '<h1>volejMeDrahyLog</h1>';
        $html .= '<p>'.$helper->interval().'</p>'; 

for ($i = 1; $i <= $repeat; $i++) {
    volejMeBezLoggeru();
}

        $html .= '<h1>volejMeBezLoggeru</h1>';
        $html .= '<p>'.$helper->interval().'</p>';         
        
echo $html;        

//1000x
//
//volejMeLevnyLog
//
//Interval: 0.019760131835938 sec
//
//volejMeLevnyLog s opakovaným instancováním NullLoggeru
//
//Interval: 0.018157958984375 sec
//
//volejMeDrahyLog
//
//Interval: 0.040694952011108 sec
//
//volejMeBezLoggeru
//
//Interval: 0.0048830509185791 sec