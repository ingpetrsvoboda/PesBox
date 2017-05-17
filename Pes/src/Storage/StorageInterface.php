<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author pes2704
 */
interface Framework_Storage_StorageInterface {

    public function get($key);
    public function set($key, $value);
    public function remove($key);
}
