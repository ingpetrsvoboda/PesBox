<?php

namespace Pes\Type;

use Psr\Log\LoggerInterface;

/**
 *
 * @author pes2704
 */
interface ContextDataInterface {
    public function setDebugMode();
    public function getDebugMode();    
    public function getStatus();
    public function setData($data);
    public function appendData($appendedData); 
    public function exchangeData($data);
    public function assign($name, $value);
}
