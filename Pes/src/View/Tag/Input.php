<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\InputAttributes;

/**
 * Description of Input
 * 
 * @author pes2704
 */
class Input extends TagAbstract {

    /**
     * @var InputAttributes 
     */
    private $attributes;

    public function __construct() {
        $this->name = 'input';
        $this->attributes = new InputAttributes();
    }
    
    /**
     * 
     * @return InputAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }    
}
