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
    
    private $data = [];

    public function __construct(ViewInterface $view) {
        $this->view = $view;
    }
    
    public function getView() {
        return $this->view;
    }
        
    public function getText($data=[]) {
        return $this->view->render($data);
    }  
}
