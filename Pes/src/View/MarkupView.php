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

use Pes\View\Renderer\TagRendererInterface;

/**
 * Description of MarkupView
 *
 * @author pes2704
 */
class MarkupView extends View implements MarkupViewInterface {
    
    /**
     * @var  
     */
    private $dataProvider;
    
    public function __construct(TagRendererInterface $tagRenderer) {
        parent::__construct($tagRenderer);
    }

    public function setDataProvider($dataProvider) {
        $this->dataProvider = $dataProvider;
        return $this;
    }
        
    public function render() {
        parent::render();
    }
    
    private function hydrateTextNode() {
        
    }
}
