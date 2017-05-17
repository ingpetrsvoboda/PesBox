<?php
namespace Pes\Database\Handler\OptionsProvider;
use Pes\Database\Handler\ConnectionInfo;

/**
 * Vrací pole options pro konstruktor PDO
 * @author pes2704
 */
interface OptionsProviderInterface {
    public static function getOptionsArray(ConnectionInfo $connectionInfo);
}