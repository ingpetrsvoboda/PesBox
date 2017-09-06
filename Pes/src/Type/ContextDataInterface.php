<?php

namespace Pes\Type;

/**
 *
 * @author pes2704
 */
interface ContextDataInterface {
    public function setDebugMode();
    public function getDebugMode();    
    public function getStatus();
    public function appendData($appendedData);  
    public function assign($name, $value);
}
