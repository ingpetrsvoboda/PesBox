<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

define('DEV', 3);
define('NEW_DEV', 5);
define('OLD', DEV);
use const NEW_DEV as DEV;
var_dump(DEV);
use const OLD as DEV;
var_dump(DEV);