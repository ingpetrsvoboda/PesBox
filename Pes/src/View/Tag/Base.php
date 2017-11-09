<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\BaseAttributes;

/**
 * Description of Base
 *
 * @author pes2704
 */
class Base extends MetadataContent {

    /**
     * @var BaseAttributes 
     */
    private $attributes;
    
    public function __construct() {
        $this->name = 'base';
        $this->attributes = new BaseAttributes();
    }

    /**
     * 
     * @return BaseAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }    
}
