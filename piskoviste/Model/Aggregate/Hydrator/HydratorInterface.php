<?php
namespace Tester\Model\Aggregate\Hydrator;


use Tester\Model\Aggregate\Entity\EntityInterface;
/**
 *
 * @author vlse2610
 */
interface HydratorInterface {
    public function hydrate(  EntityInterface $entity ,$property,  $value );
    public function extract(  EntityInterface $entity, $propertyName ) ;
}
