<?php

namespace Pes\View\Tag;

use Pes\View\Node\NodeInterface;
use Pes\View\Tag\Attributes\AttributesInterface;

/**
 * Description of TagInterface
 *
 * @author pes2704
 */
interface TagInterface extends NodeInterface {
    
    /**
     * Vrací objekt atributů. 
     * Objekt atributů musí být vytvořen v konstruktoru.
     * 
     * @return AttributesInterface 
     */
    public function getAttributes();
    
    /**
     * Jméno tagu. Jméno tagu je nastavováno v konstruktoru a nelze ho měnit.
     * 
     * @return string
     */
    public function getName();
    
    /**
     * Informace o tom, zda je tag "párový" a má otevírací i koncovou značku (např. <tag> a </tag>) nebo povinně "nepárový" 
     * a má tedy značku např. <tag />. 
     * 
     * Párový tag má počáteční a koncovou značku a může mít obsah - buď text (Node\Text) nebo potmkovské tagy. 
     * Jako nepárové jsou ve frameworku implementovány pouze povinně nepárové tagy, 
     * jako párové jsou implementovány povinně párové tagy, tak i volitelně párové tagy.
     * Povinně a nepovinně párové tagy se nerozlišují a jsou defaultně renderovány vždy s otevírací i koncovou značkou.
     * 
     * @return type
     */    
    public function isPairTag();
    
    /**
     * Přidá dalšího potomka - tag.
     * 
     * @param TagInterface $tag
     * @return $this
     */    
    public function addChildTag(TagInterface $element);
    
    /**
     * Přidá dalšího potomka - node.
     * 
     * @param TagInterface $tag
     * @return $this
     */    
    public function addChildNode(NodeInterface $node);
    
    /**
     * Vrací pole potomků tagu - pole tagů nebo nodů.
     * @return TagInterface array of
     */    
    public function getChildrens();
}

