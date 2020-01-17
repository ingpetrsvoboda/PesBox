<?php
namespace Tester\Model\Aggregate\EntityFactory;

use Tester\Model\Prikaz\VstupniPrikazSpust;
use Tester\Model\Prikaz\VstupniPrikazUkaz;
use Tester\Model\Aggregate\Entity as AggEntity;


/**
 *
 * @author vlse2610
 */
interface TestAgregateEntityFactoryInterface {
    /**
     * 
     * @param VstupniPrikazSpust $vstupniPrikaz
     */
    public function createByPrikazSpust (VstupniPrikazSpust $vstupniPrikaz) : AggEntity\TestAggregate;
    
    /**
     * 
     * @param \Tester\Model\Aggregate\EntityFactory\VstupniPrikazUkaz $vstupniPrikaz
     */
    public function createByPrikazUkaz (VstupniPrikazUkaz $vstupniPrikaz) : AggEntity\TestAggregate;
    
}
