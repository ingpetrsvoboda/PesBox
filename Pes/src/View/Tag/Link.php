<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\LinkAttributes;

/**
 * Description of Link
 *
 * @author pes2704
 */
class Link extends MetadataContent {

    /**
     * @var LinkAttributes 
     */
    private $attributes;

    public function __construct() {
        $this->name = 'link';
        $this->attributes = new LinkAttributes();
    }
    
    /**
     * 
     * @return LinkAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }    
}
