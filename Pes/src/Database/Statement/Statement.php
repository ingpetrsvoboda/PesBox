<?php
/**
 * Základní statement objekt pro SQL databáze. Využívá hotovou abstrakci PHP PDOStatement a jde o adapter a současně wrapper 
 * pro PDOStatement. Implementuje Framework_Database_StatementInterface.
 *
 * @author Petr Svoboda
 */
namespace Pes\Database\Statement;

class Statement extends \PDOStatement implements StatementInterface {
    
    protected function __construct() {  
        // konstruktor musí být deklarován i když je prázdný
        // bez toho nefunguje PDO::setAttribute(PDO::ATTR_STATEMENT_CLASS, ...
    }
    
}
