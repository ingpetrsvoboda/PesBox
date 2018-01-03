<?php

namespace Pes\View\Node;
/**
 *
 * @author pes2704
 */
interface NodeInterface {

    /**
     * Vrací textový obsah node a jeho následníků. Napodobuje (částečně) funkci vlastnosti textContent elementu node v DOM HTML.<br/>
     * - vrací NULL, pokud node je dokument, doctype
     * - vrací text, pokud node je TextInterface node.
     * - vrací zřetězení textů všech potomkovských node.
     */
    public function getText();
}
