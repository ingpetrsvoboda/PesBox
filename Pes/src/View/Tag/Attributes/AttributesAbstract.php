<?php

namespace Pes\View\Tag\Attributes;

/**
 * Description of AttributesAbstract
 *
 * @author pes2704
 */
abstract class AttributesAbstract implements AttributesInterface, \IteratorAggregate, \Countable {

    /**
     * Nastaví hodnoty atributů podle asociativního pole zadaného jako parametr. 
     * V případě, že pole obsahuje prvek se jménem, které neodpovídá žádnému existujícímu atributu elementu metoda vyhodí uživatelskou chybu E_USER_NOTICE.
     */
    public function __construct(array $attributes=[]) {
        $this->setAttributesArray($attributes);
    }
    
    /**
     * {@inheritdoc}
     */    
    public function getAttributesArray() {
        return iterator_to_array($this->getIterator(), TRUE);
    }
    
    /**
     * {@inheritdoc}
     * V případě, že pole obsahuje prvek se jménem, které neodpovídá žádnému existujícímu atributu elementu metoda vyhodí uživatelskou chybu E_USER_NOTICE.
     */    
    public function setAttributesArray($attributesArray=array()) {
        if ($attributesArray) {
            $definedAttributes = get_object_vars($this);
            foreach ($attributesArray as $key => $value) {
                if (array_key_exists($key, $definedAttributes)) {
                    $this->$key = $value;
                } else {
                    user_error('Nelze nastavit nedefinovaný atribut. Atribut "'.$key.'" není v atributech '.get_called_class().' definován.', E_USER_NOTICE);
                }
            }
        }
    }

    /**
     * {@inheritdoc}
     */    
    public function getString() {
        foreach ($this->getIterator() as $key => $value) {
            if ($value) {
                if(is_bool($value)) {
                    $attr[] = $key;
                } else {
                    $attr[] = $key.'="'.trim($value).'"';
                }
            }
        }
        return isset($attr) ? implode(' ', $attr) : '';
    }
    
    public function __toString() {
        return $this->getString();
    }
    
    /**
     * Metoda vrací iterátor obsahující atributy elementu
     * @return \ArrayIterator
     */
    public function getIterator() {
        $defined = array();
        foreach (get_object_vars($this) as $key=>$val) {
            if ($val) {
                $defined[$key] = $val;
            }
        }
        return new \ArrayIterator($defined);  // vrací properties, které mají hodnotu
    }
    
    public function count(): int {
        return $this->getIterator()->count();
    }
}

