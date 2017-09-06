<?php
use Pes\Database\Handler\ConnectionInfoInterface;
use Pes\Database\Handler\ConnectionInfo;
use Pes\Type\DbTypeEnum;
use Pes\Database\Handler\DsnProvider\DsnProviderMysql;
use Pes\Database\Handler\OptionsProvider\OptionsProviderMysql;
use Pes\Database\Handler\OptionsProvider\OptionsProviderNull;
use Pes\Database\Handler\AttributesProvider\AttributesProviderNull;
use Pes\Database\Handler\AttributesProvider\AttributesProviderDefault;
use Pes\Database\Handler\Handler;

use Pes\Database\Statement\StatementInterface;

use Psr\Log\NullLogger;

class AttributesProviderForTest extends AttributesProviderDefault {
    const BASE_STATEMENT_TYPE = 'StatementForTest';
    
    /**
     * @param \Pes\Database\Handler\Handler $handler Metoda využívá parametr handler
     * @return array
     */
    public static function getAttributesArray(ConnectionInfo $connectionInfo) {
        $attributes = parent::getAttributesArray($connectionInfo);
        $attributes[\PDO::ATTR_STATEMENT_CLASS] = array(self::BASE_STATEMENT_TYPE,  array());
        return $attributes;        
    }
}

class StatementForTest extends \PDOStatement implements StatementInterface {    
    protected function __construct() {  
        // konstruktor musí být deklarován i když je prázdný
        // bez toho nefunguje PDO::setAttribute(PDO::ATTR_STATEMENT_CLASS, ...
    }
}

/**
 * Description of HandlerMySQLTest
 *
 * @author pes2704
 */
class HandlerMySQLTest extends PHPUnit_Framework_TestCase {
    
    const DB_NAME = 'pes';
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
    const USER = 'pes_tester';
    const PASS = 'pes_tester';
    
