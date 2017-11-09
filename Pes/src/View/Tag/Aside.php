<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\GlobalAttributes;

/**
 * Description of Footer
 *
 * @author pes2704
 */
class Aside extends TagAbstract {

    /**
     * @var GlobalAttributes 
     */
    private $attributes;

    public function __construct() {
        $this->name = 'aside';
        $this->attributes = new GlobalAttributes();
    } 
    
    /**
     * 
     * @return GlobalAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }    
}
