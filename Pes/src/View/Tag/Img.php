<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\ImgAttributes;

/**
 * Description of Img
 * 
 * @author pes2704
 */
class Img extends TagAbstract {

    /**
     * @var ImgAttributes 
     */
    private $attributes;

    public function __construct(array $attributes=[]) {
        $this->name = 'img';
        $this->attributes = new ImgAttributes($attributes);
    }
    
    /**
     * 
     * @return ImgAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }    
}
