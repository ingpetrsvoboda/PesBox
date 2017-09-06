<?php
use Pes\Database\Handler\ConnectionInfo;
use Pes\Type\DbTypeEnum;
use Pes\Database\Handler\DsnProvider\DsnProviderMysql;
use Pes\Database\Handler\OptionsProvider\OptionsProviderMysql;
use Pes\Database\Handler\AttributesProvider\AttributesProviderDefault;
use Pes\Database\Handler\Handler;

use Pes\Database\Statement\Statement;
use Pes\Database\Statement\Cache;

use Psr\Log\NullLogger;

require 'TestHelper.php';

// autoload pro vlastní soubory Pes/src - definováno v composer.json - autolad v adresáři vendor vznikne při volání composer install
require '../../vendor/autoload.php';

class PersonForCacheTest {
    public $name;
    public $surname;
}

/**
 * Description of StatementTest
 *
 * @author pes2704
 */
class StatementSpeedTest {
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
    
    private $helper;
    
    public function __construct() {
        $this->helper = new TestHelper();
    }
    
    public function setUp() {
        //fiture:
        //vymaaže tabulku, zapíše tři řádky v UTF8
        $dsn = 'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME ; 
        $dbh = new PDO($dsn, self::USER, self::USER, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        $dbh->exec('DELETE FROM person');
        $dbh->exec('INSERT INTO person (name, surname) VALUES ("Adam","Adamov")');
        $dbh->exec('INSERT INTO person (name, surname) VALUES ("Božena","Boženová")');
        $dbh->exec('INSERT INTO person (name, surname) VALUES ("Cyril","'.self::TESTOVACI_STRING.'")');
    }

    public function testStatementCache() {
        $connectionInfoUtf8 = new ConnectionInfo(self::NICK, DbTypeEnum::MySQL, self::DB_HOST, self::USER, self::PASS, self::CHARSET_UTF8, self::COLLATION_UTF8, self::DB_NAME, self::DB_PORT);
        $dsnProvider = new DsnProviderMysql();
        $optionsProvider = new OptionsProviderMysql();            
        $attributesProviderDefault = new AttributesProviderDefault();
        $logger = new NullLogger();
        $dbhBezCache = new Handler($connectionInfoUtf8, $dsnProvider, $optionsProvider, $attributesProviderDefault, $logger);
        
        $statementCache = new Cache();
        $dbhSCache = new Handler($connectionInfoUtf8, $dsnProvider, $optionsProvider, $attributesProviderDefault, $logger, $statementCache);

        $html = '';
        
        $html .= '<div class=test>';
        $html .= '<h1>Test '.__CLASS__.'</h1>';
        $html .= '<p>'.$this->helper->interval().'</p>'; //reset

#########################################################################        
        $start = 0;
        $runs = 10; // 
### bez cache ######################################################################        
        $id = $start;
        while($id <= $start+$runs) {
            $stmt = $dbhBezCache->prepare('SELECT name, surname FROM person');        // jeden prepare 
            $id++;
        }
        $html .= '<p>Vytvoření statement bez cache, počet '.$runs.': '.$this->helper->interval().'</p>';
### s cache ######################################################################        
        $dbStatementCache = new Cache();
        $id = $start;
        while($id <= $start+$runs) {
//            $stmt = $dbhSCache->prepare('SELECT name, surname FROM person');        
            $id++;
        }
        $html .= '<pre>'.print_r($stmt, TRUE).'</pre>';        
        $html .= '<p>Vytvoření statement s cache, počet '.$runs.': '.$this->helper->interval().'</p>';
        $html .= '</div>';

        $html .= '<div class=test>';
        $html .= '<h1>Test '.__CLASS__.'</h1>';
        $html .= '<p>'.$this->helper->interval().'</p>'; //reset
// se selecty
#########################################################################        
        $start = 0;
        $runs = 10; // 
### bez cache ######################################################################        
        $id = $start;
        while($id <= $start+$runs) {
            $stmt = $dbhBezCache->prepare('SELECT name, surname FROM person');  
            $res = $stmt->execute();
            $id++;
        }
        $html .= '<p>Vytvoření statement bez cache, počet '.$runs.': '.$this->helper->interval().'</p>';
### s cache ######################################################################        
        $dbStatementCache = new Cache();
        $id = $start;
        while($id <= $start+$runs) {
            $stmt = $dbhSCache->prepare('SELECT name, surname FROM person');        
            $res = $stmt->execute();
            $id++;
        }
        $html .= '<pre>'.print_r($stmt, TRUE).'</pre>';        
        $html .= '<p>Vytvoření statement s cache, počet '.$runs.': '.$this->helper->interval().'</p>';
        $html .= '</div>';        
        
        echo $html;
        
    }
    
}


    
    
    /**
     * Pouze pro debug testu - jinak nutno zakomentovat
     */    
    $test = new StatementSpeedTest();
    $testClass = get_class($test);
    $reflxTest = new ReflectionClass($test);
    $methodsArray = $reflxTest->getMethods(ReflectionMethod::IS_PUBLIC);
    $isSetUp = FALSE;
    foreach ($methodsArray as $method) {
        if ($method->class == $testClass) {
            if ($method->name != 'setUp') {
                $testMethods[] = $method->name;
            } else {
                $isSetUp = TRUE;
            }
        }
    }
    foreach ($testMethods as $name) {
        if ($isSetUp) {
            $test->setUp();  // mimo phpunit nutno spustit ručně
        }
        $test->$name();
    }