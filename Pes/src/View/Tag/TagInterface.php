<?php

namespace Pes\View\Tag;

use Pes\View\Node\TextInterface;
use Pes\View\Tag\Attributes\AttributesInterface;

/**
 * Description of TagInterface
 *
 * @author pes2704
 */
interface TagInterface {
    /**
     * @return AttributesInterface
     */
    public function getAttributes();
    public function getName();
    public function isPairTag();
    
    public function addChildTag(TagInterface $element);
    public function addChildNode(TextInterface $node);
    
    public function getChildrens();    
}

