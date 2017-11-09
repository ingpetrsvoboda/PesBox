<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\MetaAttributes;

/**
 * Description of Link
 *
 * @author pes2704
 */
class Meta extends MetadataContent {

    /**
     * @var LinkAttributes 
     */
    private $attributes;

    public function __construct() {
        $this->name = 'meta';
        $this->attributes = new MetaAttributes();
    }
    
    /**
     * 
     * @return MetaAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }    
}
