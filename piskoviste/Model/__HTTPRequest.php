<?php

namespace Tester\Model;

/**
 * Description of HTTPRequest
 *
 * @author vlse2610
 */
class HTTPRequest {      
   
    private $SERVER;
    private $GET;
    private $requestMethod;
   
    
    public function __construct() {
                
        $this->SERVER = $_SERVER;
        $this->GET = $_GET;                
        $this->requestMethod =  $this->SERVER['REQUEST_METHOD'];

//        if ($requestMethod=='GET') {
//            $get = $_GET;
//            $needle = '_qf';
//            $input = array_keys($get);
//            $ret = array_keys(array_filter($input, function($var) use ($needle){return strpos($var, $needle) !== false;}  ));
//    
//        if (isset($ret) AND count($ret)) {
//            $requestQuickformGet = TRUE;
//        }        
    //$query_str = parse_url($redirectUrl, PHP_URL_QUERY);  // s touto konstantou vrací jen query
//        $identifikace_parametr_test_zGETu = filter_input(INPUT_GET,'test');
        
    }
    
    /**
     * 
     * @return boolean
     */
    public function getRequestQuickFormGet() {
        $requestQuickformGet = FALSE;
        if ($this->requestMethod == 'GET') {
            $get = $this->GET;
            
            $needle = '_qf';
            $input = array_keys($get);
            $ret = array_keys(array_filter($input, function($var) use ($needle){return strpos($var, $needle) !== false;}  ));    
            if (isset($ret) AND count($ret)) {
                $requestQuickformGet = TRUE;
            }                
        }
        return $requestQuickformGet;
    }
    
    
    /**
     * 
     * @param string jmeno parametru z Getu
     * @return type
     */
    public function getOznaceniZadosti($param ='test' ) {
        
        $oznaceniZadosti = filter_input(INPUT_GET,$param);
        return $oznaceniZadosti;
    }
    
    
public function getRequestMethod() {
    return $this->requestMethod;

}
    
    
    
}
