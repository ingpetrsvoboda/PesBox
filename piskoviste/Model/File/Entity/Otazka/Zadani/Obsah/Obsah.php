<?php
namespace Tester\Model\File\Entity\Otazka\Zadani\Obsah;

use Tester\Model\File\Entity\EntityInterface;

/**
 * Description of Obsah
 *
 * @author vlse2610
 */
class Obsah implements EntityInterface {
    /**
     * @var string 
     */
    private $imgFileName;
    
    /**
     * @var string 
     */
    private $label;
    
    /**
     * @var string 
     */
    private $text;
    
    
    
    public function getImgFileName() {
        return $this->imgFileName;
    }

    public function getLabel() {
        return $this->label;
    }

    public function getText() {
        return $this->text;
    }

    public function setImgFileName($imgFileName) {
        $this->imgFileName = $imgFileName;
        return $this;
    }

    public function setLabel($label) {
        $this->label = $label;
        return $this;
    }

    public function setText($text) {
        $this->text = $text;
        return $this;
    }


}
