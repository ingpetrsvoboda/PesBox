<?php

namespace Tester\Model\Handler;

/**
 *
 * @author vlse2610
 */
interface SessionInterface {
    

    /**
     * Vrací TRUE, pokud promenná zadaného jména v session existuje, jinak FALSE
     * @param string $name Jméno
     */
    public function has($name);
    
    /**
     * @param string $name Jméno
     * @return mixed Vrací hodnotu zapsanou pod zadaným jménem
     */
    public function get($name);       
    public function set($name, $value);
    public function delete($name);
    
    public function setNejakyTestTrva( ); 
    public function hasNejakyTestTrva( );
}
