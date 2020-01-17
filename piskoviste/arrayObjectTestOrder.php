<?php
class EntitkaForMapCollectionTest {
    public $a, $n, $x;
    public function __construct($a, $n, $x) {
        $this->a = $a;
        $this->n = $n;
        $this->x = $x;
    }
    
    // cvičná metoda toString - objekty ve vlastnostech jsou tříděny pokaždé v jiném pořadí
    public function __toString() {
        return microtime();
    }
}

$test = array(
    array("a"=>"004", "n"=>"03", "x"=>"1"),
    array("a"=>"003", "n"=>"01", "x"=>"5"),
    array("a"=>"001", "n"=>"02", "x"=>new EntitkaForMapCollectionTest('blx', 'ble', 'bli')),
    array("a"=>"003", "n"=>"02", "x"=>"1"),
    array("a"=>"003", "n"=>"01", "x"=>"aa"),
    array("a"=>"001", "n"=>"02", "x"=>new EntitkaForMapCollectionTest('bla', 'ble', 'bli')),
    array("a"=>"005", "n"=>"01", "x"=>"1"),
    array("a"=>"001", "n"=>"01", "x"=>"1"),
    array("a"=>"004", "n"=>"02", "x"=>"1"),
    array("a"=>"003", "n"=>"01", "x"=>"1"),
    array("a"=>"004", "n"=>"01", "x"=>"1")
);

$testEntitek = array(
    new EntitkaForMapCollectionTest('004', '03', '1'),
    new EntitkaForMapCollectionTest('003', '01', '5'),
    new EntitkaForMapCollectionTest('001', '02', new EntitkaForMapCollectionTest('blx', 'ble', 'bli')),
    new EntitkaForMapCollectionTest('003', '02', '1'),
    new EntitkaForMapCollectionTest('003', '01', 'aa'),
    new EntitkaForMapCollectionTest('001', '02', new EntitkaForMapCollectionTest('bla', 'ble', 'bli')),
    new EntitkaForMapCollectionTest('005', '01', '1'),
    new EntitkaForMapCollectionTest('001', '01', '1'),
    new EntitkaForMapCollectionTest('004', '02', '1'),
    new EntitkaForMapCollectionTest('003', '01', '1'),
    new EntitkaForMapCollectionTest('004', '01', '1'),
);

function vypis($nadpis, $obj) {
    echo '<p>'.$nadpis.'</p>'.PHP_EOL;
//    echo '<pre>'.print_r($obj, TRUE).'</pre>'.PHP_EOL;
    echo '<table style="border: 1px solid black; padding: 10px;">'.PHP_EOL;
    foreach ($obj as $key => $value) {
        echo '<tr>'.PHP_EOL;
        echo '<td>'.$key.'</td><td>'.print_r($value, TRUE).'</td>'.PHP_EOL;
        echo '</tr>'.PHP_EOL;
    }
    echo '</table>'.PHP_EOL;
}
// verze pro ORDER - řadí s použitím strcmp - pokud prvek pole nebo vlastnost onjektu není převoditelná na string hlásí warning
//  - ale nějak taky třídí
//  POZOR - pokud členy kolekce jako vlastnosti mají objekty, které nejdou převést na řetězce (nemají __toString) vyhazuje warning
//  Warning: strcmp() expects parameter 1 to be string, object given
//    
//  Tuto verzi lze použít tak, že pro databáze se stejné pole order použije pro vytvoření SELECTu pokud ještě nebyla načtena data 
//  do kolekce, pokud už byla setřídí se se stejným parametrem kolekce
$comparators = array(
    'ASC' => function ($a, $b) {return strcmp($a, $b);},
    'DESC' => function ($a, $b) {return strcmp($b, $a);},
);

// verze pro SORT - vylepšené řazení - pokud je to skalár nebo objekt s metodou __toString, řadí podle řetězcové hodnoty, 
// nestringovatelný objekt serializuje a porovnává serializované podoby. V reálu to jde použít, obvykle pro řazení v zobrazeném seznamu.
// myslím, že to bude umět např. objekt Identity
//$comparators = array(
//        'ASC' => function ($a, $b) {
//                if (is_scalar($a) OR method_exists($a, '__toString')) {
//                    $stra = (string) $a;
//                } else {
//                    $stra = serialize($a);
//                }
//                if (is_scalar($a) OR method_exists($a, '__toString')) {
//                    $strb = (string) $b;
//                } else {
//                    $strb = serialize($b);
//                }
//                return strcmp($stra, $strb);
//            },
//        'DESC' => function ($a, $b) {
//                if (is_scalar($a) OR method_exists($a, '__toString')) {
//                    $stra = (string) $a;
//                } else {
//                    $stra = serialize($a);
//                }
//                if (is_scalar($a) OR method_exists($a, '__toString')) {
//                    $strb = (string) $b;
//                } else {
//                    $strb = serialize($b);
//                }
//                return strcmp($strb, $stra);
//            },
//    );
//

$order = array(
    "a"=>'DESC',
    "n"=>'ASC', 
    "x"=>'DESC'    
);

//$order = array(
//    "n"=>'ASC'
//);

// POLE
$ao = new \ArrayObject($test);
     
$ao->uasort(function (array $a, array $b) use ($comparators, $order){
                foreach($order as $key=>$style){
                    $res = $comparators[$style]($a[$key], $b[$key]);
                    if($res!=0) break;
                }
                return $res;
            }
        );

vypis('Setridene pole:', $ao);

// OBJEKTY Entitky
$ao = new \ArrayObject($testEntitek);

$ao->uasort(function ($a, $b) use ($comparators, $order){
                foreach($order as $key=>$style){
                    $res = $comparators[$style]($a->$key, $b->$key);
                    if($res!=0) break;
                }
                return $res;
            }
        );

vypis('Setridene pole:', $ao);