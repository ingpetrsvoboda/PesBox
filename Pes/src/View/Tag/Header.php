<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\GlobalAttributes;

/**
 * Description of Header
 *
 * @author pes2704
 */
class Header extends TagAbstract {

    /**
     * @var HeaderAttributes 
     */
    private $attributes;

    public function __construct(array $attributes=[]) {
        $this->name = 'header';
        $this->attributes = new GlobalAttributes($attributes);
    }
    
    /**
     * 
     * @return GlobalAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }    
}
