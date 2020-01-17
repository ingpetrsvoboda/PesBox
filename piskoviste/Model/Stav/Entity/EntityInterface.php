<?php
namespace Tester\Model\Stav\Entity;


/**
 *
 * @author vlse2610
 */
interface EntityInterface {
    
    public function setPersisted( bool $isPersisted );
    
    public function isPersisted();
}
