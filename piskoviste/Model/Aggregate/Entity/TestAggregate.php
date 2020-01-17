<?php

namespace Tester\Model\Aggregate\Entity;

use Tester\Model\Aggregate\Entity\EntityInterface;
use Tester\Model\Db\Entity  as DbEntity;
use Tester\Model\File\Entity as FileEntity;
use Tester\Model\Stav\Entity as StavEntity;


/**
 * Description of NnovyTestAggregate
 *
 * @author vlse2610
 */
class TestAggregate implements EntityInterface {
    
    public $idTestAggregate;
    
    /**
     * @var DbEntity\PrubehTestu 
     */
    public  $prubehTestu;
    
    /**
     * @var DbEntity\TicketPouzity 
     */
    public  $ticketPouzity; 
    
    /**     
     * @var DbEntity\KonfiguraceTestu 
     */
    public  $konfiguraceTestu;
    
    /**
     * Prislusi k tabulce sada_otazek.
     * 
     * @var DbEntity\SadaOtazek
     */
    public  $sadaOtazek;   
    
    /**
     *
     * @var FileEntity\Otazka array of 
     */
    public $ulohy;
    
    /**
     * @var StavEntity\StavTestu
     */
    public  $stav;

    
    /*public  $vstupniPrikaz;*/

    //---------------------------------------------------------------------------------
    public function __construct() {
        $this->prubehTestu = new DbEntity\PrubehTestu();
        $this->ticketPouzity = new DbEntity\TicketPouzity();
        $this->konfiguraceTestu = new DbEntity\KonfiguraceTestu();
        
        $this->sadaOtazek = new DbEntity\SadaOtazek;
        $this->ulohy =   []; 
        $this->stav = new StavEntity\StavTestu();
        
        //$this->idTestAggregate = $this->prubehTestu->idPrubehTestu;   //tady asi nic neni!!!!!
        
        
        /*$this->vstupniPrikaz = new VstupniPrikazSpust;*/
    }        
    
}
