<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Head;
use Pes\View\Tag\Body;

/**
 * Description of Html
 *
 * @author pes2704
 */
class Html extends TagAbstract {

    public function __construct() {
        $this->name ='html';
    }    
    
    public function addChildTag(TagInterface $element) {
        if (!($element instanceof Head OR $element instanceof Body)) {
            trigger_error("Pokus o přidání potomka typu ".get_class($element)." selhal. Tagu Html lze přidávat pouze potomkovské elementy Head a Body.");
        }
        return parent::addChildTag($element);
    }
    
    public function getAttributes() {
        ;
    }    
}
