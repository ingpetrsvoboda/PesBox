<?php
namespace Pes\Database\Handler\OptionsProvider;

use Pes\Database\Handler\ConnectionInfo;

/**
 * Objekt typu OptionsProviderInterface je povinným parametrem přo volábí konstruktoru Handleru. 
 * Pro případ, kdy skutečně nechci nastavivat žádné options je možno použít tento options provider.
 *
 * @author pes2704
 */
final class OptionsProviderNull implements OptionsProviderInterface {
    public static function getOptionsArray(ConnectionInfo $connectionInfo) { 
        return array();
    }
}
