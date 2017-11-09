<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\GlobalAttributes;

/**
 * Description of Footer
 *
 * @author pes2704
 */
class Main extends TagAbstract {

    /**
     * @var FooterAttributes 
     */
    private $attributes;

    public function __construct() {
        $this->name = 'main';
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
