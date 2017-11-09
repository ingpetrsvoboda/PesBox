<?php

namespace Pes\View\Node;

use Pes\View\Tag\Attributes\NullAttributes;

/**
 * Description of InnerText
 *
 * @author pes2704
 */
class Text implements TextInterface {
    
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
    
    public function getText() {
        return $this->text;
    } 
}
