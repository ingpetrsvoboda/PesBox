<?php
use PHPUnit\Framework\TestCase;



/*
 * Copyright (C) 2017 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

use Pes\Database\Handler\ConnectionInfo;
use Pes\Database\Handler\DbTypeEnum;
use Pes\Database\Handler\DsnProvider\DsnProviderMysql;
use Pes\Database\Handler\OptionsProvider\OptionsProviderMysql;
use Pes\Database\Handler\OptionsProvider\OptionsProviderNull;
use Pes\Database\Handler\AttributesProvider\AttributesProviderNull;
use Pes\Database\Handler\AttributesProvider\AttributesProviderDefault;
use Pes\Database\Handler\Handler;

use Pes\Database\Statement\StatementInterface;

use Psr\Log\NullLogger;

/**
 * Description of DnProviderTest
 *
 * @author pes2704
 */
class OptionsProviderNullTest extends TestCase {
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
    
    public function testMysqlOptionProvider() {
        $connectionInfoUtf8 = new ConnectionInfo(self::NICK, DbTypeEnum::MySQL, self::DB_HOST, self::USER, self::PASS, self::DB_NAME, self::CHARSET_UTF8, self::COLLATION_UTF8, self::DB_PORT);
        $dsnProvider = new DsnProviderMysql();
        $optionsProvider = new OptionsProviderNull();
        $logger = new NullLogger();
        $attributesProviderNull = new AttributesProviderNull($logger);
        // kontrolní UPDATE bez nastavení options provideru
        $dbh = new Handler($connectionInfoUtf8, $dsnProvider, $optionsProvider, $attributesProviderNull, $logger);
        $this->assertTrue($dbh instanceof Handler, 'Nevytvořil se objekt Handler z dsn poskytnutého dsn providerem (a zadanými parametry).');
        $stmt = $dbh->query('UPDATE person SET surname="'.self::TESTOVACI_STRING.'" WHERE name="Cyril"');
        $rCount = $stmt->rowCount();
        $this->assertEquals(0, $rCount, 
                'UPDATE řádku stejnými hodnotami jako již v řádku jsou, bez nastavení parametrů handleru objektem attributes setter vrací nenulovou hodnotu.'
                . ' Buď se změnila funkčnost handleru nebo není v db správně fixture s hodnotami setUp() metody.');      
        
        $this->assertTrue($stmt instanceof \PDOStatement, 'Nevytvořil se objekt typu PDOStatement z Handler->query.');
    }
    
}
