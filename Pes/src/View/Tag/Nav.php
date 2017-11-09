<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\GlobalAttributes;

/**
 * Description of Footer
 *
 * @author pes2704
 */
class Nav extends TagAbstract {

    /**
     * @var FooterAttributes 
     */
    private $attributes;

    public function __construct() {
        $this->name = 'nav';
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
