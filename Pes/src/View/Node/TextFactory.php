<?php

namespace Pes\View\Node;

/**
 * Description of InnerText
 *
 * @author pes2704
 */
class TextFactory implements TextInterface {
    
    /**
     *
     * @var \Closure 
     */
    private $textFactory;

    public function __construct(\Closure $textFactory) {
        $this->textFactory = $textFactory;
    }

    public function getText($data=NULL) {
        return ($this->textFactory)($data);
    }
   
}
