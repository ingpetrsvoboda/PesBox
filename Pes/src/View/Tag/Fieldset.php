<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\FieldsetAttributes;

/**
 * Description of Fieldset
 *
 * @author pes2704
 */
class Fieldset extends TagAbstract {    

    /**
     * @var FieldsetAttributes 
     */
    private $attributes;

    public function __construct() {
        $this->name = 'fieldset';
        $this->attributes = new FieldsetAttributes();
    }
    
    /**
     * 
     * @return FieldsetAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }
}

