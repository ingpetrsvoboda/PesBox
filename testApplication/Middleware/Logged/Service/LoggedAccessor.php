<?php

namespace Middleware\Logged\Service;

/**
 * Description of Logged
 *
 * @author pes2704
 */
class LoggedAccessor implements AccessorInterface {
    
    private $sessionVarName;
    
    public function __construct($sessionVarName) {
            //TODO: sem dát objekt session.
            $this->sessionVarName = $sessionVarName;
    }
    
    public function granted() {
        return isset($_SESSION [$this->sessionVarName]);
    }
}
