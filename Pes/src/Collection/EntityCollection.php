<?php
namespace Pes\Collection;

use Pes\Validator\ValidatorInterface;
use Pes\Entity\Persistable\IdentityInterface;
use Pes\Entity\Persistable\PersistableEntityInterface;

/**
 * EntityCollection class
 * 
 */
class EntityCollection extends CollectionAbstract implements EntityCollectionInterface {

    /**
     * @var \ArrayObject 
     */
    private $identityMap;
    
    public function __construct(array $array=NULL, ValidatorInterface $validator) {
        
        //asi:
        // zlikvidovat celou entity collection a používat jen setCollection, všechny operace s identity map přesunoz do specialitovaného ubjektu identity map
        // taj, jak je to tady - záleží na pořadí set - persostována (!! nemá identity v identity map!) nebo persostována - set má identity v identity map a to nemůže dělat dobrotu
        // navíc implementace této kolekce zívisí na objektu entity a to nejde udržet konzistentní - takže to sem asi nepatří
        assert(TRUE, '//TODO: zrevidovat metody remove a removeByIdentity (myslím, že nejsou otestované a vypadají, že nemůžou fungovat pro všechny posloupnosti vlož-persistuj-remove) + dodělat (i do interface) metodu has()');
        $this->identityMap = new \ArrayObject();
        parent::__construct($array, $validator);
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
     * Metoda provede validaci parametru s použitím validátoru a pokud je parametr validní prvek, přidá jej do kolekce. Pokud ne, nedělá nic.
     * Pokud prvek je již v kolekco obsažen, metoda nahradí starý prvek novým.
     * 
     * @param PersistableEntityInterface $entity Prvek, který má být přidán.
     */
    public function set(PersistableEntityInterface $entity) {
        if(isset($this->validator)) {
            if ($this->validator->isValid($entity)) {
                $this->_set($entity);
            }
        }
        return $this;
    }
    
    private function _set(PersistableEntityInterface $entity) {
        $this->internalStorage->offsetSet($this->getIndex($entity), $entity);
        if ($entity->hasIdentity()) {  // pokud je objekt persistován později než je vložen do kolekce, nenastaví se identity map!!
            $this->identityMap->offsetSet($entity->getIdentity()->getId(), $entity);
        }        
    }
    
    /**
     * Vrací člen kolekce se zadanou iodentitou. 
     * Pro rozpoznání člena kolekce je rozhodující shoda objektu identity, nikoli hodnoty vlastností objektu identity. 
     * Shoda objektu identity musí být úplná, musí se jednat o tentýž objekt identity, který měl člen kolekce při svém vložení do kolekce.
     * Pokud byl objekt vložen v okamžiku, kdy neměl identitu a identita objektu byla nastavena později (např. při persistování objektu) nelze
     * takový objekt v kolekci touto metodou nalézt.
     * @param IdentityInterface $identity Objekt identity objektu entity, která je členem kolekce.
     * @return PersistableEntityInterface
     */
    public function getByIdentity(IdentityInterface $identity) {
        $id = $identity->getId();
        if ($this->identityMap->offsetExists($id)) {
            return $this->identityMap->offsetGet($id);
        }
    }
    
    //TODO: zrevidovat metody remove a removeByIdentity (myslím, že nejsou otestované a vypadají, že nemůžou fungovat pro všechny posloupnosti vlož-persistuj-remove) + dodělat (i do interface) metodu has()
    
    /**
     * Odstraní objekt se zadanou identitou z kolekce.
     * Pro rozpoznání člena kolekce je rozhodující shoda objektu identity, nikoli hodnoty vlastností objektu identity. 
     * Shoda objektu identity musí být úplná, musí se jednat o tentýž objekt identity, který měl člen kolekce při svém vložení do kolekce.
     * Pokud byl objekt vložen v okamžiku, kdy neměl identitu a identita objektu byla nastavena později (např. při persistování objektu) nelze
     * takový objekt v kolekci touto metodou nalézt. 
     * @param IdentityInterface $identity Objekt identity objektu entity, která je členem kolekce.
     * @return void Nevrací žádnou hodnotu.
     */ 
    public function removeByIdentity(IdentityInterface $identity) {
        $id = $identity->getId();
        if ($this->identityMap->offsetExists($id)) {
            $this->internalStorage->offsetUnset($this->getIndex($this->identityMap->offsetGet($id)));
            $this->identityMap->offsetUnset($id);
        }   
    }
    
    /**
     * Metoda generuje index, pod kterým je prvek ukládán v kolekci.
     * @param type $param
     * @return type
     */
    private function getIndex($param) {
        return spl_object_hash($param);
    }     
}

