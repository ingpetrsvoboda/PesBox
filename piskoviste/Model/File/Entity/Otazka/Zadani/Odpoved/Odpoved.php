<?php
namespace Tester\Model\File\Entity\Otazka\Zadani\Odpoved;

use Tester\Model\File\Entity\EntityInterface;

use Tester\Model\File\Entity\Otazka\Zadani\Odpoved\Data\Data;
/**
 * Description of Odpoved
 *
 * @author vlse2610
 */
class Odpoved implements EntityInterface {
    /**
     * @var string 
     */
    private $type;
    
    /**
     *
     * @var Data 
     */
    private $data;
    
    public function getType() {
        return $this->type;
    }

    public function getData(): Data {
        return $this->data;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function setData(Data $data) {
        $this->data = $data;
        return $this;
    }
}
