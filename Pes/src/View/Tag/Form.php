<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\FormAttributes;

/**
 * Description of Form
 *
 * @author pes2704
 */
class Form extends TagAbstract {

    /**
     * @var FormAttributes 
     */
    private $attributes;

    public function __construct() {
        $this->name = 'form';
        $this->setAttributes(new FormAttributes());
    }
    
    /**
     * 
     * @return FormAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }    
}

