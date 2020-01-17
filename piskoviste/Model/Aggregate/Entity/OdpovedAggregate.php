<?php
namespace Tester\Model\Aggregate\Entity;

use Tester\Model\Db\Entity as DbEntity;
use Tester\Model\Stav\Entity as StavEntity;

/**
 * Description of odpovedAggregate
 *
 * @author vlse2610
 */
class OdpovedAggregate implements EntityInterface {
    
    public $idOdpovedAggregate;
    
    
    /**
     * @var DbEntity\Odpoved 
     */
    public $odpoved;
        
    /**
     *
     * @var DbEntity\OdpovedNaOtazku array of 
     */
    public $odpovediNaOtazky;        
    
    /**
     *
     * @var StavEntity\StavTestu 
     */
    public  $stav;
    
    
    
    
    
    public function __construct(  ) {
        $this->odpoved = new DbEntity\Odpoved();
        $this->odpovediNaOtazky = [];
        $this->stav = new StavEntity\StavTestu();  
        
        //$this->idOdpovedAggregate = $this->odpoved->idOdpoved;   //zde neni nic!!??!!
    }
    
    
    
}
