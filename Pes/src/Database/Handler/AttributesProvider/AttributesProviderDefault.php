<?php
namespace Pes\Database\Handler\AttributesProvider;

use Pes\Database\Handler\ConnectionInfo;

// TOTO JE TŘÍDA STATEMENT OBJEKTU, KTERÝ JE VYTVÁŘEN METODOU HANDLERU ->prepare()
use Pes\Database\Statement\Statement;

/**
 * AttributesProviderDefault poskytuje základní nastavení, které očekávají ostatní části frameworku.
 *
 * @author pes2704
 */
class AttributesProviderDefault extends AttributesProviderAbstract {
        
    /**
     * Připraví nastavení pro handler (potomek PDO) takto:
     * <ul>
     * <li>Při chybě vyhazuj výjimky</li>
     * <li>Metodami query() a prepare() vracej VLASTNÍ TYP objektu statement. 
     * <ul>
     * <li>typ je dán deklarací use Statement v definici této třídy
     * <li>třída očekává, že nastavený objekt Statement přijímá v konstruktoru logger a nastaví handler tak, aby přo query() a prepare() 
     * předával logger, který sama dostala v konstruktoru.</li>
     * </ul>
     * <li>Pokoušej se používat nativní poporu prepare statements poskytovanou driverem
     *   <ul>
     *   <li> nativní PDO prepare má výhodu v ochraně proti sql injection</li>
     *   <li> nativní PDO prepare má výkonostní výhodu</li>
     *   <ul></li>
     * 
     * @return array
     */
    public function getAttributesArray($attributes=[]) {
        // PDO je potvora - POZOR např. PDO::MYSQL_ATTR_FOUND_ROWS nelze nastavovat pdo->setAttribute(\PDO::MYSQL_ATTR_FOUND_ROWS, true); prostě metoda
        // vrací FALSE a nic se nenastaví. Proto doporučuji nastavovat všechny atributy s konstantami začínajícími MYSQL..., tedy s konstantami specifckými
        // pro mysql driver v objektu MysqlOptionsProvider jako options (nikoli po instancování PDO jako setAttributes), to funguje.
        $defaultAttributes = array();
        
        // při chybě vyhazuj výjimky
        $defaultAttributes[\PDO::ATTR_ERRMODE] = \PDO::ERRMODE_EXCEPTION;

        // vracej VLASTNÍ TYP objektu statement zadaného typu - default typ zadaný konstantou
        $defaultAttributes[\PDO::ATTR_STATEMENT_CLASS] = array(Statement::class, array($this->logger));

        //pokoušej se používat nativní poporu preparu poskytovanou driverem
        // používej nativní PDO prepare - viz http://dev.mysql.com/doc/refman/5.6/en/sql-syntax-prepared-statements.html
        // má výhodu v ochraně proti sql injection viz - http://stackoverflow.com/questions/134099/are-pdo-prepared-statements-sufficient-to-prevent-sql-injection?rq=1 odpověď ircmaxell
        // má výkonostní výhodu
        $defaultAttributes[\PDO::ATTR_EMULATE_PREPARES] = FALSE;

        // ???? (PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL) - viz sERGE-01 http://php.net/manual/en/pdostatement.rowcount.php#113608
        return $defaultAttributes + $attributes;  // lokálně nastavené attr jsou přepsány attr z parametru, pokud mají stejný klíč
    }
}
