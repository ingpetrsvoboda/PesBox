<?php
namespace Tester\Model\Stav\Repository;

use Tester\Model\Stav\Entity as StavEntity ;

/**
 *
 * @author vlse2610
 */
interface RepositoryInterface {

    public function get();
    
    public function add( StavEntity\StavTestu  $stavEntity );
    
    public function remove ( StavEntity\StavTestu $stavEntity );
}
