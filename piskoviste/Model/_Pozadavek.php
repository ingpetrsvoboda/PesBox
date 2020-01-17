<?php

namespace Tester\Model;
use Pes\Database\Handler\HandlerInterface;

use Tester\Model\PozadavekInterface;


/**
 * Description of Pozadavek
 *
 * @author vlse2610
 */
class Pozadavek implements PozadavekInterface {
    
    /**
     * @var HandlerInterface 
     */
     private $dbh;

      
    public function __construct( HandlerInterface $dbh ) {
        $this->dbh = $dbh; 
    }
    
    
    
    public function find( $param ) {        
    }
    
    public function get( $id ) {        //podle primarniho klice
    }
    
    
    /**
     * Vraci vzdy 1 radek tabulky (vetu) nebo zadny NULL.
     * @param type $oznaceni
     */
    public function getPodleOznaceniPozadavku( $oznaceni ) {   
//        $prectena_veta_z_pozadavek = array( "id_ticket_fk" => "1" ) ;
//        return    $prectena_veta_z_pozadavek;
//        
        
        $query = "SELECT id_pozadavek, oznaceni_pozadavku
                    FROM pozadavek(??)                 
                    WHERE 
                    oznaceni_pozadavku = :oznaceni_pozadavku";                
        $statSelect = $this->dbh->prepare($query);
        $statSelect->bindParam(':oznaceni_pozadavku', $oznaceni);
        $succ = $statSelect->execute();

        $pp = $statSelect->rowCount();    
        $prectena_veta_z_pozadavek =  $statSelect->fetch(\PDO::FETCH_ASSOC);

        return    $prectena_veta_z_pozadavek; 
    }
    
    
    
    public function save( $oznaceni, $id  = NULL ) {
        if ($id) {
            //update ?? potrebuji???
        }
        else {
        $query = "INSERT INTO pozadavek " .
                     "SET oznaceni_pozadavku  = :oznaceni_pozadavku, inserted = now()" ;   
        $statInsert = $dbh->prepare($query);
        $statInsert->bindParam(':oznaceni_pozadavku', $oznaceni);
        $succInsert = $statInsert->execute();   
        
        
        
  //        if (!$id) {
//            $query = "INSERT INTO pozadavek " .
//                     "SET oznaceni_zadosti  = :oznaceni, inserted = now()" ;                                
//            $statInsert = $dbh->prepare($query);
//            $statInsert->bindParam(':oznaceni', $oznaceni);
//            $succInsert = $statInsert->execute();    
            
            
//              $query = "INSERT INTO pozadavek " .
//                       "SET id_ticket_fk  = :id_ticket_fk, inserted = now()" ;                                
//              $statInsert = $this->dbh->prepare($query);
//              $statInsert->bindParam(':id_ticket_fk', $oznaceni);
//              $succInsert = $statInsert->execute();        
              
              
          }  
        

        
    }    
    
}
