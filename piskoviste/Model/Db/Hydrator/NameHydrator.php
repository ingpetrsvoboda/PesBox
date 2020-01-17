<?php


namespace Tester\Model\Db\Hydrator;

/**
 * Description of NameHydrator
 *
 * @author vlse2610
 */
class NameHydrator implements NameHydratorInterface {
    
    public function hydrate($underscoredName){
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $underscoredName))));
    }

    public function extract($camelCaseName) {
        return strtolower(preg_replace( '/([a-z0-9])([A-Z])/', "$1_$2", $camelCaseName ));
    }
}
