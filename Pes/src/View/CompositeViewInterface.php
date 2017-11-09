<?php

namespace Pes\View;

/*
 * Copyright (C) 2017 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace Pes\View;

/**
 *
 * @author pes2704
 */
interface CompositeViewInterface extends ViewInterface {
    
    /**
     * @return ComposerViewInterface 
     */
    public function appendComponentView(ViewInterface $componentView, $name);

    /**
     * @return \SplObjectStorage
     */
    public function getComponentViews();

}
