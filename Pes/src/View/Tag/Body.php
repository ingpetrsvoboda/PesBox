<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\GlobalAttributes;

/**
 * Description of Body
 *
 * Dědí Global
 * 
 * @author pes2704
 */
class Body extends TagAbstract {

    /**
     * @var GlobalAttributes 
     */
    private $attributes;

    public function __construct() {
        $this->name = 'body';
        /**
         * @var GlobalAttributes
         */
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
