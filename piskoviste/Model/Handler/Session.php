<?php

namespace Tester\Model\Handler;

/**
 * Handler pro session - start, get, set, has, 'sessBezi'
 *
 * @author vlse2610
 */
 class  Session implements SessionInterface {
   
    const NAME_NEJAKY_TEST_TRVA    =  'nejakyTestTrva';  
    
         
    
    public function __construct() {                           
        if (session_status() == \PHP_SESSION_NONE) {
           session_start();  
        }   
    }
    
    
 
    
//    private function sesStart () {
//        if (session_status() == \PHP_SESSION_NONE) {
//            session_start();         // obnoveni  drive ulozenych dat, vzkrisi pole $_SESSION           
//        }
//       return; 
//    }
 
//    
//    public function sesStop () {      
//            session_destroy();         // $_SESSION                   
//     return; 
//    }
    
        
    
    
    public function has($name) {
        $pom = array_key_exists($name, $_SESSION);
        return array_key_exists($name, $_SESSION);
    }
    
    /**
     * {@inheritdoc}
     */ 
    public  function get($name) {        
        $b = isset($_SESSION [$name]) ? $_SESSION [$name] : NULL;       
        $b1 = isset($_SESSION [$name]);
        
        return  isset($_SESSION [$name]) ? $_SESSION [$name] : NULL;        
    }    
    
    /**
     * 
     * @param type $name
     * @param type $value
     * @return $this
     */
    public  function set($name, $value) {
        $_SESSION [$name] = $value;
        return $this;       //fluent interface
       
        //return ;          //navrat.hodnota void
    } 
    
    public function delete($name) {
        unset( $_SESSION[$name] );
        return $this;       //fluent interface    }
    }
    
    public  function setNejakyTestTrva( ) {
        $_SESSION [self::NAME_NEJAKY_TEST_TRVA] = TRUE;
        return $this;       //fluent interface      
    } 
    public function hasNejakyTestTrva() {
        return array_key_exists(self::NAME_NEJAKY_TEST_TRVA, $_SESSION);
    }
    
    
    
    
//    /**
//     * Odstrani chlivecek
//     * @param string $name
//     */
//    public function unsetName($name) {
//        unset($_SESSION[$name]);
//        
//    }
    
}
