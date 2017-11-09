<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\NoscriptAttributes;

/**
 * Description of Link
 *
 * @author pes2704
 */
class Noscript extends MetadataContent {

    /**
     * @var LinkAttributes 
     */
    private $attributes;

    public function __construct() {
        $this->name = 'noscript';
        $this->attributes = new NoscriptAttributes();
    }
    
    /**
     * 
     * @return NoscriptAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }    
}
