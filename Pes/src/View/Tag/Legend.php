<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\LegendAttributes;

/**
 * Description of Chyby
 *
 * @author pes2704
 */
class Legend extends TagAbstract {

    /**
     * @var LegendAttributes 
     */
    private $attributes;

    public function __construct() {
        $this->name = 'legend';
        $this->setAttributes(new LegendAttributes());
    }
    
    /**
     * 
     * @return LegendAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }    
}

