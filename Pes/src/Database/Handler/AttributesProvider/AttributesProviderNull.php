<?php
namespace Pes\Database\Handler\AttributesProvider;

use Pes\Database\Handler\ConnectionInfo;

/**
 * AttributesProviderNull poskytuje základní nastavení, které očekávají ostatní části frameworku.
 * Objekt typu AttributesProviderInterface je povinným parametrem přo volábí konstruktoru Handleru. 
 * Pro případ, kdy skutečně nechci nastavivat žádné atributy, je možno použít tento Attributes provider.
 * @author pes2704
 */
class AttributesProviderNull implements AttributesProviderInterface {

    /**
     * @return array
     */
    public static function getAttributesArray(ConnectionInfo $connectionInfo) {
        return array();
    }
}
