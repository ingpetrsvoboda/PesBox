<?php

namespace Pes\View\Tag;

use Pes\View\Tag\Attributes\GlobalAttributes;
use Pes\View\Tag\MetadataContent;
use Pes\View\Node\TextInterface;

/**
 * Description of Head
 * 
 * Dědí Global
 *
 * @author pes2704
 */
class Head extends TagAbstract {

    /**
     * @var GlobalAttributes 
     */
    private $attributes;

    public function __construct() {
        $this->name = 'head';
        $this->attributes = new GlobalAttributes();
    }    

    /**
     * Přetěžuje netodu addChild() třídy TagAbstract.
     * Jako prametr (potomkovský tag) přijímá pouze tagy typu MetadataContent. MetadataContent je společný společný předek všem tagům s metadata obsahem: 
     * Title, Style, Base, Link, Meta, Script, Noscript. Metadata tagy jsou tagy přípustné jako potomci tagu Head.
     * 
     * @param MetadataContent $element
     * @return $this
     */
    public function addChildTag(TagInterface $element) {
        if (!($element instanceof MetadataContent OR $element instanceof TextInterface)) {
            throw new \UnexpectedValueException('Tag head jako potomky může obsahovat pouze tagy - potomky MetadataContentne Text.');
        }
        return parent::addChildTag($element);
    }
    
    /**
     * 
     * @return GlobalAttributes
     */
    public function getAttributes() {
        return $this->attributes;
    }    
}
