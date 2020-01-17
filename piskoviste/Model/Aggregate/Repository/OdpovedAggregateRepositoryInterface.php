<?php

namespace Tester\Model\Aggregate\Repository;

use Tester\Model\Aggregate\Entity as AggEntity;

/**
 * Description of OdpovedRepositoryInterface
 *
 * @author vlse2610
 */
interface OdpovedAggregateRepositoryInterface {
    
    public function get($id);
    
   
  //  public function create ( array $vsechnyOdpovedi /*/,  $idSpustenyTest */ );
    
 
    /**
     *  @param \Tester\Model\Aggregate\Entity\OdpovedAggregate $entity
     */
    public function add (AggEntity\OdpovedAggregate $entity );
    
    
}