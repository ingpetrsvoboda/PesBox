<?php
namespace Tester\Model\Aggregate\Hydrator;

use Tester\Model\Aggregate\Entity\EntityInterface;

/**
 * Description of TestAggregateHydrator
 *
 * @author vlse2610
 */
class TestAggregateHydrator implements HydratorInterface {

    
    
    public function hydrate( EntityInterface $entity ,$property,  $value ) {                   
            $entity->$property = $value;            
            return $entity;
    }
    
    
    
    
    public function extract(  EntityInterface $entity, $propertyName ) {
        return $entity->$propertyName;
    }
}





//    
//    public function hydrate(
//            AggEntity\SpustenyTestAggregate $spustenyTestAggregateE, 
//                      DbEntity\SpustenyTest $spustenyTestE, 
//                  DbEntity\KonfiguraceTestu $konfiguraceTestuE, 
//                     DbEntity\TicketPouzity $ticketPouzityE,
//                        DbEntity\SadaOtazek $sadaOtazekE,
//                                            $arrayOtazkyC,
//                 SessionEntity\SpustenyTest $sessionSpustenyTest
//                         //VstupniPrikazSpust $vstupniPrikaz = NULL
//            ) {
//                    
//            $spustenyTestAggregateE->spustenyTest = $spustenyTestE;
//            $spustenyTestAggregateE->konfiguraceTestu = $konfiguraceTestuE;  
//            $spustenyTestAggregateE->ticketPouzity = $ticketPouzityE;   
//            $spustenyTestAggregateE->sadaOtazek = $sadaOtazekE;                        
//            $spustenyTestAggregateE->otazky = $arrayOtazkyC;  
//            $spustenyTestAggregateE->sessionSpustenyTest = $sessionSpustenyTest;
//           /* $spustenyTestAggregateE->vstupniPrikaz = $vstupniPrikaz;*/
//            return $entitySpustenyTest;
//    }
    
    
//    public function hydrate(  AggEntity\EntityInterface $entity, $propertyName, $value ) {                   
//            $entity->$propertyName = $value;            
//            return $entity;
//    }