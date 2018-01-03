<?php
namespace Pes\Collection;

use ArrayObject;
use Pes\Validator\ValidatorInterface;

/**
 * CollectionAbstract
 */
abstract class CollectionAbstract implements CollectionInterface {
    /**
     *
     * @var \ArrayObject 
     */
    protected $internalStorage;
    /**
     *
     * @var ValidatorInterface 
     */
    protected $validator;
    
    // TODO:
//    abstract function find();
    
    /**
     * Vytvoří novou kolekci s možností validace přídávaných prvků kolekce. Validace se provádí pomocí validátoru, 
     * zadaného jako instanční parametr konstruktoru. Pokud validátor není zadán, neprovádí se žádná kontrola přidávaných hodnot. 
     * 
     * @param ValidatorInterface $validator
     */
    public function __construct(array $array=[], ValidatorInterface $validator = NULL) {
        $this->validator = $validator;
        $this->internalStorage = new ArrayObject;
        if ($array) {
            $this->mergeArrayContent($array);
        }
    }     

    abstract public function mergeArrayContent(array $newArray = NULL);
    
    public function count() {
        return $this->internalStorage->count();
    }
    
    public function getArrayCopy() {
        $this->internalStorage->getArrayCopy();
    }
    
    public function getIterator() {
        return $this->internalStorage->getIterator();
    }
    
    /**
     * Metoda seřadí prvky kolekce s pouřitím porovnávací funkce zadané jako parametr.
     * Porovnávací funkce musí porovnávat členy kolekce, vracet při volání callback(první, druhý) tyto hodnoty: 
     * 1 pokud 'první' má být před 'druhý', 0 pokud je pořadí členů stejné, -1 pokud má být 'druhý' před 'první'.
     * Metoda interně používá metodu uasort, pro porobnosti o porovnávací funkci vit dokumentace php.
     * Po použití metody probíhá následné iterování kolekce (foreach) v setříděném pořadí, jen pozor - indexy členů kolekce se tříděním nijak nemění.
     * 
     * @param \Pes\Collection\callable $callback Porovnávaví funkce 
     */
    public function sort(callable $callback)
    {
        $this->internalStorage->uasort($callback);
    }
}

