<?php

namespace Pes\View;

/**
 *
 * @author pes2704
 */
interface ViewInterface {
    /**
     * S použitím dat v kontextu vytvoří obsah připravený k převodu na string metodou __toString().
     */
    public function render($contextData);
    public function getString();
    public function __toString();
}

