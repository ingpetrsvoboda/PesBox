<?php

namespace Tester\Model;

use Tester\Model\Handler\Session\SessionInterface;
use Pes\Database\Handler\HandlerInterface;

/**
 * Description of Odpovedi
 *
 * @author vlse2610
 */
class Odpovedi implements OdpovediInterface {
    
     
    /**
     * @var HandlerInterface 
     */
    private $dbh;
    
    /**
     *
     * @var SessionInterface
     */
    private   $session;
    
    
   /**
    * 
    * @param \Tester\Model\HandlerInterface $dbh
    * @param \Tester\Model\Handler\SessionInterface $session
    */ 
    public function __construct( HandlerInterface  $dbh, SessionInterface $session) {
        $this->dbh = $dbh;
        $this->session = $session;
    }
    
    
   
    public function getPodleIdPozadavek ($id_pozadavek) {
        
    }
    
    public function get($id) {        
        
    }
    public function find () {
        
    }
    
    public function save ($id_pozadavek,  HTML_QuickForm2_Controller_Page $page) {
        
        if ( $id_pozadavek ) {
            $s = "INSERT INTO odpovedi set ";                     
            foreach ($page->getController()->getValue() as $key => $value) {
                $s .= ' ' .$key . ' = ' .  $value . ', ';        
            }                        
            $query =  $s .  'id_pozadavek_fk = :idpozadavek  inserted = now()';
            
            $statInsert = $dbh->prepare($query);
            $statInsert->bindParam(':idpozadavek', $this->session->get('id_pozadavek') );
                    //$_SESSION['id_pozadavek']);
            $succInsert = $statInsert->execute();         
          }  
        
        
//        $s = 'insert into  odpovedi set  ';       
//        foreach ($page->getController()->getValue() as $key => $value) {
//            $s .= ' ' .$key . ' = ' .  $value . ', ';        
//        }                        
//        $query =  $s .  'id_pozadavek_fk =  ' . $_SESSION['id_pozadavek'] . ', inserted = now()';
//        //echo    $query;
//        $statt = $dbh->prepare($query);
//        $succ = $statt->execute();    
//        
    }
}
