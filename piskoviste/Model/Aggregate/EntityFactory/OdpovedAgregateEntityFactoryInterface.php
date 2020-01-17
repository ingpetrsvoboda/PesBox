<?php
namespace Tester\Model\Aggregate\EntityFactory;

use Tester\Model\Aggregate\Entity\OdpovedAggregate;


/**
 *
 * @author vlse2610
 */
interface OdpovedAgregateEntityFactoryInterface {
    /**
     * 
     * @return Tester\Model\Aggregate\Entity\OdpovedAggregate Description
     */
    public function createSOdpovedmi ( array $vsechnyOdpovedi ): OdpovedAggregate;
    
    
}  
