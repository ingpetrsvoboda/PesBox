<?php

/*
 * Copyright (C) 2017 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Pes\View\Renderer;

/**
 * ImplodeRenderer pouze zřetězí data s použitím zadaného separátoru, pouýije php funkci implode().
 *
 * @author pes2704
 */
class ImplodeRenderer implements RendererInterface {
    
    private $separator;
    
    /**
     * 
     * @param string $separator
     */
    public function __construct($separator = '') {
        $this->separator = $separator;
    }
    
    public function render(array $data=[]) {
        return implode($this->separator, $data);
    }
}
