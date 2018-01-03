<?php
namespace Pes\Database\Handler\DsnProvider;

use Pes\Database\Handler\ConnectionInfoInterface;

/**
 * Description of DsnProvider
 * Vrací dsn řetězec pro db handler. Je připraven pouze na dsn pro připojení k databázi prostřednictvím specializovaného db handeru,
 * Název handleru je uveden v konstantě třídy.
 * 
 * @author pes2704
 */
class DsnProviderMysql implements DsnProviderInterface {
    
    const PDO_DRIVER_NAME = 'mysql';
    
    /**
     * Sestaví dsn ve formátu MySQL.
     * 
     * Používá vždy hodnotu dbHost, hodnoty dbPort, dbName jen pokud jsou v connectionInfo obsaženy.
     * 
     * @return string
     */
    public function getDsn(ConnectionInfoInterface $connectionInfo) {
        $dsn = self::PDO_DRIVER_NAME.':host=' . $connectionInfo->getDbHost() .
                      ($connectionInfo->getDbPort() ? (';port=' . $connectionInfo->getDbPort()) : '') .
                      ($connectionInfo->getDbName() ? (';dbname=' . $connectionInfo->getDbName()) : '');
        return $dsn;
    }
}
