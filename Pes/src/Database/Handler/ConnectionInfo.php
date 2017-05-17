<?php

/*
 * Objektový typ pro údaje o připojení k db.
 */

namespace Pes\Database\Handler;

use Pes\Type\DbTypeEnum;

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
     * Konstruktor. 
     * Některé parametry mají defaultní hodnoty, které předpokládají předávání dat v kódování utf8 a s řazením utf8_czech_ci. 
     * Pro jiné kódování a řazení je třeba zadat příslušné hodnoty, zadání NULL způsobí použití default hodnot databáze nebo MySQL aplikace.
     * <h4>CHARSET a COLLATION</h4>
     * Pokud $charset nebo $collation jsou nastaveny na NULL, použije MySQL defaultní hodnoty pro konkrétní databázi nastavené při vytváření
     * databáze např.:
     *  CREATE DATABASE mydb DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
     * nebo defaultní hodnotu pro MySQl aplikaci nastavené v konfiguraci např.:
     * <pre>
     *  [mysqld]
     *  character-set-server=utf8
     *  collation-server=utf8_general_ci
     * </pre>
     * <h4>PORT</h4>
     * Nepovinný parametr, pokud není zadán nikde v handleru se nepoužije a MySQL driver sám použije default (well known) port 3306. 
     * Pokud chceš používat jiný port, musí se vždy jako parametr dbHost použít IP adresa. Např. nesmí být host zadán jako "localhost", musí být 127.0.0.1

     * Parametr $dbName je skutečné aktuální jméno databáze a je nepovinný. Pokud databáze dosud neexistuje je parametr prázdný. S takto vytvořeným připojením je
     * možné vytvořit novou databázi (CREATE DATABASE). Třída je navržena tak, že neumožňuje změnit vlastnost pass. ConnectionInfo objekt použitý pro připojení pak
     * nikdy nebude obsahovat skutečné jméno databáze. Nelze tak použít postup: new ConnectionInfo bez dbName -> new Handler(ConnectionInfo) -> CREATE DATABASE dabaname ->
     * USE dabaname -> ConnectionInfo->setDbName(dabaname). Namísto toho je třeba spojení zahodit a vytvořit nové s použitím nového ConnectionInfo již obsahujícího
     * dbName. Toto nové připojení by obvykle mělo mít také jiné parametry user a pass, protože práva pro vytváření databází budou asi jiná než práva ke konkrétní 
     * nové databázi.
     * 
     * @param string $dbNick Přezdívka databáze
     * @param string $dbType Typ databáze jako hodnota výčtového typu Pes\Type\DbTypeEnum
     * @param string $dbHost IP adresa nebo doménové jméno hostitelského stroje. Při použití parametru dbPort je nutné použít IP adresu.
     * @param string $user Jméno uživatele pro přihlášení
     * @param string $pass Heslo uživatele pro přihlášení (třída nemá metodu getPass())
     * @param string $charset Nepovinný parametr, dafault hodnota je 'utf8', zadání NULL způsobí použití default hodnoty databáze nebo MySQL aplikace
     * @param string $collation Nepovinný parametr, dafault hodnota je 'utf8_czech_ci', zadání NULL způsobí použití default hodnoty databáze nebo MySQL aplikace
     * @param string $dbName Nepovinný parametr skutečné aktuální jméno databáze. Pokud databáze dosud neexistuje je parametr prázdný.
     * @param integer $dbPort Nepovinný parametr, dafault hodnota je NULL (pak driver použije standartní port 3306)
     */
    public function __construct($dbNick, $dbType, $dbHost, $user, $pass, $charset = 'utf8', $collation = 'utf8_czech_ci', $dbName=NULL, $dbPort=NULL) {
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
     * Objekt obsahuje citlivá data, pro jistotu bráním jeko serializaci. Vrcím potichu Null, nevyhazuji výjimku.
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
