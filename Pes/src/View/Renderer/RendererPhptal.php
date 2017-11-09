<?php

namespace Pes\View\Renderer;

use PHPTAL;

/**
 * Renderer používající pro generování obsahu template objekt, který jako šablony používá PHPTAL šablony. 
 * Je to dekorátor pro PHPTAL template objekt.
 *
 * @author pes2704
 */
class RendererPhptal implements RendererInterface {
    /**
     * @var PHPTAL 
     */
    private $templateObject;
    
    private $data;


    /**
     * Nastaví pro renderování template objekt. Přijímá parametr typu PHPTAL.
     * @param PHPTAL $templateSystemObject
     */
    public function __construct(PHPTAL $templateSystemObject, array $data=[]) {
        $this->templateObject = $templateSystemObject;
        $this->data = $data;
    }

    /**
     * Vrací výstup získaný ze zadaného template objektu. 
     * Metoda implementuje metodu rozhraní render(). Volá metodu execute() PHPTAL objektu.
     * 
     * @return string
     */
    public function render() {
        if ($data) {
            foreach($this->data as $klic => $hodnota) {
                $this->templateObject->$klic = $hodnota;
            }
            return $this->templateObject->execute();
        }
    }
    
    public function __toString() {
        return $this->render();
    }
}
