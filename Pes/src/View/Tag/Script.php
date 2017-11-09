<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\ScriptAttributes;

/**
 * Description of Link
 *
 * @author pes2704
 */
class Script extends MetadataContent {

    /**
     * @var LinkAttributes 
     */
    private $attributes;

    public function __construct() {
        $this->name = 'script';
        $this->attributes = new ScriptAttributes();
    }
    
    /**
     * @return ScriptAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }       
}
