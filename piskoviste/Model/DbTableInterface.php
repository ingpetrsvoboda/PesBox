<?php

namespace Tester\Model;

/**
 *
 * @author vlse2610
 */
interface DbTableInterface extends DbViewInterface {
    
    //public function find();
    public function save($data);
}
