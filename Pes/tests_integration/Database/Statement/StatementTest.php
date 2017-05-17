<?php
use Pes\Database\Handler\ConnectionInfo;
use Pes\Type\DbTypeEnum;
use Pes\Database\Handler\DsnProvider\DsnProviderMysql;
use Pes\Database\Handler\OptionsProvider\OptionsProviderMysql;
use Pes\Database\Handler\AttributesProvider\AttributesProviderDefault;
use Pes\Database\Handler\Handler;

use Pes\Database\Statement\Cache;

use Psr\Log\NullLogger;

/**
 * Model
 */
class Person {
    public $name;
    public $surname;
}

/**
 * Description of StatementTest
 *
 * @author pes2704
 */
class StatementTest extends PHPUnit_Framework_TestCase {
    const DB_NAME = 'p4_unit_integration_tests_db';
    const DB_HOST = 'localhost';
    const DB_PORT = '3306';
    const CHARSET_WINDOWS = 'cp1250';
    const COLLATION_WINDOWS = 'cp1250_czech_cs';
    const CHARSET_UTF8 = 'utf8';
    const COLLATION_UTF8 = 'utf8_czech_ci';
    const CHARSET_UTF8MB4 = 'utf8mb4';
    const COLLATION_UTF8MB4 = 'utf8mb4_czech_ci';
    
    const TESTOVACI_STRING = "Cyrilekoěščřžýáíéúů";

    const NICK = 'tester';    
    const USER = 'p4_tester';
    const PASS = 'p4_tester';
    
    public function setUp() {
        //fixture:
        //vymaaže tabulku, zapíše tři řádky v UTF8
        $dsn = 'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME ; 
        $dbh = new PDO($dsn, self::USER, self::PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        $dbh->exec('DELETE FROM person');
        $dbh->exec('INSERT INTO person (name, surname) VALUES ("Adam","Adamov")');
        $dbh->exec('INSERT INTO person (name, surname) VALUES ("Božena","Boženová")');
        $dbh->exec('INSERT INTO person (name, surname) VALUES ("Cyril","'.self::TESTOVACI_STRING.'")');
    }
    
    /**
     * Testuje Statement s různým fetch mode - jen s SQL SELECT
     */
    public function testStatement() {
        $connectionInfoUtf8 = new ConnectionInfo(self::NICK, DbTypeEnum::MySQL, self::DB_HOST, self::USER, self::PASS, self::CHARSET_UTF8, self::COLLATION_UTF8, self::DB_NAME, self::DB_PORT);        
        $dsnProvider = new DsnProviderMysql();
        $optionsProvider = new OptionsProviderMysql();
        $logger = new NullLogger();
        $attributesProviderDefault = new AttributesProviderDefault();
        $dbh = new Handler($connectionInfoUtf8, $dsnProvider, $optionsProvider, $attributesProviderDefault, $logger);    
        $stmt = $dbh->query('SELECT name, surname FROM person');
        $this->assertNotFalse($stmt, 'Není statement z Handler->query.'); 
        $stmt->setFetchMode();
        // 1. řádek - Adam - bez fetch mode
        $res1 = $stmt->fetch();
        $this->assertTrue(is_array($res1) AND count($res1)==4, 'Fetch bez nastavení fetch mode nevrátil pole nebo pele nemá 4 položky.');
        // 2. řádek Božena - fetch mode \PDO::FETCH_ASSOC
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $res2 = $stmt->fetch();
        $this->assertTrue(is_array($res2) AND count($res2)==2, 'Fetch s nastavením fetch mode PDO::FETCH_ASSOC nevrátil pole nebo pole nemá 2 položky.');        
        // 3. řádek Cyril - fetch mode \PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, 'Person'
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, 'Person');
        $res3 = $stmt->fetch();
        $this->assertEquals('Person', get_class($res3), 'Objekt vytvořený fetch není nastaveného typu Person. Je '.get_class($res3).'.');
    }
    
    /**
     * Testuje Stetement s použitím cache pro prepared statementy - jen s SQL SELECT
     */
    public function testStatementCache() {
        $connectionInfoUtf8 = new ConnectionInfo(self::NICK, DbTypeEnum::MySQL, self::DB_HOST, self::USER, self::PASS, self::CHARSET_UTF8, self::COLLATION_UTF8, self::DB_NAME, self::DB_PORT);        
        $dsnProvider = new DsnProviderMysql(self::DB_NAME, self::DB_HOST);
        $optionsProvider = new OptionsProviderMysql();
        $logger = new NullLogger();
        $attributesProviderDefault = new AttributesProviderDefault();
        // bez statement cache
        $dbh = new Handler($connectionInfoUtf8, $dsnProvider, $optionsProvider, $attributesProviderDefault, $logger);   
        $stmt1 = $dbh->prepare('SELECT name, surname FROM person');        
        $stmt2 = $dbh->prepare('SELECT name, surname FROM person');    // ze stejného handleru  
        if ($stmt1 === $stmt2) {
            $driverChaching = TRUE;
        } else {
            $driverChaching = FALSE;            
        }
        if ($stmt1 == $stmt2) {
            $sameStatent = TRUE;
        } else {
            $sameStatent = FALSE;            
        }        // se statement cache
        $statementCache = new Cache();
        $dbh = new Handler($connectionInfoUtf8, $dsnProvider, $optionsProvider, $attributesProviderDefault, $logger, $statementCache);
        $stmt3 = $dbh->prepare('SELECT name, surname FROM person');        
        $stmt4 = $dbh->prepare('SELECT name, surname FROM person');    // ze stejného handleru  
        if ($stmt3 === $stmt4) {
            $statementChaching1 = TRUE;
        } else {
            $statementChaching1 = FALSE;            
        }
        $dbh = new Handler($connectionInfoUtf8, $dsnProvider, $optionsProvider, $attributesProviderDefault, $logger, $statementCache);
        $stmt5 = $dbh->prepare('SELECT name, surname FROM person');          // z nového handleru  
        if ($stmt3 === $stmt5) {
            $statementChaching2 = TRUE;
        } else {
            $statementChaching2 = FALSE;            
        }
        
//        $this->assertTrue($driverChaching, 'Nefunguje nativní statement cache v PDO driveru.');
        $this->assertTrue($statementChaching1, 'Nefunguje statement cache - podruhé stejný statement ze stejného handleru.');
        $this->assertTrue($statementChaching2, 'Nefunguje statement cache  - podruhé stejný statement z nového handleru.');
    }
    
}
