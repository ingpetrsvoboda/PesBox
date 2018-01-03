<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Pes\Http;

use Pes\Collection\MapCollection;
/**
 * Description of Environment
 *
 * @author pes2704
 */
class Environment extends MapCollection {
    public function __construct($array) {
        parent::__construct($array);
    }
}
