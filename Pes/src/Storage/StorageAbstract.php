<?php
namespace Pes\Storage;

use Pes\Storage\Serializer\SerializerInterface;
use Pes\Storage\KeyValidator\KeyValidatorInterface;

/**
 * Description of StorageAbstract
 *
 * @author pes2704
 */
abstract class Framework_Storage_StorageAbstract implements IteratorAggregate {
    
    protected $serializer;
    protected $keyValidator;

    public function __construct(SerializerInterface $serializer, KeyValidatorInterface $keyValidator) {
        $this->serializer = $serializer;
        $this->keyValidator = $keyValidator;
    }
    
    protected function valueToStore($value) {
        return \serialize($value);
    }
    
    protected function valueRestored($value) {
        // http://php.net/manual/en/function.unserialize.php chris AT cmbuckley DOT co DOT uk ¶
        //unserialize returns false in the event of an error and for boolean false.
        $unserstring =  \unserialize($value);
        if ($unserstring == false AND $value !== serialize(false)) {
            throw new UnexpectedValueException("Value unserialization failed. Value isn\'t coorectly serialized or corrupted, this is first 200 characters:"
                    .  substr(print_r($value, TRUE), 0, 200));       
        }        
        return $unserstring;
    }
    
    protected function checkKeyValidity($key) {
        $nameString = (string) $key;
        if (!is_string($nameString)) {
            throw new UnexpectedValueException("Key must be string or convertible to string".print_r($key, TRUE));        }
        return $nameString;
    }    
    
    public function getIterator() {
        return new ArrayIterator($this->arrayContent);
    }    
    
    
}
