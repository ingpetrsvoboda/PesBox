<?php

/*
 * Copyright (C) 2019 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
$str = 'abcdef';
$test = 'qq';
$endsWith = strrpos($str, $test) == strlen($str) - strlen($test);
$endsWith = substr( $str, -strlen( $test ) ) == $test;
$endsWith = substr_compare($str, $test, strlen($str)-strlen($test), strlen($test)) === 0;
$endsWith = substr_compare( $str, $test, -strlen( $test ) ) === 0;

$serviceName = 'BlablaInterface';
$realName = substr($serviceName, 0, -9);
$a=1;