    /**
     * Připraví db data.
     * @throws RuntimeException
     */
    public function setUp() {
        //fixture:
        //vymaaže tabulku, zapíše tři řádky v UTF8
        $dsn = 'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME ; 
        $dbh = new PDO($dsn, self::USER, self::PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        if (!$dbh) {
            throw new RuntimeException('Nevytvořil se db handler v setUp.');
        }        
        $dbh->exec('DELETE FROM person');
        $dbh->exec('INSERT INTO person (number, name, surname) VALUES (1, "Adam","Adamov")');
        $dbh->exec('INSERT INTO person (number, name, surname) VALUES (2, "Božena","Boženová")');
        $dbh->exec('INSERT INTO person (number, name, surname) VALUES (3, "Cyril","'.self::TESTOVACI_STRING.'")');
    }
    
    public function testConnectionInfo() {
        $connectionInfo = new ConnectionInfo(self::NICK, DbTypeEnum::MySQL, self::DB_HOST, self::USER, self::PASS, self::CHARSET_UTF8, self::COLLATION_UTF8, self::DB_NAME, self::DB_PORT); 
        $this->assertTrue($connectionInfo instanceof ConnectionInfoInterface, 'Nevytvořil se objekt ConnectionInfo.');
        $this->assertEquals(self::DB_NAME, $connectionInfo->getDbName(), 'Objekt $connectionInfo nevrací zadaný parametr.');
        $this->assertEquals(self::NICK, $connectionInfo->getDbNick(), 'Objekt $connectionInfo nevrací zadaný parametr.');
        $dbt = $connectionInfo->getDbType();
//        $this->assertEquals(DbTypeEnum::MySQL, $connectionInfo->getDbType(), 'Objekt $connectionInfo nevrací zadaný parametr.');
        $this->assertEquals(self::DB_HOST, $connectionInfo->getDbHost(), 'Objekt $connectionInfo nevrací zadaný parametr.');
        $this->assertEquals(self::USER, $connectionInfo->getUser(), 'Objekt $connectionInfo nevrací zadaný parametr.');
        $this->assertEquals(self::CHARSET_UTF8, $connectionInfo->getCharset(), 'Objekt $connectionInfo nevrací zadaný parametr.');
        $this->assertEquals(self::COLLATION_UTF8, $connectionInfo->getCollation(), 'Objekt $connectionInfo nevrací zadaný parametr.');
        $this->assertEquals(self::DB_NAME, $connectionInfo->getDbName(), 'Objekt $connectionInfo nevrací zadaný parametr.');
        $this->assertEquals(self::DB_PORT, $connectionInfo->getDbPort(), 'Objekt $connectionInfo nevrací zadaný parametr.');
    }
    
    public function testMysqlDsnProvider() {
        
        $connectionInfos['bez charset, collation a bez dbName a dbPort'] = new ConnectionInfo(self::NICK, DbTypeEnum::MySQL, self::DB_HOST, self::USER, self::PASS);
        $connectionInfos['bez dbName a dbPort'] = new ConnectionInfo(self::NICK, DbTypeEnum::MySQL, self::DB_HOST, self::USER, self::PASS, self::CHARSET_UTF8, self::COLLATION_UTF8);
        $connectionInfos['bez charset, collation a s dbName a bez dbPort'] = new ConnectionInfo(self::NICK, DbTypeEnum::MySQL, self::DB_HOST, self::USER, self::PASS, NULL, NULL, self::DB_NAME);
        $connectionInfos['s charset, collation, dbName a bez dbPort'] = new ConnectionInfo(self::NICK, DbTypeEnum::MySQL, self::DB_HOST, self::USER, self::PASS, self::CHARSET_UTF8, self::COLLATION_UTF8, self::DB_NAME);
        $connectionInfos['se všemi parametry'] = new ConnectionInfo(self::NICK, DbTypeEnum::MySQL, self::DB_HOST, self::USER, self::PASS, self::CHARSET_UTF8, self::COLLATION_UTF8, self::DB_NAME, self::DB_PORT);

        foreach ($connectionInfos as $key => $connectionInfo) {
            $dsnProvider = new DsnProviderMysql();
            $this->assertTrue($dsnProvider instanceof DsnProviderMysql, 'Nevytvořil se objekt dsn provider.');
            $this->assertTrue(is_string($dsnProvider->getDsn($connectionInfo)), 'Metoda nevrací řetězec.');
            $dbh = new PDO($dsnProvider->getDsn($connectionInfo), self::USER, self::PASS);
            $this->assertTrue($dbh instanceof \PDO, 'Nevytvořil se objekt PDO z dsn poskytnutého dsn providerem a zadanými parametry: '.$key.'.');            
        }

    }
    
    /**
     * Testuje vytvoření objektu - bez options, loggeru, set attribute, identificator formatter, statement cache
     */
    public function testHandlerForMysql() {
        //netestuji chybné user, pass
        //Chybné dbName, dbHost a charset způsobí výjimky PDOException. 
        //Chybný dbPort se neprojeví nijak. Podle testů se zdá, že je úplně jedno jaká hodnota port 
        //je zadána, dotaz jde vždy na 3306 (a na internetu jsou obdobné dotazy se stejným závěrem).
        
        //asserty bez nastavení kódování -> implicitně utf8
        // vytvoření handleru - bez options, loggeru, set attribute, identificator formatter, statement cache
        $connectionInfoUtf8 = new ConnectionInfo(self::NICK, DbTypeEnum::MySQL, self::DB_HOST, self::USER, self::PASS, self::CHARSET_UTF8, self::COLLATION_UTF8, self::DB_NAME, self::DB_PORT);

        $dsnProvider = new DsnProviderMysql();
        $optionsProvider = new OptionsProviderNull();
        $attributesProviderNull = new AttributesProviderNull();
        $logger = new NullLogger();
        $dbh = new Handler($connectionInfoUtf8, $dsnProvider, $optionsProvider, $attributesProviderNull, $logger);
        $this->assertTrue($dbh instanceof Handler, 'Nevytvořil se objekt BaseHandler z dsn poskytnutého dsn providerem a zadanými user, pass.');

        // použití objektu pro čtení z testovací databáze - handler bez nastavení option vytváří PDOStatement
        $stmt = $dbh->query('SELECT name, surname FROM person');
        $this->assertNotFalse($stmt, 'Není statement z BaseHandler->query.');
        $this->assertTrue($stmt instanceof \PDOStatement, 'Nevytvořil se objekt typu PDOStatement z Handler->query.');
        $arr = $stmt->fetchAll();
        $this->assertNotSame(FALSE, $stmt, 'Není pole resultset z PDOStatement->fetchAll.');
        $c= count($arr);
        $this->assertEquals(3, count($arr), 'Je resultset z BaseHandler->query, ale namá 3 řádky.');
        //řádky číslovány od 0 ->třetí řádek
        $this->assertEquals(self::TESTOVACI_STRING, $arr[2]['surname'], 'Surname ve 3 řádku resultsetu neodpovídá textovavacímu stringu vloženému v setUp.');

        //assert s nastavením kódování Windows
        $connectionInfoWin = new ConnectionInfo(self::NICK, DbTypeEnum::MySQL, self::DB_HOST, self::USER, self::PASS, self::CHARSET_WINDOWS, self::COLLATION_WINDOWS, self::DB_NAME, self::DB_PORT);
        // options provider už nestačí null - nastavuje charset a collate 
        // (attributes provider pro MySQL stačí null, ale např. v MSSQL se charset nastavuje až pomocí atributů podle AttributeProvider)
        $optionsProviderMysql = new OptionsProviderMysql();
        $dbh = new Handler($connectionInfoWin, $dsnProvider, $optionsProviderMysql, $attributesProviderNull, $logger);
        $arrWin = $dbh->query('SELECT name, surname FROM person')->fetchAll();
        //řádky číslovány od 0 ->třetí řádek
        $testStringCP1250 = iconv("UTF-8", "Windows-1250", self::TESTOVACI_STRING);  
        $this->assertEquals($testStringCP1250, $arrWin[2]['surname'], 
                'Pří čtení záznamu v db zapsaného v utf8 a přečteného s kódováním cp1250 (windows)'
                . ' neodpovídá přečtené Surname ve 3 řádku resultsetu testovacímu stringu převedenému do cp1250.');

    }
    
    public function testMysqlOptionProvider() {
        $connectionInfoUtf8 = new ConnectionInfo(self::NICK, DbTypeEnum::MySQL, self::DB_HOST, self::USER, self::PASS, self::CHARSET_UTF8, self::COLLATION_UTF8, self::DB_NAME, self::DB_PORT);
        $dsnProvider = new DsnProviderMysql();
        $optionsProvider = new OptionsProviderNull();
        $attributesProviderNull = new AttributesProviderNull();
        $logger = new NullLogger();
        // kontrolní UPDATE bez nastavení options provideru
        $dbh = new Handler($connectionInfoUtf8, $dsnProvider, $optionsProvider, $attributesProviderNull, $logger);
        $this->assertTrue($dbh instanceof Handler, 'Nevytvořil se objekt Handler z dsn poskytnutého dsn providerem (a zadanými parametry).');
        $stmt = $dbh->query('UPDATE person SET surname="'.self::TESTOVACI_STRING.'" WHERE name="Cyril"');
        $rCount = $stmt->rowCount();
        $this->assertEquals(0, $rCount, 
                'UPDATE řádku stejnými hodnotami jako již v řádku jsou, bez nastavení parametrů handleru objektem attributes setter vrací nenulovou hodnotu.'
                . ' Buď se změnila funkčnost handleru nebo není v db správně fixture s hodnotami setUp() metody.');
        // teď test options provider
        $optionsProvider = new OptionsProviderMysql();
        $dbh = new Handler($connectionInfoUtf8, $dsnProvider, $optionsProvider, $attributesProviderNull, $logger);
        $stmt = $dbh->query('UPDATE person SET surname="'.self::TESTOVACI_STRING.'" WHERE name="Cyril"');
        $rCount = $stmt->rowCount();
        $this->assertEquals(1, $rCount, 
                'UPDATE řádku stejnými hodnotami jako již v řádku jsou, s nastavením parametrů handleru objektem attributes setter vrací hodnotu jinou než 1.'
                . ' Buď se změnila funčnost handleru nebo není v db správně fixture s hodnotami setUp() metody.');        
        
        $this->assertTrue($stmt instanceof \PDOStatement, 'Nevytvořil se objekt typu PDOStatement z Handler->query.');
        $arr = $stmt->fetchAll();        
    }
    
    public function testAttributesSetter() {
        // testuji pouze nastavení návratového objektu statement. Netestuji vyhazování výjimak místo chyb a netestuji jestli MySQL skuečně používá prepares statementy.
        $connectionInfoUtf8 = new ConnectionInfo(self::NICK, DbTypeEnum::MySQL, self::DB_HOST, self::USER, self::PASS, self::CHARSET_UTF8, self::COLLATION_UTF8, self::DB_NAME, self::DB_PORT);
        $dsnProvider = new DsnProviderMysql();
        $optionsProvider = new OptionsProviderMysql();
        $attributesProvider = new AttributesProviderNull();
        $logger = new NullLogger();
        // SETTER DO KONSTRUKTORU
        //setter s použitím AttributesProviderDefaultt - měl by vracet default typ AttributesProviderDefault::BASE_STATEMENT_TYPE
        // t.j. 'Pes\Database\Statement\Statement'
        // setter zde zadávám jako parametr při volání komstruktoru handleru
        $attributesProviderDefault = new AttributesProviderDefault();
        $dbh = new Handler($connectionInfoUtf8, $dsnProvider, $optionsProvider, $attributesProviderDefault, $logger);
        $stmt = $dbh->query('SELECT name, surname FROM person');
        $this->assertNotFalse($stmt, 'Není statement z Handler->query.'); 
        $this->assertEquals(AttributesProviderDefault::BASE_STATEMENT_TYPE, get_class($stmt), 'Objekt statement vytvořený handlerem není '
                .AttributesProviderDefault::BASE_STATEMENT_TYPE.'. Je '.get_class($stmt).'.');        
    }
}
