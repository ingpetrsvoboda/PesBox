<?php

namespace Pes\View\Node;

use Pes\View\Tag\Attributes\NullAttributes;

/**
 * Description of InnerText
 *
 * @author pes2704
 */
class Text implements NodeInterface {
    
    /**
     * @var string Textový obsah elementu
     */    
    private $text;
    
    /**
     * 
     * @param string $text Textový obsah elementu.
     */
    public function __construct($text) {
        $this->text = $text;
    }
    
    /**
     * Vrací text zadaný v konstruktoru
     * @return string
     */
    public function getText() {
        return $this->text;
    } 
}
