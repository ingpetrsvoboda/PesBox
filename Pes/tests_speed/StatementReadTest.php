<?php
use Pes\Database\Handler\ConnectionInfo;
use Pes\Type\DbTypeEnum;
use Pes\Database\Handler\DsnProvider\DsnProviderMysql;
use Pes\Database\Handler\OptionsProvider\OptionsProviderMysql;
use Pes\Database\Handler\AttributesProvider\AttributesProviderNull;
use Pes\Database\Handler\AttributesProvider\AttributesProviderDefault;
use Pes\Database\Handler\Handler;

use Pes\Database\Statement\Statement;
use Pes\Database\Statement\Cache;

use Psr\Log\NullLogger;

require 'TestHelper.php';
// autoload pro vlastní soubory Pes/src - definováno v composer.json - autolad v adresáři vendor vznikne při volání composer install
require '../../vendor/autoload.php';

class PersonForReadTest {
    public $name;
    public $surname;
}

/**
 * Description of StatementTest
 *
 * @author pes2704
 */
class StatementReadTest {
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
        // Insert v cyklu trvá 30 sekund!
//        for ($i = 1; $i <= 1000; $i++) {
//            $sql = "INSERT INTO person (number, name, surname) VALUES ($i, 'Cyril$i', '".self::TESTOVACI_STRING."')";
//            $succ = $dbh->exec($sql);
//        }
        // tohle trvá 140ms
        $dbh->exec('INSERT INTO person SELECT * FROM person_backup');
    }

    public function testStatementCache() {
        $connectionInfoUtf8 = new ConnectionInfo(self::NICK, DbTypeEnum::MySQL, self::DB_HOST, self::USER, self::PASS, self::CHARSET_UTF8, self::COLLATION_UTF8, self::DB_NAME, self::DB_PORT);
        $dsnProvider = new DsnProviderMysql();
        $optionsProvider = new OptionsProviderMysql();
        $logger = new NullLogger();
        $attributesProviderDefault = new AttributesProviderDefault();
        $dbhBezCache = new Handler($connectionInfoUtf8, $dsnProvider, $optionsProvider, $attributesProviderDefault, $logger);            
        $statementCache = new Cache();
        $dbhSCache = new Handler($connectionInfoUtf8, $dsnProvider, $optionsProvider, $attributesProviderDefault, $logger, $statementCache);

        $html = '';
#########################################################################        
        $start[1] = 1;
        $runs[1] = 1000;
        $start[2] =  1;
        $runs[2] = 10;
        for ($test=1; $test<=count($runs); $test++) {
            $html .= '<div class=test>';
            $html .= '<h1>Test '.__CLASS__.', běh '.$test.'</h1>';
    ### v cyklu jen statement bez cache ######################################################################        
            $html .= '<p>'.$this->helper->interval(1).'</p>'; //reset
            for($id = $start[$test]; $id <= $start[$test]+$runs[$test]; $id++) {
                $stmt = $dbhBezCache->prepare('SELECT number, name, surname FROM person WHERE number = :number');        // jeden prepare 
            }
            $html .= '<pre>'.print_r($stmt, TRUE).'</pre>';        
            $html .= '<p>Vytvoření statementů v cyklu bez cache, počet '.$runs[$test].': '.$this->helper->interval().'</p>';
    ### v cyklu jen statement s cache ######################################################################        
            $html .= '<p>'.$this->helper->interval(1).'</p>'; //reset
            $dbStatementCache = new Cache();
            for($id = $start[$test]; $id <= $start[$test]+$runs[$test]-1; $id++) {
                $stmt = $dbhSCache->prepare('SELECT number, name, surname FROM person WHERE number = :number');        
            }
            $html .= '<pre>'.print_r($stmt, TRUE).'</pre>';        
            $html .= '<p>Vytvoření statementů v cyklu s cache, počet '.$runs[$test].': '.$this->helper->interval().'</p>';
    ### v cyklu statement bez cache a select ######################################################################        
            $html .= '<p>'.$this->helper->interval(1).'</p>'; //reset
            for($id = $start[$test]; $id <= $start[$test]+$runs[$test]-1; $id++) {
                //prepare uvnitř cyklu
                $stmt = $dbhBezCache->prepare('SELECT number, name, surname FROM person WHERE number = :number');        // jeden prepare 
                $succ = $stmt->execute(array(':number' => $id));
                $res = $stmt->fetch();
            }
            $html .= '<pre>'.print_r($stmt, TRUE).'</pre>';        
            $html .= '<p>Vytvoření statementů bez cache v cyklu a vždy jedno čtení, počet '.$runs[$test].': '.$this->helper->interval().'</p>';
    ### v cyklu statement s cache a select ######################################################################        
            $html .= '<p>'.$this->helper->interval(1).'</p>'; //reset
            $dbStatementCache = new Cache();
            for($id = $start[$test]; $id <= $start[$test]+$runs[$test]-1; $id++) {
                //prepare uvnitř cyklu
                $stmt = $dbhSCache->prepare('SELECT number, name, surname FROM person WHERE number = :number');        
                $succ = $stmt->execute(array(':number' => $id));
                $res = $stmt->fetch();            }
            $html .= '<pre>'.print_r($stmt, TRUE).'</pre>';        
            $html .= '<p>Vytvoření statementů s cache v cyklu a vždy jedno čtení, počet '.$runs[$test].': '.$this->helper->interval().'</p>';
    ### jeden statement bez cache, execute a řtení v cyklu ######################################################################        
            $html .= '<p>'.$this->helper->interval(1).'</p>'; //reset
            $stmt = $dbhBezCache->prepare('SELECT number, name, surname FROM person WHERE number = :number');        // jeden prepare             
            for($id = $start[$test]; $id <= $start[$test]+$runs[$test]-1; $id++) {
                $succ = $stmt->execute(array(':number' => $id));
                $res = $stmt->fetch();
            }
            $html .= '<pre>'.print_r($stmt, TRUE).'</pre>';        
            $html .= '<p>Vytvoření jednoho prepared statementu před cyklem bez cache a v cyklu vždy jedno čtení, počet '.$runs[$test].': '.$this->helper->interval().'</p>';
    ### jeden statement bez cache, jeden execute a fetchAll a pak čtení v cyklu ######################################################################        
            $html .= '<p>'.$this->helper->interval(1).'</p>'; //reset
            $stmt = $dbhBezCache->prepare('SELECT number, name, surname FROM person');        // jeden prepare             
            $succ = $stmt->execute();
            $res = $stmt->fetchAll();
            for($id = $start[$test]; $id <= $start[$test]+$runs[$test]-1; $id++) {
                $row = $res[$id-1];
            }
            $html .= '<pre>'.print_r($stmt, TRUE).'</pre>';        
            $html .= '<p>Vytvoření jednoho prepared statementu před cyklem bez cache, čtení metodou fetchAll a v cyklu procházím jen pole v php, počet '.$runs[$test].': '.$this->helper->interval().'</p>';
    ### INSERT bez cache ######################################################################        
            $dbhBezCache->exec('DELETE FROM person');
            $html .= '<p>'.$this->helper->interval(1).'</p>'; //reset
           
            $stmt = $dbhBezCache->prepare("INSERT INTO person (number, name, surname) VALUES (:id, :cyrilid, :tst)");        // jeden prepare             
            for($id = $start[$test]; $id <= $start[$test]+$runs[$test]-1; $id++) {
                $succ = $stmt->execute(array(':id' => $id, ':cyrilid' => 'Cyril'.$id, ':tst'=>self::TESTOVACI_STRING));
                $res = $dbhBezCache->lastInsertId();
            }
            $html .= '<pre>'.print_r($stmt, TRUE).'</pre>';        
            $html .= '<p>Vytvoření jednoho INSERT prepared statementu před cyklem bez cache a v cyklu vždy jeden zápis, počet '.$runs[$test].': '.$this->helper->interval().'</p>';
    ### bez cache ######################################################################        
//            $html .= '<p>'.$this->helper->interval(1).'</p>'; //reset
//            $stmt = $dbhBezCache->prepare('SELECT number, name, surname FROM person');        // jeden prepare             
//            $succ = $stmt->execute();
//            $res = $stmt->fetchAll();
//            for($id = $start[$test]; $id <= $start[$test]+$runs[$test]-1; $id++) {
//                $row = $res[$id-1];
//            }
//            $html .= '<pre>'.print_r($stmt, TRUE).'</pre>';        
//            $html .= '<p>Vytvoření jednoho prepared statementu před cyklem bez cache, čtení metodou fetchAll a v cyklu procházím jen pole v php, počet '.$runs[$test].': '.$this->helper->interval().'</p>';
            $html .= '</div>';
        }   
        echo $html;
    }
}
    
    /**
     * Pouze pro debug testu - jinak nutno zakomentovat
     */    
    $test = new StatementReadTest();
    $testClass = get_class($test);
    $reflxTest = new ReflectionClass($test);
    $methodsArray = $reflxTest->getMethods(ReflectionMethod::IS_PUBLIC);
    $isSetUp = FALSE;
    foreach ($methodsArray as $method) {
        if ($method->class == $testClass) {
            if (substr($method->name, 0, 2) != '__') {  // jinak poušří i __construct atd.
                if ($method->name != 'setUp') {
                    $testMethods[] = $method->name;
                } else {
                    $isSetUp = TRUE;
                }
            }
        }
    }
    foreach ($testMethods as $name) {
        if ($isSetUp) {
            $test->setUp();  // mimo phpunit nutno spustit ručně
        }
        $test->$name();
    }