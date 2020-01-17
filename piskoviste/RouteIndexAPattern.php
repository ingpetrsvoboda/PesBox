<?php

/*
 * Copyright (C) 2019 pes2704
 *
 * This is no software. This is quirky text and you may do anything with it, if you like doing
 * anything with quirky texts. This text is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

$method = 'MMM';

$urlPattern = '/node/';
$routes[$method][ $urlPattern[1] ?? '/' ] = 'routa';
$preg[] = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/u', '([a-zA-Z0-9\-\_]+)', preg_quote($urlPattern)) . "$@D";

$urlPattern = '/:id/';
$routes[$method][ $urlPattern[1] ?? '/' ] = 'routa';
$preg[] = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/u', '([a-zA-Z0-9\-\_]+)', preg_quote($urlPattern)) . "$@D";

$urlPattern = '/';
$routes[$method][ $urlPattern[1] ?? '/' ] = 'routa';
$preg[] = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/u', '([a-zA-Z0-9\-\_]+)', preg_quote($urlPattern)) . "$@D";

$urlPattern = '/item/:id/';
$routes[$method][ $urlPattern[1] ?? '/' ] = 'routa';
$preg[] = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/u', '([a-zA-Z0-9\-\_]+)', preg_quote($urlPattern)) . "$@D";

//$preg[] = "@^" . preg_replace('/\\\:[a-zA-Z0-9\_\-]+/u', '([a-zA-Z0-9\-\_]+)', preg_quote($urlPattern)) . "$@D";

$a=1;