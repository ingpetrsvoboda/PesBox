<?php

namespace Pes\View;

use Pes\View\Renderer\RendererInterface;

/**
 *
 * @author pes2704
 */
class CompositeView extends View implements CompositeViewInterface {
    
    /**
     *
     * @var \SplObjectStorage 
     */
    private $componentViews;
    
    /**
     * Konstruktor - přijímá kompozitní renderer, renderer používaný pro renderování kompozice (nadřazený, layout renderer).
     * 
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer) {
        parent::__construct($renderer);
        $this->componentViews = new \SplObjectStorage();
    }
    
    /**
     * Metoda pro přidání komponentních view. Jednotliví komponentní view budou renderována a vygenerovaný výsledek bude vložen 
     * do kompozitního view na místo proměnné zadané zde jako jméno.
     * 
     * @param ViewInterface $componentView Komponetní view
     * @param string $name Jméno proměnné v kompozitním view, která má být nahrazena výstupem zadané komponentní view
     */
    public function appendComponentView(ViewInterface $componentView, $name) {
        $this->componentViews->attach($componentView, $name);
    }
    
    /**
     * Metoda vrací objekt typu SplObjectStorage s přidanými objekty view.
     * @return \SplObjectStorage
     */
    public function getComponentViews() {
        return $this->componentViews;
    }
    
    /**
     * Metoda renderuje všechny vložené component renderery. Výstupní kód z jednotlivých renderování vkládá do kontextu
     * composer rendereru vždy pod jménem proměnné, se kterým byl component renderer přidán. Nakonec renderuje
     * compose renderer. 
     * @return string
     */
    public function render($data=[]) {
        $composeViewData = array();
        if (count($this->componentViews)>0) {
            foreach ($this->componentViews as $componentView) {
                $composeViewData[$this->componentViews->getInfo()] = $componentView->render();
            }
        }
        return $this->renderer->render(array_merge($data, $composeViewData));
    }
}
