<?php

namespace Tester\Model\File\Entity\Otazka\Zadani;

use Tester\Model\File\Entity\EntityInterface;

use Tester\Model\File\Entity\Otazka\Zadani\Obsah\Obsah;
use Tester\Model\File\Entity\Otazka\Zadani\Odpoved\Odpoved;

/**
 * Description of Zadani
 *
 * @author vlse2610
 */
class Zadani implements EntityInterface{
    /**
     * @var string 
     */
    private $type;
    /**
    *
    * @var Obsah
    */
    private $obsah;
    /**
    *
    * @var Odpoved
    */
   private $odpoved;

   public function getType() {
       return $this->type;
   }

   public function getObsah(): Obsah {
       return $this->obsah;
   }

   public function getOdpoved(): Odpoved {
       return $this->odpoved;
   }

   public function setType($type) {
       $this->type = $type;
       return $this;
   }

   public function setObsah(Obsah $obsah) {
       $this->obsah = $obsah;
       return $this;
   }

   public function setOdpoved(Odpoved $odpoved) {
       $this->odpoved = $odpoved;
       return $this;
   }
}
