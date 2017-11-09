<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\StyleAttributes;

/**
 * Description of Style
 *
 * @author pes2704
 */
class Style extends MetadataContent {

    /**
     * @var LinkAttributes 
     */
    private $attributes;

    public function __construct() {
        $this->name = 'style';
        $this->attributes = new StyleAttributes();
    }
    
    /**
     * 
     * @return StyleAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }        
}
