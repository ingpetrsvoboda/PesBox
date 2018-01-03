<?php

namespace Pes\View\Node;

/**
 * Description of InnerText
 *
 * @author pes2704
 */
class TextFactory implements NodeInterface {
    
    /**
     *
     * @var \Closure 
     */
    private $textFactory;

    /**
     * Přijímá Closure určenou ke generování textového obsahu. Closure generuje (lazy) textový obsah s použitím dat zadaných při 
     * volání matody getText($data).
     * 
     * @param \Closure $textFactory
     */
    public function __construct(\Closure $textFactory) {
        $this->textFactory = $textFactory;
    }

    /**
     * Vrací návratovou hodnotu Closure zadané jako prametr konstruktoru. 
     * V této metodě je Closure volána a jsou jí předána data zadaná jako parametr metody. Closure tedy generuje textový obsah s použitím dat zadaných při 
     * volání této matody.
     * Closure musí být implementována tak, aby vracela string vhodný jako textový obsah tagu (nodu).
     * 
     * @param type $data
     * @return string
     */
    public function getText($data=NULL) {
        return ($this->textFactory)($data);
    }
   
}
