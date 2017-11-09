<?php

namespace Pes\View\Renderer;

use Twig_Environment;

/**
 * Renderer používající pro generování obsahu template objekt, který jako šablony používá Twig šablony. 
 * Je to dekorátor pro Twig_Environment template objekt.
 *
 * @author pes2704
 */
class RendererTwig implements RendererInterface {
    
    /**
     * @var Twig_Environment 
     */
    private $templateObject;
    
    private $data;

    /**
     * Nastaví pro renderování template objekt a data.
     * 
     * @param Twig_Environment $templateSystemObject
     * @param array $data
     */
    public function __construct(Twig_Environment $templateSystemObject, array $data=[]) {
        $this->templateObject = $templateSystemObject;
        $this->data = $data;
    }

    /**
     * Vrací výstup získaný ze zadaného template objektu. 
     * Metoda implementuje metodu rozhraní render(). Volá metodu render() Twig objektu.
     * 
     * @param type $data
     * @return type
     */
    public function render() {
        $content = $this->templateObject->render($this->data);
        return $content;
    }
    
    public function __toString() {
        return $this->render();
    }
}
