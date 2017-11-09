<?php

/*
 * Copyright (C) 2017 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Pes\View\Node;

use Pes\View\Renderer\RendererPhp;

/**
 *
 * @author pes2704
 */
interface TextViewInterface extends TextInterface{
    /**
     * @return RendererPhp 
     */
    public function getView();
}
