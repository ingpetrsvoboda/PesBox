<?php
require '../vendor/autoload.php';

require 'TestHelper.php';

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;


function modify($obj, $name, $value) {
    $obj->count++;
    $obj->{$obj->count} = $obj->count;
    $obj->$name = $value;
    return $obj;
}

function cloneWith($obj, $name, $value) {
    $new = clone $obj;
    $new->count++;
    $new->{$new->count} = $new->count;
    $new->$name = $value;
    return $new;
}

$helper = new TestHelper();

$helper->interval(TRUE);

$html = '';

$repeat = 10000;

$object = new \stdClass();

for ($i = 1; $i <= $repeat; $i++) {
    $object = modify($object, "jmeno", "Petr");
}

        $html .= '<h1>modify</h1>';
        $html .= '<p>'.$helper->interval().'</p>';

for ($i = 1; $i <= $repeat; $i++) {
    $new = cloneWith($object, "jmeno", "Petr");
}

        $html .= '<h1>cloneWith</h1>';
        $html .= '<p>'.$helper->interval().'</p>';


echo $html;
//echo "<pre>";
//print_r($object);
//print_r($new);
//echo "</pre>";
