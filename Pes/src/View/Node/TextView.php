<?php

namespace Pes\View\Node;

use Pes\View\ViewInterface;

/**
 * Description of InnerText
 *
 * @author pes2704
 */
class TextView implements TextViewInterface {

    /**
     * @var ViewInterface 
     */
    private $view;

    /**
     * Prijímá View určený ge generování textového obsahu. View generuje (lazy) textový obsah s použitím dat zadaných při 
     * volání matody getText($data).
     * 
     * @param ViewInterface $view
     */
    public function __construct(ViewInterface $view) {
        $this->view = $view;
    }
    
    /**
     * 
     * @return ViewInterface
     */
    public function getView(): ViewInterface {
        return $this->view;
    }
        
    public function getText($data=[]) {
        return $this->view->render($data);
    }  
}
