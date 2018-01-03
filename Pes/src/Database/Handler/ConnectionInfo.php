<?php

/*
 * Objektový typ pro údaje o připojení k db.
 */

namespace Pes\Database\Handler;

use Pes\Database\Handler\DbTypeEnum;

/**
 * Description of ConnectionInfo
 *
 * @author pes2704
 */
final class ConnectionInfo implements ConnectionInfoInterface, \Serializable {

    private $dbNick;
    private $dbType;
    private $dbName;
    private $user;
    /**
     * Hodnota této vlastnosti se získává v handleru podle návu jména vlastnosti - nepřejmenovávat!
     */
    private $pass;
    private $dbHost;
    private $dbPort;
    private $charset;
    private $collation;

    /**
     * Všechny vlastnosti objektu jsou zadány jako instanční proměnnné do konstruktoru. Nelze je později měnit, třída neobsahuje settery.
     * Pro získání hodnot vlastností třída používá gettery, výjimkou je vlastnost pass, která z bezpečnostních důvodů getter nemá.
     * <p><b>charset a collation</b><br>
     * Některé parametry mají defaultní hodnoty, které předpokládají předávání dat v kódování utf8 a s řazením utf8_czech_ci. 
     * Pro jiné kódování a řazení je třeba zadat příslušné hodnoty, zadání NULL způsobí použití default hodnot databáze nebo MySQL aplikace.
     * Pokud $charset nebo $collation jsou nastaveny na NULL, použije MySQL defaultní hodnoty pro konkrétní databázi nastavené při vytváření
     * databáze např.:</p>
     * <pre>
     * CREATE DATABASE mydb DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
     * </pre>
     * nebo defaultní hodnotu pro MySQl aplikaci nastavené v konfiguraci např.:
     * <pre>
     *  [mysqld]
     *  character-set-server=utf8
     *  collation-server=utf8_general_ci
     * </pre>
     * <p><b>port</b><br>
     * Nepovinný parametr, pokud není zadán nikde v handleru se nepoužije a MySQL driver sám použije default (well known) port 3306. 
     * Pokud chceš používat jiný port, musí se vždy jako parametr dbHost použít IP adresa. Např. nesmí být host zadán jako "localhost", musí být 127.0.0.1</p>
     * <p><b>dbName</b><br>
     * Parametr $dbName je skutečné aktuální jméno databáze a je nepovinný. Pokud databáze dosud neexistuje je parametr prázdný. S připojením vytvořeným bez jména databáze je
     * možné vytvořit novou databázi (CREATE DATABASE). Nelze však použít postup: new ConnectionInfo bez dbName -> new Handler(ConnectionInfo) -> CREATE DATABASE dabaname ->
     * USE dabaname -> ConnectionInfo->setDbName(dabaname). Namísto toho je třeba spojení zahodit a vytvořit nové s použitím nového ConnectionInfo, již obsahujícího
     * dbName. Toto nové připojení by obvykle mělo mít také jiné parametry user a pass, protože práva pro vytváření databází budou asi jiná než práva ke konkrétní 
     * nové databázi.</p>
     *  
     * @param string $dbNick Přezdívka databáze
     * @param string $dbType Typ databáze jako hodnota výčtového typu Pes\Type\DbTypeEnum
     * @param string $dbHost IP adresa nebo doménové jméno hostitelského stroje. Při použití parametru dbPort je nutné použít IP adresu.
     * @param string $user Jméno uživatele pro přihlášení
     * @param string $pass Heslo uživatele pro přihlášení (třída nemá metodu getPass())
     * @param string $dbName Nepovinný parametr skutečné aktuální jméno databáze. Pokud databáze dosud neexistuje je parametr prázdný.
     * @param string $charset Nepovinný parametr, dafault hodnota je 'utf8', zadání NULL způsobí použití default hodnoty databáze nebo MySQL aplikace
     * @param string $collation Nepovinný parametr, dafault hodnota je 'utf8_czech_ci', zadání NULL způsobí použití default hodnoty databáze nebo MySQL aplikace
     * @param integer $dbPort Nepovinný parametr, dafault hodnota je NULL (pak driver použije standartní port 3306)
     */
    public function __construct($dbNick, $dbType, $dbHost, $user, $pass, $dbName=NULL, $charset = 'utf8', $collation = 'utf8_czech_ci', $dbPort=NULL) {
        $this->dbNick = $dbNick;
        $this->dbType = (new DbTypeEnum())($dbType);
        $this->dbHost = $dbHost;
        $this->user = $user;
        $this->pass = $pass;
        $this->charset = $charset;
        $this->collation = $collation;
        $this->dbName = $dbName;
        $this->dbPort = $dbPort;
    }
    
    /**
     * Ochrana proti neúmyslnému zobrazení obsahu.
     * Objekt obsahuje citlivá data, pro jistotu bráním jeko serializaci. Vracím potichu Null, nevyhazuji výjimku.
     * @return NULL
     */
    public function serialize() {       
        return NULL;
    }
    
    public function unserialize($data) {
    }    
    
// alternativa:    
//    public function __sleep() {
//        assert(FALSE, 'Non serializable object.');
//        return ;
//    }    

    public function getDbNick() {
        return $this->dbNick;
    }

    public function getDbType() {
        return $this->dbType;
    }

    public function getDbName() {
        return $this->dbName;
    }

    public function getUser() {
        return $this->user;
    }
    
    // Tato metoda neexistuje z bezpečnostních důvodů!
//    public function getPass() {
//        return $this->pass;
//    }

    public function getDbHost() {
        return $this->dbHost;
    }

    public function getDbPort() {
        return $this->dbPort;
    }

    public function getCharset() {
        return $this->charset;
    }

    public function getCollation() {
        return $this->collation;
    }


}
