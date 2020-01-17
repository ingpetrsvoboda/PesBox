<?php

namespace Tester\Model\File\Entity;

use Tester\Model\File\Entity\Navigace\Navigace;
use Tester\Model\File\Entity\Otazka\Otazka;

class Uloha implements /*\Tester\Model\File\Entity\*/EntityInterface {
        
    /**
     *
     * @var Navigace
     */
    private $navigace;
    /**
     *
     * @var Otazka
     */
    private $otazka;
    
    /**
     * @return Navigace
     */
    public function getNavigace(): Navigace {
        return $this->navigace;
    }

    /**
     * @return Otazka
     */
    public function getOtazka(): Otazka {
        return $this->otazka;
    }

    public function setNavigace( Navigace $navigace) {
        $this->navigace = $navigace;
        return $this;
    }

    public function setOtazka(Otazka $otazka) {
        $this->otazka = $otazka;
        return $this;
    }
}

