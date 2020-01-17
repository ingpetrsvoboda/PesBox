<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of corePath
 *
 * @author pes2704
 */
class corePath {
    
    private $instance;
    private $corePath;
    private $relativePathPrefix;
    
    public function __construct() {
        if (!$this->corePath) {
            $this->corePath = dirname(dirname(dirname(__FILE__))) . DIRECTORY_SEPARATOR;
            $relative = substr(__FILE__, strlen($this->corePath)-1);
        }        
    }
    
    public function getCorePath() {
        return $this->corePath;
    }

}

$cP =new corePath();
echo $cP->getCorePath();