<?php
namespace Pes\Collection;

/**
 * Description of SetCollection
 *
 * @author pes2704
 */
class SetCollection extends CollectionAbstract implements SetCollectionInterface {
        
    /**
     * Pokud je nastaven validátor, metoda provede validaci parametru s použitím validátoru a pokud je parametr validní prvek, přidá jej do kolekce. Pokud ne, nedělá nic.
     * Pokud není nastaven validátor, metoda prvek přidá vždy.
     * Pokud prvek je již v kolekci obsažen, metoda nahradí starý prvek novým.
     * 
     * @param mixed $element Prvek, který má být přidán.
     */
    public function set($element) {
        if(isset($this->validator)) {
            if ($this->validator->isValid($element)) {
                $this->internalStorage->offsetSet($this->getIndex($element), $element);
            }
        } else {
            $this->internalStorage->offsetSet($this->getIndex($element), $element);
        }
        return $this;
    }
    
    /**
     * Přidá do kolekce objekty zadané jako pole objektů.
     * @param array $newArray
     */
    public function mergeArrayContent(array $newArray=[]) {
        foreach ($newArray as $object) {
            $this->set($object);
        }
        return $this;
    } 
    
    /**
     * Zjistí, zda je zadaný prvek v kolekci.
     * @param mixed $element Prvek, jehož přítomnost v kolekci zjišťuji.
     * @return boolean
     */
    public function has($element) {
        $index = $this->getIndex($element);
        return $this->hasByIndex($index);
    }
    
    /**
     * Odstraní zadaný prvek z kolekce.
     * @param mixed $element Prvek kolekce, který má být smazán..
     */    
    public function remove($element) {
        $index = $this->getIndex($element);
        if ($this->hasByIndex($index)) {            
            $this->internalStorage->offsetUnset($index);
        }
        return $this;
    }

    /**
     * 
     * @param type $index
     * @return boolean
     */
    private function hasByIndex($index) {
        return $this->internalStorage->offsetExists($index) ? TRUE : FALSE;
    }
    /**
     * Privátní metoda - generuje index, pod kterým je prvek ukládán v kolekci.
     * @param type $param
     * @return type
     */
    private function getIndex($param) {
        if (is_object($param)){
            return spl_object_hash($param);
        } else {
            return $param;
        }
    }    
}
