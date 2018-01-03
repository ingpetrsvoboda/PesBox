<?php
namespace Pes\Database\Handler\OptionsProvider;

use Pes\Database\Handler\ConnectionInfo;

/**
 * Provider poskytuje výchozí options pro MySQL.
 * Nastavuje, aby příkaz $statement->rowCount() vracel počet nalezených a nikoli počet skutečně dotčenývh řádků.
 * Nastavuje charset a collation na hodnoty uložené v předaném parametru ConnectionInfo.
 * <p>
 * Podrobnosti:</p><p>
 * Příkaz PdoStatement::rowCount() defaultně vrací počet nalezených řádků a nikoli počet dotčených řádků. 
 * Při UPDATE řádku stejnými hodnotami, které již jsou v tabulce zapsány MySQL vrací count affected rows 0. 
 * Pokud chci v kódu testovat úspěšnost zápisu při příkazu UPDATE je lepší vracet počet nalezených řádků.</p><p>
 * Pro nastavení kódování a řazení pro připojení se nastaví jako inicializační příkaz (volaný vždy při vytoření handleru) 
 * SET NAMES charset COLLATE collation s hodnotami charset a collation získanými z ConnectionInfo. Pozn. nastavení kódování 
 * a collationv dsn funguje různě v různých verzích PHP a někdy vůbec.
 * </p>
 *
 * @author pes2704
 */
final class OptionsProviderMysql implements OptionsProviderInterface {
    /**
     * 
     * @param ConnectionInfo $connectionInfo
     * @return array
     */
    public function getOptionsArray(ConnectionInfo $connectionInfo) {
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
