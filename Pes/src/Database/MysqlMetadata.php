<?php
/**
 * Description of MysqlMetadata
 *
 * @author pes2704
 */
namespace Pes\Database;
use Pes\Database\HandlerInterface;

class MysqlMetadata {
    
    static $attributes = array();
    static $primaryKeys = array();

    /**
     * Vrací pole atributů (názvů sloupců) a default hodnot tabulky.
     * @param HandlerInterface $dbh
     * @param type $tableName Název tabulky
     * @return array Asociativní pole sloupců tabulky, názvy prvků pole jsou názvy sloupců, hodnoty jsou default hodnoty slouopců tabulky.
     */
    public static function getAttributes(HandlerInterface $dbh, $tableName) {
        $dbName = $dbh->getDbName();
        if (!isset(self::$attributes[$dbName][$tableName])) {
            self::readColumns($dbh, $tableName);
        }
        return self::$attributes[$dbName][$tableName];
    }
    
    /**
     * Vrací název sloupce s primárnám klíčem tabulky
     * @param HandlerInterface $dbh
     * @param type $tableName
     * @return type
     */
    public static function getPrimaryKeyName(HandlerInterface $dbh, $tableName) {
        $dbName = $dbh->getDbName();
        if (!isset(self::$attributes[$dbName][$tableName])) {  //tabulka nemusí mít primární klíč, ale vždy má sloupce
            self::readColumns($dbh, $tableName);
        }
        return self::$primaryKeys[$dbName][$tableName];
    }
    
    private static function readColumns(HandlerInterface $dbh, $tableName) {
        $dbName = $dbh->getDbName();
        //Nacteni struktury tabulky, datovych typu a ost parametru tabulky
        $query = "SHOW COLUMNS FROM ".$tableName; 
        $sth = $dbh->prepare($query);
        $succ = $sth->execute();
        if ($succ) {
            $columnsInfo = $sth->fetchAll(\PDO::FETCH_ASSOC);         
            foreach($columnsInfo as $columnInfo) {
                self::$attributes[$dbName][$tableName][$columnInfo['Field']] = isset($columnInfo['Default']) ? $columnInfo['Default'] : '';
                if ($columnInfo['Key']=="PRI") {
                    self::$primaryKeys[$dbName][$tableName] = $columnInfo['Field'];
                }
            }  
        }
    }
}
