<?php

namespace Pes\View\Tag;

use Pes\View\Tag\TagInterface;
use Pes\View\Node\NodeInterface;


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
    
    protected $childrens = array();
    

    public function getName() {
        return $this->name;
    }
    

    public function isPairTag() {
        return $this->pairTag;
    }
    
    /**
     * Metody potomků jsou prakticky všechny stejné, ale mají v doc bloku nastavenou jinou návratovou hodnotu 
     * - příslušný objekt atributů. Našeptávání tak je funkční.
     */
    abstract function getAttributes();


    public function addChildTag(TagInterface $tag) {
        return $this->addChildNode($tag);
    }
    
    public function addChildNode(NodeInterface $node) {
        $this->childrens[] = $node;
        return $this;        
    }
    

    public function getChildrens() {
        return $this->childrens;
    }
    
    public function getText() {
        return $this->recursiveGetTextContent($this);
    }
    
    private function recursiveGetTextContent(NodeInterface $node) {
        $text = '';
        foreach($node->getChildrens() as $child) {
            if ($child instanceof TagInterface) {
                $text .= $child->getText();
            }
        }
        if ($node instanceof NodeInterface) {
            $text .= $node->getText();
        }        
    }
}

