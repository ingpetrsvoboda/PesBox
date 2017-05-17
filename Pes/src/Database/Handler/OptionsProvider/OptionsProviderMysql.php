<?php
namespace Pes\Database\Handler\OptionsProvider;

use Pes\Database\Handler\ConnectionInfo;

/**
 * Description of OptionsProvider
 *
 * @author pes2704
 */
final class OptionsProviderMysql implements OptionsProviderInterface {
    public static function getOptionsArray(ConnectionInfo $connectionInfo) {
        $options = array();
        // příkaz PdoStatement::rowCount() vrací počet nalezených řádků a nikoli počet dotčených řádků
        // při UPDATE řádku stejnými hodnotami, které již jsou v tabulce zapsány MySQL vrací count affected rows 0. 
        // Pokud chci testovat úspěšnost zápisu je lepší vracet počet nalezených řádků
        $options[\PDO::MYSQL_ATTR_FOUND_ROWS] = TRUE;
        
        // Pro nastavení kódování a řazení pro připojení zde volám SET NAMES charset COLLATE collation, nastavení kódování v dsn funguje různě 
        // ve starších verzích PHP a zřejmě tak nelze nastavit COLLATE
        if ($connectionInfo->getCharset()) {
            // MYSQL_ATTR_INIT_COMMAND - Note, this constant can only be used in the driver_options array when constructing a new database handle.
            $cmd = 'SET NAMES '.$connectionInfo->getCharset();
            if ($connectionInfo->getCollation()) {
                $cmd .= ' COLLATE '. $connectionInfo->getCollation();
            }
            $options[\PDO::MYSQL_ATTR_INIT_COMMAND] = $cmd;      
        }        
        return $options;
    }
}
