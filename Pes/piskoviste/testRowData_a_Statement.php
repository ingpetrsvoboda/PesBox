<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require '../../vendor/autoload.php';

use Pes\Database\Handler\ConnectionInfo;
use Pes\Type\DbTypeEnum;
use Pes\Database\Handler\DsnProvider\DsnProviderMysql;
use Pes\Database\Handler\OptionsProvider\OptionsProviderMysql;
use Pes\Database\Handler\AttributesProvider\AttributesProviderDefault;
use Pes\Database\Handler\Handler;

use Pes\Database\Statement\Cache;

use Psr\Log\NullLogger;


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
     * Model
     */
    class Person {
        public $name;
        public $surname;
    }
    
interface RowDataInterface extends \IteratorAggregate, \ArrayAccess, \Serializable, \Countable {   
    // extenduje všechna rozhraní, která implementuje \ArrayObject - mimo \Traversable,  to nelze neb je prázdné
    public function isChanged();
    public function getChanged();
}    


class RowData extends \ArrayObject implements RowDataInterface {
            
    protected $changed;
    
    public function __construct($data = []) {
        parent::__construct($data, \ArrayObject::ARRAY_AS_PROPS);
        $this->changed = new \ArrayObject();
    }
    
    public function getChanged() {
        return $this->changed;
    }
    
    public function isChanged() {
        return $this->changed->count() ? TRUE : FALSE;
    }
    
    public function offsetGet($index) {
        return parent::offsetGet($index);
    }
    
    public function offsetExists($index) {
        return parent::offsetExists($index);
    }
    
    public function offsetSet($index, $value) {
        if (parent::offsetExists($index) AND parent::offsetGet($index) != $value) {
            parent::offsetSet($index, $value);
            $this->changed->offsetSet($index, $value);  //duplikuji data - nemusím je pak vybírat nebo odmazávat z původního array objectu - předpokládám, že se ukládá jen málo
        }
    }
    
    public function exchangeArray($data) {
        $oldArray = parent::exchangeArray($data);
        $this->changed->exchangeArray($this);  // změnila se všechna data
        return $oldArray;
    } 
    
    public function append($value) {
        throw new LogicException('Nelze vkládat neindexovaná data. Použijte offsetSet().');
    }

}

class RowBigData extends RowData {
    public function getChanged() {
        foreach ($this as $key => $value) {
            if ($this->changed->offsetExists($key)) {
                $this->changed->offsetSet($key, $value);
                $this->offsetUnset($key);
            }
        }
    }
    
    public function offsetSet($index, $value) {
        if (parent::offsetExists($index) AND parent::offsetGet($index) != $value) {
            parent::offsetSet($index, $value);
            $this->changed[] = $index;
        }
    }    
}
    
        //vymaže tabulku, zapíše tři řádky v UTF8
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME ; 
        $dbh = new PDO($dsn, USER, PASS, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        $dbh->exec('DELETE FROM person');
        $dbh->exec('INSERT INTO person (name, surname) VALUES ("Adam","Adamov")');
        $dbh->exec('INSERT INTO person (name, surname) VALUES ("Božena","Boženová")');
        $dbh->exec('INSERT INTO person (name, surname) VALUES ("Cyril","'.TESTOVACI_STRING.'")');
        $dbh->exec('INSERT INTO person (name, surname) VALUES ("David","'.TESTOVACI_STRING.'")');
        
        $connectionInfoUtf8 = new ConnectionInfo(NICK, DbTypeEnum::MySQL, DB_HOST, USER, PASS, CHARSET_UTF8, COLLATION_UTF8, DB_NAME, DB_PORT);        
        $dsnProvider = new DsnProviderMysql();
        $optionsProvider = new OptionsProviderMysql();
        $logger = new NullLogger();
        $attributesProviderDefault = new AttributesProviderDefault();
        $dbh = new Handler($connectionInfoUtf8, $dsnProvider, $optionsProvider, $attributesProviderDefault, $logger);    
        $stmt = $dbh->query('SELECT name, surname FROM person');
        $stmt->setFetchMode();
        // 1. řádek - Adam - bez fetch mode
        $res1 = $stmt->fetch();
        // 2. řádek Božena - fetch mode \PDO::FETCH_ASSOC
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $res2 = $stmt->fetch();
        // 3. řádek Cyril - fetch mode \PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, 'Person'
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, 'Person');
        $res3 = $stmt->fetch();        
        // 4. řádek David - fetch mode \PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, 'RowData'
        $stmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, 'RowData');
        $res3 = $stmt->fetch();      
        
        $end = 0;