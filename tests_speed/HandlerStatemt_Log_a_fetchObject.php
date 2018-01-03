<?php

/* 
 * tyto metody byly použity jako metody v testu StatementTest a spouštěny v rámci unit testů
 * pro opakování testu stačí je znovu vložit do StatementTest - časy jsou výsledky z PHPUnit
 */

    /**
     * 26, 21ms testStatement
     * 1000x čtení tabulky person, vše v testu PhpUnit a s XDebug
     * 
     * Bez logování v Handleru a Statementu (zakomentováno)
     * 317, 316, 333, 314, 301, 299ms fetch array - avg 313
     * 397, 303, 298, 317, 359, 296ms fetch Person - avg 330 
     * celkem avg bez logování 321ms
     * 
     * S logování v Handleru a Statementu
     * 393, 360, 365ms fetch array, NullLogger - avg 373
     * 332, 389, 331ms fetch Person, NullLogger - avg 351
     * 366, 356, 451ms fetch array, FileLogger - avg 357 (celkem fetch array avg 365)
     * 399, 365, 445ms fetch Person, FileLogger - avg 403 (celkem fetch Person avg 377)
     * celkem avg s logováním 371ms
     * 
     * - rychlost Handler - zkusil jsem jen několik testů
     *      - "příprava" t.j. ConnectionInfo, Dsn, Options, Attributes providery - nic
     *      - vlastní handler (PDO) 21-25ms jedno připojení!
     * 
     * - fetch array nebo Person: 
     *      - zvítězilo array, ale zanedbatelně, zřejmě by vyrábění objektů s hydratováním vlastností z pole trvalo déle (v PDO je to 12 microsec na objekt)
     * - bez a s logováním v Handleru a Statementu:
     *      - bez logování je test rychlejší 321ms versus 371 ms (tedy cca 30 microsec verus 35 microsec na jeden statement), to jest s logem je test o 14% pomalejší
     * - velikost logu: 
     *      - logováno 2000 příkazů (vždy 4 záznamy: prepare->execute->setFechMode->fetch), log je velký ca 200kB
     * - Null versus File logger: 
     *      - páry testů spuštěné při jednom běhu skriptu - vždy s Null a File loggerem jsou: 393-366, 360-356, 365-451 a 332-399, 389-365, 331-445
     *      - obvykle mají Null a File logger stejné časy (dokonce častěji vítězí File logger
     *      - ale zdá se, že při logování do souboru občas dojde k prodlevě (80ms, 110ms) - asi se občas čeká na file system
     * 
     * 
     */  

class JesemTuAbyToNebyloVsechnoCervene {
    public function testStatementWithNullLogger() {
        $dir = 'LogsFromStatementTests';

        $logger = new NullLogger();

        $connectionInfoUtf8 = new ConnectionInfo(self::NICK, DbTypeEnum::MySQL, self::DB_HOST, self::USER, self::PASS, self::DB_NAME, self::CHARSET_UTF8, self::COLLATION_UTF8, self::DB_PORT);        
        $dsnProvider = new DsnProviderMysql();
        $optionsProvider = new OptionsProviderMysql();
        $attributesProviderDefault = new AttributesProviderDefault($logger);
        $dbh = new Handler($connectionInfoUtf8, $dsnProvider, $optionsProvider, $attributesProviderDefault, $logger);            

        for ($i = 1; $i <= 1000; $i++) {
            $prestmt = $dbh->prepare('SELECT name, surname FROM person WHERE number=:number');
            $key = ($i % 3)+1;
            $prestmt->bindParam(':number', $key);
            $prestmt->execute();
            $prestmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, 'Person');    // fetch array 320 microsec, fetch Person 670 microsec (s XDebug)
            $res = $prestmt->fetch();
        }
    }    
    

    
    
    public function testStatementWithFileLogger() {
        $dir = 'LogsFromStatementTests';
        $file = 'TestStatement.log';
        $logger = FileLogger::getInstance($dir, $file, FileLogger::REWRITE_LOG);

        $connectionInfoUtf8 = new ConnectionInfo(self::NICK, DbTypeEnum::MySQL, self::DB_HOST, self::USER, self::PASS, self::DB_NAME, self::CHARSET_UTF8, self::COLLATION_UTF8, self::DB_PORT);        
        $dsnProvider = new DsnProviderMysql();
        $optionsProvider = new OptionsProviderMysql();
        $attributesProviderDefault = new AttributesProviderDefault($logger);
        $dbh = new Handler($connectionInfoUtf8, $dsnProvider, $optionsProvider, $attributesProviderDefault, $logger);            

        for ($i = 1; $i <= 1000; $i++) {
            $prestmt = $dbh->prepare('SELECT name, surname FROM person WHERE number=:number');
            $key = ($i % 3)+1;
            $prestmt->bindParam(':number', $key);
            $prestmt->execute();
            $prestmt->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, 'Person'); 
            $res = $prestmt->fetch();
        }
    } 
// a uzyvírací závorka class
}