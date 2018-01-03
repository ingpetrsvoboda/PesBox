<?php
namespace Pes\Database\Handler\DsnProvider;

use Pes\Database\Handler\ConnectionInfoInterface;

/**
 * @author pes2704
 */
interface DsnProviderInterface {
    
    /**
     * @return string Řetězec vhodný jako parametr dsn pro vytvoření objektu PDO.
     */
    public function getDsn(ConnectionInfoInterface $connectionInfo);
}
