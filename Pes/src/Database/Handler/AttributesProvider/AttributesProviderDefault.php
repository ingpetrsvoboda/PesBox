<?php
namespace Pes\Database\Handler\AttributesProvider;

use Pes\Database\Handler\ConnectionInfo;

// TOTO JE TŘÍDA STATEMENT OBJEKTU, KTERÝ JE VYTVÁŘEN PŘÍKAZEM PREPARE HANDLERU
use Pes\Database\Statement\Statement;

/**
 * AttributesProviderDefault poskytuje základní nastavení, které očekávají ostatní části frameworku.
 *
 * @author pes2704
 */
class AttributesProviderDefault implements AttributesProviderInterface {
    
    const BASE_STATEMENT_TYPE = 'Pes\Database\Statement\Statement';
    
    /**
     * Připraví nastavení pro handler (potomek PDO) takto:
     * <ul>
     * <li>při chybě vyhazuj výjimky</li>
     * <li>vracej VLASTNÍ TYP objektu statement. Typ je dán deklarací use v definici této třídy.</li>
     * <li>pokoušej se používat nativní poporu preparu poskytovanou driverem
     *   <ul>
     *   <li> nativní PDO prepare má výhodu v ochraně proti sql injection</li>
     *   <li> nativní PDO prepare má výkonostní výhodu</li>
     *   <ul></li>
     * 
     * @return array
     */
    public static function getAttributesArray(ConnectionInfo $connectionInfo) {
        // PDO je potvora - POZOR např. PDO::MYSQL_ATTR_FOUND_ROWS nelze nastavovat pdo->setAttribute(\PDO::MYSQL_ATTR_FOUND_ROWS, true); prostě metoda
        // vrací FALSE a nic se nenastaví. Proto doporučuji nastavovat všechny atributy s konstantami začínajícími MYSQL..., tedy s konstantami specifckými
        // pro mysql driver v objektu MysqlOptionsProvider jako options (nikoli po instancování PDO jako setAttributes), to funguje.
        $attributes = array();
            // při chybě vyhazuj výjimky
            $attributes[\PDO::ATTR_ERRMODE] = \PDO::ERRMODE_EXCEPTION;

            // vracej VLASTNÍ TYP objektu statement zadaného typu - default typ zadaný konstantou
            $attributes[\PDO::ATTR_STATEMENT_CLASS] = array(Statement::class, array());

            //pokoušej se používat nativní poporu preparu poskytovanou driverem
            // používej nativní PDO prepare - viz http://dev.mysql.com/doc/refman/5.6/en/sql-syntax-prepared-statements.html
            // má výhodu v ochraně proti sql injection viz - http://stackoverflow.com/questions/134099/are-pdo-prepared-statements-sufficient-to-prevent-sql-injection?rq=1 odpověď ircmaxell
            // má výkonostní výhodu
            $attributes[\PDO::ATTR_EMULATE_PREPARES] = FALSE;

            // ???? (PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL) - viz sERGE-01 http://php.net/manual/en/pdostatement.rowcount.php#113608
        return $attributes;
    }
}
