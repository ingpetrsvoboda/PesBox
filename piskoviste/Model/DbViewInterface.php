<?php

namespace Tester\Model;

/**
 *
 * @author vlse2610
 */
interface DbViewInterface {
    
    public function get($id);
    public function find($param);
}
