<?php

/*
 * Copyright (C) 2017 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Pes\View;

use Pes\View\Renderer\RendererInterface;

/**
 * View - objekt je vytvořen se zadaným rendererem a s jeho použitím vytváří textový obsah z aktuálně zadaných dat.
 * Generovaný obsah je dán rendererem.
 *
 * @author pes2704
 */
class View implements ViewInterface {    

    /**
     * @var RendererInterface 
     */
    protected $renderer;
    
    /**
     * Konstruktor - přijímá renderer používaný pro renderování.
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer) {
        $this->renderer = $renderer;
    }
    
    /**
     * Vrací nastavení renderer.
     * @return RendererInterface
     */
    public function getRenderer(): RendererInterface {
        return $this->renderer;
    }
    
    public function setRenderer(RendererInterface $renderer) {
        $this->renderer = $renderer;
        return $this;
    }

    /**
     * S použitím rendereru vyvoří obsah.
     * 
     * @return string
     */
    public function render($data=[]) {
        return $this->renderer->render($data);
    }
    
    public function __toString() {
        return $this->render();
    }
}