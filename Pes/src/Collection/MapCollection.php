<?php
namespace Pes\Collection;

/**
 * Generic Collection class
 * 
 */
class MapCollection extends CollectionAbstract implements MapCollectionInterface {
    /**
     * Provede validavi hodnoty zadaného prvku a validní prvek přidá dok kolekce se zadaným indexem. Pro nevalidní prvek nedělá nic.
     * Podle indexu, se lterým byl prvek přidán lze prvek získa metodou get().
     * 
     * @param mixed $index Index, se kterým bude prvek přidán.
     * @param mixed $value Hodnota prvku.
     * 
     * @return void Nevrací žádnou návratová hodnotu.
     */
    public function set($index, $value) {
        if(isset($this->validator)) {
            if ($this->validator->isValid($value)) {
                $this->internalStorage->offsetSet($index, $value);
            }
        } else {
            $this->internalStorage->offsetSet($index, $value);            
        }
        return $this;
    }

    /**
     * Odstraní člena kolekce podle zadaného indexu. Index je parametr index, se kterým byl prvek přidán do kolekce. Pokud prvek 
     * se zadaným indexem v kolekci neexistuje, metoda nedělá nic.
     * 
     * @param mixed $index Index prvku, který má být odstraněn.
     * @return void Nevrací žádnou návratová hodnotu.
     */    
    public function remove($index) {
        if ($this->has($index)) {
            $this->internalStorage->offsetUnset($index);
        }
        return $this;
    }

    /**
     * Vrací hodnotu člena kolekce se zadaným indexem. Index je parametr index, se kterým byl prvek přidán do kolekce. Pokud prvek 
     * se zadaným indexem v kolekci neexistuje, metoda vrací NULL.
     *
     * @param mixed $index Index prvku.
     * @return mixed Hodnota prvku se zadaným indexem nebo NULL.
     */    
    public function get($index) {
        if ($this->has($index)) {
            return $this->internalStorage->offsetGet($index);
        }
    }
    
    /**
     * Zjistí, zda prvek se zadaným indexem je v kolekci.
     * @param mixed $index Index prvku.
     * @return boolean
     */
    public function has($index) {
        return $this->internalStorage->offsetExists($index);
    }
    
    /**
     * Přidá do kolekce nový obsah zadaný formou asociativního pole.
     * Indexy pole se použijí jako indexy prvků, hodnoty pole jako hodnoty prvků.
     * 
     * Pozor - pokud pole není definováno jako asociativní (stačí když jen některý prvek pole není - nemá klíč) php vyrobí pole po svém.
     * Například:
     * chybějící index -> php dodá integer odpovídající pozici kurzoru pole, index lze převést na integer (je to integer, float ořízne 
     * na celé číslo, řetězec "123" převede na 123) -> php převede zadaný index na integer
     * např. $a = array('aaaa','bbbb',1=>'cccc',"5"=>'dddd','eeee'); -> vznikne ([0]=>'aaaa',[1]=>'cccc',[5]=>'dddd',[6]=>'eeee')
     * 
     * @param array $newArray
     */
    public function mergeArrayContent(array $newArray=[]) {

        foreach ($newArray as $index=>$value) {
            $this->set($index, $value);
        }
        return $this;
    }        
}

