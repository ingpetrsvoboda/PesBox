<?php
        // pokud pole není asociativní (nebo i jen některý prvek pole není) php vyrobí pole po svém
        // chybějící index -> php dodá integer o jednu větší než poslední použitý integer index, 
        // index lze převést na integer (je to integer, float ořízne 
        // na celé číslo, řetězec "123" převede na 123) -> php převede zadaný index na integer
        // např. $a = array('aaaa','bbbb',1=>'cccc',"5"=>'dddd','eeee'); -> vznikne ([0]=>'aaaa',[1]=>'cccc',[5]=>'dddd',[6]=>'eeee')

//  http://stackoverflow.com/questions/173400/how-to-check-if-php-array-is-associative-or-sequential


function isSequential($value){
    if(is_array($value) || ($value instanceof \Countable && $value instanceof \ArrayAccess)){
        for ($i = count($value) - 1; $i >= 0; $i--) {
            if (!isset($value[$i]) && !array_key_exists($i, $value)) {
                return false;
            }
        }
        return true;
    } else {
        throw new \InvalidArgumentException(
            sprintf('Data type "%s" is not supported by method %s', gettype($value), __METHOD__)
        );
    }
}

$a = array(
    'aaaa',
    'bbbb',
    1=>'cccc',
    "5"=>'dddd',
    'eeee',
    'ff',
    'gg'=>'gggg',
    'hh'
);
$b = array();
$c = new \ArrayObject($a);

$q =  isSequential($a);
$q =  isSequential($b);
$q =  isSequential($c);
$qq=1;