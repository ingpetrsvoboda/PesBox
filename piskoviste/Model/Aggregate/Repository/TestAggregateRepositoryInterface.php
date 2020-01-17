<?php

namespace Tester\Model\Aggregate\Repository;

use Tester\Model\Aggregate\Entity as AggEntity;
//use Tester\Model\Prikaz\VstupniPrikazSpust;

/**
 * Description of NovyTestRepositoryInterface
 *
 * @author vlse2610
 */
interface TestAggregateRepositoryInterface {
    
    /**
     *      
     */
    public function get( ) ;
    

    /**
     * 
     * @param \Tester\Model\Aggregate\Entity\TestAggregate $entity
     */
    public function add ( AggEntity\TestAggregate $entity );
   
 
}
    
