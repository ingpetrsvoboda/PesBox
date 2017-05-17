<?php
namespace Pes\Database\Handler\AttributesProvider;

use Pes\Database\Handler\ConnectionInfo;

/**
 *
 * @author pes2704
 */
interface AttributesProviderInterface {
    /**
     * 
     * @param Handler $handler Pro případnou vnitřní potřebu providera.
     */
    public static function getAttributesArray(ConnectionInfo $connectionInfo);
    
}
