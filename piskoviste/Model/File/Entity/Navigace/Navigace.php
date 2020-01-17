<?php

namespace Tester\Model\File\Entity\Navigace;

use Tester\Model\File\Entity\EntityInterface;
/**
 * Description of Navigace
 *
 * @author vlse2610
 */
class Navigace implements EntityInterface{
    /**
     * @var string 
     */
    private $napis;
    
    public function getNapis() {
        return $this->napis;
    }

    public function setNapis($napis) {
        $this->napis = $napis;
        return $this;
    }


}
