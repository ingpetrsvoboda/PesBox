<?php

namespace Tester\Model;

/**
 *
 * @author vlse2610
 */
interface PozadavekInterface extends DbTableInterface {
    
    public function find($param);     
    
    public function get($id) ;
   
    public function getPodleOznaceniPozadavku( $oznaceni );

}
