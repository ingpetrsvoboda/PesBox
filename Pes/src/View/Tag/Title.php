<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\TitleAttributes;

/**
 * Description of Title
 *
 * @author pes2704
 */
class Title extends MetadataContent {

    /**
     * @var LinkAttributes 
     */
    private $attributes;

    public function __construct() {
        $this->name = 'title';
        $this->attributes = new TitleAttributes();
    }
    
    /**
     * 
     * @return TitleAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }        
}
