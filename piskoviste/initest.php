<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
echo "<pre>";
print_r(parse_ini_string('
php_ext_dir = ${extension_dir}
operating_system = ${OS}
production = ${production}
development = ${development}
computername = ${computername}
path = ${path}

'));
echo "</pre>";
phpinfo();
?>