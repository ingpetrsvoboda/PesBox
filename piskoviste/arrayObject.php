<?php
function vypis($nadpis, $obj) {
    echo '<p>'.$nadpis.'</p>'.PHP_EOL;
    echo '<pre>'.print_r($obj, TRUE).'</pre>'.PHP_EOL;
    echo '<table style="border: 1px solid black; padding: 10px;">'.PHP_EOL;
    foreach ($obj as $key => $value) {
        echo '<tr>'.PHP_EOL;
        echo '<td>'.$key.'</td><td>'.print_r($value, TRUE).'</td>'.PHP_EOL;
        echo '</tr>'.PHP_EOL;
    }
    echo '</table>'.PHP_EOL;
}

//http://stackoverflow.com/questions/14610307/spl-arrayobject-arrayobjectstd-prop-list/16619183#16619183

$array = array('b'=>'becko', 'a'=>'acko');
$ao = new \ArrayObject($array);
vypis('Puvodni pole:', $ao);

$ao->append('kvecko');
$ao->append('wecko');
vypis('append kvecko, wecko:', $ao);

$ao->ksort();
vypis('ksort', $ao);

$ao->asort();
vypis('asort', $ao);

$ao->offsetSet('bb', 'bebecko');
vypis('append \'bb\'=>\'bebecko\':', $ao);

$ao->ksort();
vypis('ksort', $ao);

$ao[] = 'policko';
vypis('Pridano policko jako do array', $ao);

$ao->vlastnost = 'vlastnosticko';
vypis('Pridano vlastnosticko jako vlastnost', $ao);

$ao->offsetSet(0, 'nova nula');
vypis('pffsetSet(0, \'nova nula\':', $ao);

$object = new \stdClass();
$object->vlastnost = 'prvni';
$ao->offsetSet(spl_object_hash($object), $object);
$object->vlastnost = 'druhy';
$ao->offsetSet(spl_object_hash($object), $object);
vypis('Metodou offsetSet pridan 2x tentyz objekt s indexem spl_object_hash($object):', $ao);

$object = new \stdClass();
$ao->offsetSet(spl_object_hash($object), $object);
vypis('Metodou offsetSet pridan dalsi (jiny) objekt s indexem spl_object_hash($object):', $ao);
