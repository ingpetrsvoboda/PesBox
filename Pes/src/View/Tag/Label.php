<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\LabelAttributes;

/**
 * Description of Chyby
 *
 * @author pes2704
 */
class Label extends TagAbstract {

    /**
     * @var LabelAttributes 
     */
    private $attributes;

    public function __construct() {
        $this->name ='label';
        $this->setAttributes(new LabelAttributes());
    }
    
    /**
     * 
     * @return LabelAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }    
}

