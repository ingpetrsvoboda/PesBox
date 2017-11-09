<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\EventsAttributes;

/**
 * Description of Div
 *
 * @author pes2704
 */
class Div extends TagAbstract {

    /**
     * @var GlobalAttributes 
     */
    private $attributes;

    public function __construct(array $attributes=[]) {
        $this->name = 'div';
        $this->attributes = new EventsAttributes($attributes);
    } 
    
    /**
     * 
     * @return EventsAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }    
}
