<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\PAttributes;

/**
 * Description of P
 *
 * @author pes2704
 */
class P extends TagAbstract {

    /**
     * @var LinkAttributes 
     */
    private $attributes;

    public function __construct() {
        $this->name = 'p';
        $this->setAttributes(new PAttributes());
    }
    
    /**
     * 
     * @return PAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }        
}
