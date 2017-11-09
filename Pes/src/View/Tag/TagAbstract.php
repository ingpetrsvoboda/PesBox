<?php

namespace Pes\View\Tag;

use Pes\View\Tag\TagInterface;
use Pes\View\Node\TextInterface;


/**
 * Description of TagAbstract
 * @author pes2704
 */
abstract class TagAbstract implements TagInterface {
    
    /**
     * Párový tag je renderován s otevírací i koncovou značkou, nepárový bez koncová značky a tím, že pčáteční značka je ukončena 
     * posloupností />
     * Defaultní hodnota je pairTag=TRUE, pro povinně nepárové tagy je třeba nastavit pairTag=FALSE.
     * 
     * @var boolean 
     */
    protected $pairTag = TRUE;
    
    protected $name;
    
    /**
     * @var string Vnitřní obsah elementu
     */    
    protected $textContent='';
    
    protected $childrens = array();
    
    /**
     * Jméno tagu. Jméno tagu je nastavováno v konstruktoru a nelze ho měnit.
     * @return string
     */
    public function getName() {
        return $this->name;
    }
    
    /**
     * Informace o tom, zda je tag "párový" a má otevírací i koncovou značku (např. <tag> a </tag>) nebo povinně "nepárový" 
     * a má tedy značku např. <tag />. Nepárové jsou pouze povinně nepárové tagy, párové jsou jak povinně párové tagy, tak i volitelně párové tagy.
     * Povinně a nepovinně párové tagy se nerozlišují a jsou defaultně renderovány vždy s otevírací i koncovou značkou.
     * 
     * @return type
     */
    public function isPairTag() {
        return $this->pairTag;
    }
    
    /**
     * Vrací objekt atributů. Metody potomků jsou prakticky všechny stejné, ale mají v doc bloku nastavenou jinou návratorvou hodnotu 
     * - příslušná objekt atributů. Našeptávání tak je funkční.
     * Objekt atributů je vytvářen v konstruktoru a lze měnit jen hodnoty jeho jednotlivých vlastností - atributů.
     * 
     * @return AttributesInterface Description
     */
    abstract function getAttributes();

    /**
     * Přidá dalšího potomka - tag na konec seznamu potomků.
     * @param TagInterface $tag
     * @return $this
     */
    public function addChildTag(TagInterface $tag) {
        $this->childrens[] = $tag;
        return $this;
    }
    
    public function addChildNode(TextInterface $node) {
        $this->childrens[] = $node;
        return $this;        
    }
    
    /**
     * Vrací pole potomků tagu - pole tagů nebo nodů.
     * @return TagInterface array of
     */
    public function getChildrens() {
        return $this->childrens;
    }
}

