<?php
namespace Tester\Model\Request\Entity;


/**
 *
 * @author vlse2610
 */
interface EntityInterface {
    
    public function setPersisted( bool $persisted );
    
    public function isPersisted();
}
